<?php

namespace Guzzle\Http\Plugin\OAuth2\GrantType;

use Guzzle\Http\Client;

class ClientCredentials implements GrantTypeInterface
{
    function __construct(array $scope = array(), array $additionalParameters = array())
    {
    }

    function requestAccessToken(Client $authClient)
    {
        // ?response_type=token
    }
}