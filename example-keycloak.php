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
    "frontend-service",
    "siworks",
    "http://kc.trivea.com.br:8180/",
    "admin",
    "admin"
);

$clientKeycloak = new Keycloak($provider, ['apiUrl' => 'http://kc.trivea.com.br:8180']);
/*
    {
        "firstName":"teste do ng",
        "lastName":"teste do ng",
        "email":"test@test.com",
        "enabled":"true",
        "username":"user-shopgrid",
        "credentials": [
            {
                "type": "password",
                "value": "123456",
                "temporary": false
            }
        ]
    }
 */
$result = $clientKeycloak->createUser(
    [
        "firstName" => "teste do ng",
        "lastName" => "teste do ng",
        "email"=> "test@testdong.com",
        "enabled"=> "true",
        "emailVerified"=> true,
        "username" => "user-shopgrid",
        "access" => [
            "manageGroupMembership"=> true,
            "view" => true,
            "mapRoles" => true,
            "impersonate" => true,
            "manage" => true
        ],
        "credentials" => [
                [
                    "type" => "password",
                    "value" => "1q2w3e",
                    "temporary"=> false
                ],
        ],
        "realmRoles" => [	"mb-user" ]
    ]
);

$res = $result->getBody()->getContents();
$res = json_decode($res);

var_dump($res);
