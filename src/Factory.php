<?php

namespace Siworks\Trivea;

use Siworks\Trivea\Http\Client;
use Siworks\Trivea\Resources\Resource;

/**
 * Class Factory.
 *
 * @method \Siworks\Trivea\Resources\Files              files()
 * @method \Siworks\Trivea\Resources\Products           products()
 * @method \Siworks\Trivea\Resources\OAuth2             oAuth2()
 */
class Factory
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * C O N S T R U C T O R ( ^_^)y.
     *
     * @param array  $config        An array of configurations. You need at least the 'key'.
     * @param Client $client
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     */
    public function __construct(array $config = [], Client $client = null, array $clientOptions = [], bool $wrapResponse = true)
    {
        if (is_null($client)) {
            $client = new Client($config, null, $clientOptions, $wrapResponse);
        }
        $this->client = $client;
    }

    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param mixed $args
     */
    public function __call(string $name, $args): Resource
    {
        $resource = 'Siworks\\Trivea\\Resources\\'.ucfirst($name);

        return new $resource($this->client, ...$args);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Create an instance of the service with an API key.
     *
     * @param string $api_key       trivea API key
     * @param Client $client        an Http client
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function create(string $api_key = null, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $api_key], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an OAuth token.
     *
     * @param string $token         trivea oauth access token
     * @param Client $client        an Http client
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function createWithToken(string $token, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $token, 'oauth' => true], $client, $clientOptions, $wrapResponse);
    }

    /**
     * Create an instance of the service with an OAuth2 token.
     *
     * @param string $token         trivea OAuth2 access token
     * @param Client $client        an Http client
     * @param array  $clientOptions options to be send with each request
     * @param bool   $wrapResponse  wrap request response in own Response object
     *
     * @return static
     */
    public static function createWithOAuth2Token(string $token, Client $client = null, array $clientOptions = [], bool $wrapResponse = true): self
    {
        return new static(['key' => $token, 'oauth2' => true], $client, $clientOptions, $wrapResponse);
    }
}
