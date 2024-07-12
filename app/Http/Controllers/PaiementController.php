<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Configuration;
use App\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function index(){
        $defaultPaymentDateQuery = Configuration::where('type','PAYEMENT_DATE')->first();
        $defaultPaymentDate = $defaultPaymentDateQuery->value;
        $convertedPaymentDate = intval($defaultPaymentDate);
        $today = date('d');

        $isPaymentDay = false;

        if ($today == $convertedPaymentDate) {
            $isPaymentDay = true;
         }
        $paymnts = Paiement::latest()->orderBy('id','desc')->paginate(10);
        return view('paymnt.index',compact('paymnts','isPaymentDay'));
    }

    public function initPayment(){
        $monthMapping = ['JANUARY'=>'JANVIER','FEBRUARY'=>'FEVRIER', 
        'MARCH'=>'MARS','APRIL'=> 'AVRIL',
        'MAY'=>'MAI','JUNE'=> 'JUIN',
        'JULY'=>'JUILLET','AUGUST'=> 'AOUT',
        'SEPTEMBER'=>'SEPTEMBRE','OCTOBER'=> 'OCTOBRE',
        'NOVEMBER'=>'NOVEMBRE','DECEMBER'=> 'DECEMBRE'];

        $currentMonth = strtoupper(Carbon::now()->isoFormat('MMMM'));

        $currentMonthInfrench = $monthMapping[$currentMonth] ?? '';

        $currentYear = strtoupper(Carbon::now()->isoFormat('Y'));

        // Simuler les paiements pour tous les employers dans le mois n cours. Les
        // paiements concerne les employers qui n'ont pas encors été payé dans le mois actuelle


        //liste des employer qui n'ont pas encors été payé pour le mois en cours
        $employers = Employer::whereDoesntHave('payments', function($query) 
        use ($currentMonthInfrench, $currentYear) {
            $query->where('month', '=', $currentMonthInfrench)
            ->where('year', '=', $currentYear);
        })->get();

        if ($employers->count() == 0) {
            return redirect()->back()->with('error_message', 'Tous vos employers ont été déjà payer pour ce mois de '.$currentMonthInfrench);
        }
        
        //faire le paiement pour ces employer

        foreach ($employers as $employer) {
            $aEtePayer = $employer->payments()->where('month', '=', $currentMonthInfrench)
            ->where('year', '=', $currentYear)->exists();

            if (!$aEtePayer) {
                $salaire = $employer->montant_journalier * 31;

                $paymnt = new Paiement([
                    'reference'=> strtoupper(Str::random(10)),
                    'employer_id'=> $employer->id,
                    'amount'=> $salaire,
                    'launch_date'=> now(),
                    'done_time'=> now(),
                    'status'=>'SUCCESS',
                    'month'=> $currentMonthInfrench,
                    'year'=> $currentYear
                ]);

                $paymnt->save();

            }
        }
        
        //rediriger

        return redirect()->back()->with('success_message','Paiement des employers 
        éffectuer pour le mois '.$currentMonthInfrench);
    }
}
