<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Configuration;
use Illuminate\Http\Request;

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
}
