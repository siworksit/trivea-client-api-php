<?php

require 'vendor/autoload.php';

use Siworks\Trivea\Http\Client;

$client = new Client([
        'KEYCLOAK_SERVER_URL' => "http://kc.trivea.com.br:8180/",
        'KEYCLOAK_REALM'         => "siworks",
        'KEYCLOAK_CLIEND_ID'      => "frontend-service",
        'KEYCLOAK_GRANT_TYPE'    => "password",
        'KEYCLOAK_USERNAME'      => "admin",
        'KEYCLOAK_PASSWORD'      => "admin",
        //'redirectUri'   => 'http://127.0.0.1:8003/auth',
]);

var_dump($client);
