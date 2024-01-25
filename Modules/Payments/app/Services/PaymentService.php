<?php

namespace Modules\Payments\app\Services;

use Modules\Payments\app\Interfaces\PaymentGateway;

class PaymentService
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function processPayment($data)
    {
        return $this->paymentGateway->processPayment($data);
    }
}
