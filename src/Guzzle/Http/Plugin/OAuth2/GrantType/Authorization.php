<?php

namespace Guzzle\Http\Plugin\OAuth2\GrantType;

use Guzzle\Http\Client;

class Authorization implements GrantTypeInterface
{
    protected $client_id;

    protected $client_secret;

    function __construct(array $scope = array(), array $additionalParameters = array())
    {
    }

    function setClientCredentials($client_id, $client_secret)
    {
        $this->client_id     = $client_id;
        $this->client_secret = $client_secret;
    }

    function requestAccessToken(Client $authClient)
    {
        // ?response_type=code
    }
}