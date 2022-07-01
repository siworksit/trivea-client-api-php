<?php

require 'vendor/autoload.php';

use Siworks\Trivea\Provider\Keycloak;
use Siworks\Trivea\Resources\Checkouts;


/**
 * INICIO - API TRIVEA
 * EXEMPLO DE CRIACAO DE CHECKOUT
 *
 */
$provider = new Keycloak(
    [
        "clientId" => "backend-service",
        "secret" => "IRJYL6omabHxxQrmcKmAWAPezKm5c2ch",
        "url" => "http://kc.trivea.com.br:8180/",
        "realm" => "dev-trivea",
        "grant_type" => "password",
        "username" => "admin",
        "password" => "admin"
    ]
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
$result = $checkouts->createTransaction([
   'amount' => 10.00,
   'type' => 'TRANSACTION',
   "merchant"=> "0f800a43-d4e5-43c1-8d84-71b7fec8c32c",
   'subTotal' => 10.00
]);

var_dump($result->getBody()->getContents());


