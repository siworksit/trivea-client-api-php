<?php

namespace Siworks\Trivea\Resources;

abstract class Resource
{
    /**
     * @var \Siworks\Trivea\Http\Client
     */
    protected $client;

    /**
     * @var  Array
     */
    protected $config;

    /**
     * @var String
     */
    protected $apiUrl;

    /**
     * Makin' a good old resource.
     *
     * @param \Siworks\Trivea\Http\Client $client
     */
    public function __construct(object $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
        $this->apiUrl = $config['apiUrl'];
    }

    /**
     * Convert a time, DateTime, or string to a millisecond timestamp.
     *
     * @param null|\DateTime|int $time
     *
     * @return null|int
     */
    protected function timestamp($time)
    {
        return ms_timestamp($time);
    }

    /**
     * @return \Siworks\Trivea\Http\Client
     */
    public function getClient()
    {
        return $this->client;
    }


}
