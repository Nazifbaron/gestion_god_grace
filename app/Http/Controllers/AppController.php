<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employer;
use App\Models\Configuration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class AppController extends Controller
{
    //{{!--{{Hash::make('azerty')}}--}}
    public function index(){
        $totalDepartements = Departement::all()->count();
        $totalEmployers = Employer::all()->count();
        $totalAdministrateurs = User::all()->count();

        $appName = Configuration::where('type','APP_NAME')->first();

        $defaultPaymentDate = null;
        $paymentNotification ="";

        $currentDate = Carbon::now()->day;

        $defaultPaymentDateQuery = Configuration::where('type','PAYEMENT_DATE')->first();

        if($defaultPaymentDateQuery) {
            $defaultPaymentDate = $defaultPaymentDateQuery->value;
            $convertedPaymentDate = intval($defaultPaymentDate);

            if($currentDate < $convertedPaymentDate){
                $paymentNotification ="le Paiement doit avoir lieu le ".$defaultPaymentDate." de ce mois";
            }else {
                $nextMonth = Carbon::now()->addMonth();
                $nextMonthName = $nextMonth->format('F');

                $paymentNotification ="le Paiement doit avoir lieu le ".$defaultPaymentDate." du mois de ".$nextMonthName;

            }
            
        }

        return view('dashboard', compact('totalDepartements','totalEmployers','totalAdministrateurs','paymentNotification'));
    }
}
