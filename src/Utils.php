<?php

namespace Siworks\Trivea;

/**
 * Class Utils.
 *
 * @method \Siworks\Trivea\Utils\OAuth2   oAuth2()
 * @method \Siworks\Trivea\Utils\Webhooks Webhooks()
 */
class Utils
{
    public function __call(string $name, $arguments = null)
    {
        $resource = 'Siworks\\Trivea\\Utils\\'.ucfirst($name);

        return new $resource();
    }

    public static function getFactory()
    {
        return new static();
    }
}
