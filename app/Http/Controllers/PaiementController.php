<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Paiement;
use App\Models\Configuration;
use App\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\FedaPayService;

class PaiementController extends Controller
{
    protected $fedapayService;

    public function __construct(FedaPayService $fedapayService)
    {
        $this->fedapayService = $fedapayService;
    }

    public function index()
    {
        $defaultPaymentDateQuery = Configuration::where('type', 'PAYEMENT_DATE')->first();
        $defaultPaymentDate = $defaultPaymentDateQuery->value;
        $convertedPaymentDate = intval($defaultPaymentDate);
        $today = date('d');

        $isPaymentDay = false;

        if ($today == $convertedPaymentDate) {
            $isPaymentDay = true;
        }
        $paymnts = Paiement::latest()->orderBy('id', 'desc')->paginate(10);
        return view('paymnt.index', compact('paymnts', 'isPaymentDay'));
    }

    public function initPayment()
    {
        $monthMapping = [
            'JANUARY' => 'JANVIER', 'FEBRUARY' => 'FEVRIER', 'MARCH' => 'MARS', 'APRIL' => 'AVRIL',
            'MAY' => 'MAI', 'JUNE' => 'JUIN', 'JULY' => 'JUILLET', 'AUGUST' => 'AOUT',
            'SEPTEMBER' => 'SEPTEMBRE', 'OCTOBER' => 'OCTOBRE', 'NOVEMBER' => 'NOVEMBRE', 'DECEMBER' => 'DECEMBRE'
        ];

        $currentMonth = strtoupper(Carbon::now()->isoFormat('MMMM'));
        $currentMonthInfrench = $monthMapping[$currentMonth] ?? '';
        $currentYear = strtoupper(Carbon::now()->isoFormat('Y'));

        // Liste des employers qui n'ont pas encore été payés pour le mois en cours
        $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonthInfrench, $currentYear) {
            $query->where('month', '=', $currentMonthInfrench)
                ->where('year', '=', $currentYear);
        })->get();

        if ($employers->count() == 0) {
            return redirect()->back()->with('error_message', 'Tous vos employers ont été déjà payés pour ce mois de ' . $currentMonthInfrench);
        }

        // Faire le paiement pour ces employers
        foreach ($employers as $employer) {
            $aEtePayer = $employer->payments()->where('month', '=', $currentMonthInfrench)
                ->where('year', '=', $currentYear)->exists();

            if (!$aEtePayer) {
                $salaire = $employer->montant_journalier * 31;

                $callbackUrl = route('payment.callback');
                $token = $this->fedapayService->createTransaction($salaire, 'Salaire du mois de ' . $currentMonthInfrench, $callbackUrl);

                return redirect()->away("https://sandbox-checkout.fedapay.com/{$token}");
            }
        }

        return redirect()->back()->with('success_message', 'Paiement des employers effectué pour le mois ' . $currentMonthInfrench);
    }

  
    public function paymentCallback(PaymentRequest $request)
{
    // Récupérer les informations de la transaction depuis la requête
    $transactionId = $request->input('transaction_id');
    $transactionStatus = $request->input('status');

    // Rechercher le paiement dans la base de données en utilisant l'ID de la transaction
    $paiement = Paiement::where('reference', $transactionId)->first();

    if ($paiement) {
        // Mettre à jour le statut du paiement en fonction du statut retourné par FedaPay
        if ($transactionStatus === 'approved' || $transactionStatus === 'completed') {
            $paiement->status = 'SUCCESS';
            $paiement->done_time = now();
        } else {
            $paiement->status = 'FAILED';
        }
        
        // Sauvegarder les changements dans la base de données
        $paiement->save();
        
        return response()->json(['status' => 'success']);
    } else {
        // Si le paiement n'a pas été trouvé, retourner une erreur
        return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
    }
}

}
