<?php

namespace Modules\Payments\app\Interfaces;

interface PaymentGateway
{
    public function processPayment($data);
    public function thirdPartyPayment($data);
}
