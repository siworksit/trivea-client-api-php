<?php

require 'vendor/autoload.php';

use Siworks\Trivea\Provider\Keycloak;
use Siworks\Trivea\Resources\Checkouts;

$provider = new Keycloak(
    "frontend-service",
    "siworks",
    "http://kc.trivea.com.br:8180/",
    "admin",
    "admin"
);

$checkouts = new Checkouts($provider, ['apiUrl' => 'http://localhost:8080']);
/*
   {
        "amount":10.00,
        "type": "TRANSACTION",
        "merchant":"0f800a43-d4e5-43c1-8d84-71b7fec8c32c",
        "subTotal":10.00
    }
 */
$result = $checkouts->CreateMerchantTransaction([
   'amount' => 10.00,
   'type' => 'TRANSACTION',
   "merchant"=> "0f800a43-d4e5-43c1-8d84-71b7fec8c32c",
   'subTotal' => 10.00
]);

var_dump($result->getBody()->getContents());


