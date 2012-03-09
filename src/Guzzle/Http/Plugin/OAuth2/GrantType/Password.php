<?php

namespace Guzzle\Http\Plugin\OAuth2\GrantType;

use Guzzle\Http\Client;

class Password implements GrantTypeInterface
{
    /*
     * @param array $config Configuration array containing these parameters:
     *     string 'consumer_key'    OAuth application key
     */
    function __construct(array $scope = array(), array $additionalParameters = array())
    {
    }

    function requestAccessToken(Client $authClient)
    {
        // ?grant_type=client_credentials
    }
}