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
        "client_id" => "backend-service",
        "client_secret" => "Bczuih5cZZsJgkqkJKNeF07KkqdYPxId",
        "url" => "https://sso.trivea.com.br/",
        "realm" => "dev-trivea",
        "grant_type" => "password",
        "username" => "lojateste",
        "password" => "lojateste"
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


