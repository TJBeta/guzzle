<?php

namespace Guzzle\Http\Plugin\OAuth2\TokenType;

/**
 * Depending on the responce given from acquiring an access_token
 * The provider will require each subsiquent request to be signed
 * based on a given token_type
 */
interface TokenTypeInterface {
    /**
     * @return string
     */
    function getAuthDescriptor();

    /**
     * @param string $access_token
     * @return string
     */
    function createAuthHeader($access_token);
}