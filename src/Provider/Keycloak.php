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
    private string $clientId;
    private string $grantType;

    private $accessToken;

    /**
     * KeycloakClient constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $realm
     * @param string $url
     */
    public function __construct(
        array $properties

    ) {
        $this->guzzleClient = new GuzzleClient(['base_uri' => "{$properties['url']}/auth/admin/realms/{$properties['realm']}/"]);
        $this->clientId = ( is_null($properties['clientId']) || empty($properties['clientId']) )? null : $properties['clientId'];
        $this->clientSecret = ( is_null($properties['secret']) || empty($properties['secret']) )? null : $properties['secret'];
        $this->grantType = ( is_null($properties['grant_type']) || empty($properties['grant_type']) )? "password" : $properties['grant_type'];
        $this->url = ( is_null($properties['url']) || empty($properties['url']) )? null : $properties['url'];
        $this->realm = ( is_null($properties['realm']) || empty($properties['realm']) )? null : $properties['realm'];
        $this->username = ( is_null($properties['username']) || empty($properties['username']) )? null : $properties['username'];
        $this->password = ( is_null($properties['password']) || empty($properties['password']) )? null : $properties['password'];;
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
            $headers = [
                "Content-Type" => "application/x-www-form-urlencoded"
            ]; // 'Content-Type' => 'application/json'

            $form_params = [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $this->username,
                'password' => $this->password,
                'grant_type' => $this->grantType,
                'scope'=> ($this->grantType != $this->password) ? null : 'openid'
            ];

            try {
                $response = $guzzleClient->request("POST", "/realms/{$this->realm}/protocol/openid-connect/token", compact("headers", "form_params"));
                $object = json_decode((string) $response->getBody());
            }catch (KeycloakException $e){
                throw $e;
            }


            $this->accessToken = $object->access_token;
            return $this->accessToken;
        }
    }

}