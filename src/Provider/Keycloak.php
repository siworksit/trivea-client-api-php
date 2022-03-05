<?php

namespace Siworks\Trivea\Provider;

use GuzzleHttp\Client as GuzzleClient;
use Keycloak\Exception\KeycloakCredentialsException;
use Keycloak\Exception\KeycloakException;

use Keycloak\KeycloakClient;
use Psr\Http\Message\ResponseInterface;

class Keycloak extends KeycloakClient
{

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $accessToken;


    /**
     * KeycloakClient constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $realm
     * @param string $url
     */
    public function __construct(
        string $clientId,
        string $realm,
        string $url,
        string $username,
        string $password
    ) {
        $this->guzzleClient = new GuzzleClient(['base_uri' => "$url/auth/admin/realms/$realm/"]);
        $this->clientId = $clientId;
        $this->url = $url;
        $this->realm = $realm;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $body
     * @param array $headers
     * @return ResponseInterface
     * @throws KeycloakException
     */
    public function request(string $method, string $uri, $body = null, array $headers = []): ResponseInterface
    {
        try {
            $accessToken = $this->getAccessToken();
        } catch (Exception $ex) {
            throw new KeycloakCredentialsException();
        }

        if ($body !== null) {
            $headers['Content-Type'] = 'application/json';
        }

        /* $request = $this->authenticatedRequest(
            $method,
            $uri,
            $accessToken,
            ['headers' => $headers, 'body' => json_encode($body)]
        ); */

        try {
            return $this->authenticatedRequest(
                $method,
                $uri,
                $accessToken,
                ['headers' => $headers, 'body' => json_encode($body)]
            );
            // return $this->guzzleClient->send($request);
        } catch (GuzzleException $ex) {
            throw new KeycloakException(
                $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }
    }

    protected function authenticatedRequest(string $method, string $uri, string $accessToken, $options){


        $options['headers'] = empty($options['headers']) ? [] : $options['headers'];
        $options['headers']['Authorization'] = "Bearer ".$accessToken;

        return  $this->guzzleClient->request($method, $uri, $options);
    }

    public function getAccessToken(){

        if($this->accessToken){
            return $this->accessToken;
        }else{

            $guzzleClient = new GuzzleClient(['base_uri' => "{$this->url}"]);
            $headers = []; // 'Content-Type' => 'application/json'
            $form_params = [
                'client_id' => $this->clientId,
                'username' => $this->username,
                'password' => $this->password,
                'grant_type' => 'password'
            ];
            $response = $guzzleClient->request("POST", "/auth/realms/{$this->realm}/protocol/openid-connect/token", compact("headers", "form_params"));

            $object = json_decode((string) $response->getBody());
            $this->accessToken = $object->access_token;
            return $this->accessToken;
        }
    }

}