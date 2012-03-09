<?php

namespace Guzzle\Http\Plugin\OAuth2\GrantType;

use Guzzle\Http\Client;

interface GrantTypeInterface
{
    function __construct(array $scope = array(), array $additionalParameters = array());

    function setClientCredentials($client_id, $client_secret);

    function requestAccessToken(Client $authClient);
}
