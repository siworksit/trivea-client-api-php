<?php

require 'vendor/autoload.php';

use Siworks\Trivea\Provider\Keycloak;
use Siworks\Trivea\Resources\Keycloak as keycloakResource;


/**
 * INICIO - API TRIVEA
 * EXEMPLO DE CRIACAO DE CHECKOUT
 *
 */
$provider = new Keycloak(
        [
            "clientId" => "frontend-service",
            "secret" => 'secret',
            "url" => "http://kc.trivea.com.br:8180/",
            "realm" => "dev-trivea",
            "grant_type" => "password",
            "username" => "admin",
            "password" => "admin"
        ]
);

$clientKeycloak = new keycloakResource($provider, ['apiUrl' => 'http://kc.trivea.com.br:8180']);
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
        "realmRoles" => ["free"]
    ]
);

/**
 * Set ROLE to USER
 * */
//$clientKeycloak->setRoleToUser(, prope)

$res = $result->getBody()->getContents();
$res = json_decode($res);

echo "http status=";
print_r($result->getStatusCode());
echo "\n";
print_r($result->getHeaderLine("Location"));
