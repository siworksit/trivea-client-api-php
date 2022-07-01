<?php

namespace Siworks\Trivea\Resources;

/**
 * @see https://developers.trivea.com/docs/methods/checkout
 */
class Checkouts extends Resource
{

    /**
     * Create and finish checkout transaction.
     *
     * @see https://developers.trivea.com/docs
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function createCheckout(array $properties)
    {
        $uri = '/page/checkouts';

        return $this->client->request(
            'post',
            $this->apiUrl . $uri,
            $properties
        );
    }

    /**
     * Create a open checkout transaction.
     *
     * @see https://developers.trivea.com/docs
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function createTransaction(array $properties)
    {
        $uri = '/user/checkouts';

        return $this->client->request(
            'post',
            $this->apiUrl .$uri,
            $properties
        );
    }

}
