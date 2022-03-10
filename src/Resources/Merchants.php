<?php

namespace Siworks\Trivea\Resources;

/**
 * @see https://developers.trivea.com/docs/methods/checkout
 */
class Merchants extends Resource
{

    /**
     * Create and finish checkout transaction.
     *
     * @see https://developers.trivea.com/docs
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function create(array $properties)
    {
        $uri = '/user/checkouts';

        return $this->client->request(
            'post',
            $this->apiUrl .uri,
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
    public function CreateMerchantTransaction(array $properties)
    {
        $uri = '/user/checkouts';

        return $this->client->request(
            'post',
            $this->apiUrl .uri,
            $properties
        );
    }

}
