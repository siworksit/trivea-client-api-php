<?php

namespace Siworks\Trivea\Resources;

/**
 * @see https://developers.trivea.com/docs/methods/checkout
 */
class Keycloak extends Resource
{

    /**
     * Create User on Keycloak Trivea.
     *
     * @see https://developers.trivea.com/docs
     * @see https://www.keycloak.org/docs-api/12.0/rest-api/#_users_resource
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function createUser(array $properties)
    {
        $uri = "/admin/realms/{$properties['realm']}/users";

        return $this->client->request(
            'POST',
            $this->apiUrl . $uri,
            $properties
        );
    }

    /**
     * update a User on Keycloak Trivea.
     *
     * @see https://developers.trivea.com/docs
     * @see https://www.keycloak.org/docs-api/12.0/rest-api/#_users_resource
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function updateUser(string $userId, array $properties)
    {
        $uri = "/admin/realms/{$properties['realms']}/users/{$userId}";

        return $this->client->request(
            'PUT',
            $this->apiUrl . $uri,
            $properties
        );
    }

    public function setRoleToUser(string $userId, array $properties){

        $uri = "/admin/realms/{$properties['realm']}/users/{$userId}/role-mappings/realm";

        return $this->client->request(
            'POST',
            $this->apiUrl . $uri,
            $properties
        );
    }

    /**
     * Reset user password.
     * @example "{"credentials": ["type": "password","value": "123456","temporary": false}]}
     * @see https://developers.trivea.com/docs
     * @see https://www.keycloak.org/docs-api/12.0/rest-api/#_users_resource
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function resetPassword(string $userId, array $properties)
    {
        $uri = "/admin/realms/{$properties['realm']}/users/{$userId}";

        return $this->client->request(
            'PUT',
            $this->apiUrl . $uri,
            $properties
        );
    }

    /**
     * Create a open checkout transaction.
     *
     * @see https://developers.trivea.com/docs
     * @see https://www.keycloak.org/docs-api/12.0/rest-api/#_users_resource
     *
     * @return \Siworks\Trivea\Http\Response
     */
    public function deleteUser(string $userId, array $properties)
    {
        $uri = "/admin/realms/{$properties['realm']}/users/{$userId}";

        return $this->client->request(
            'DELETE',
            $this->apiUrl . $uri,
            $properties
        );
    }

}
