<?php

namespace App\Services;

use FedaPay\FedaPay;
use FedaPay\Transaction;

class FedaPayService
{
    public function __construct()
    {
        FedaPay::setApiKey(env('FEDAPAY_SECRET_KEY'));
        FedaPay::setEnvironment('sandbox'); // Utiliser 'live' pour la production
    }

    public function createTransaction($amount, $description, $callbackUrl)
    {
        $transaction = Transaction::create([
            'amount' => $amount,
            'currency' => 'XOF',
            'description' => $description,
            'callback_url' => $callbackUrl
        ]);

        return $transaction->generateToken();
    }
}
