<?php

namespace Modules\Payments\app\Services;

use Braintree\Gateway;
use Exception;
use Modules\Payments\app\Interfaces\PaymentGateway;

class BraintreePaymentService implements PaymentGateway
{
    private $braintree;

    public function __construct()
    {
        $this->braintree = new Gateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchant_id'),
            'publicKey' => config('braintree.publicKey'),
            'privateKey' => config('braintree.privateKey')
        ]);
    }

    public function processPayment($data)
    {
        $transaction = $this->braintree->transaction()->sale([
            'amount' => $data['amount'],
            'paymentMethodToken' => $data['cardToken'],
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($transaction->success) {
            return $transaction;
        } else {
            $error = $transaction->errors->deepAll()[0]->message;
            throw new Exception('payment failed: ' . $error);
        }
    }

    public function thirdPartyPayment($data)
    {
        $transaction = $this->braintree->transaction()->sale([
            'amount' => $data['amount'],
            'merchantAccountId' => config("braintree.merchant_account_id"),
            'paymentMethodNonce' => $data['nonce'],
            'deviceData' => $data['deviceData'],
            'options' => [
                'submitForSettlement' => true
            ],
            'billing' => [
                'postalCode' => "54000"
            ]
        ]);

        if($transaction->success) {
            return $transaction;
        } else {
            $error = $transaction->transaction->status;
            throw new Exception("payment failed: " . $error);
        }
    }
}
