<?php

return [
    "environment" => env("BRAINTREE_ENVIRONMENT", 'sandbox'),
    "merchant_id" => env("BRAINTREE_MERCHANT", ''),
    "publicKey" => env("BRAINTREE_PUBLIC_KEY", ''),
    "privateKey" => env("BRAINTREE_PRIVATE_KEY", ''),
    "merchant_account_id" => env("BRAINTREE_MERCHANT_ACCOUNT", '')
];
