<?php

namespace Guzzle\Http\Plugin\OAuth2\TokenType;

/**
 * @link http://tools.ietf.org/html/draft-ietf-oauth-v2-http-mac-00
 */
class Mac implements TokenTypeInterface {
    /**
     * {@inheritdoc}
     */
    public function getAuthDescriptor()
    {
        return 'MAC';
    }

    /**
     * {@inheritdoc}
     */
    public function createAuthHeader($access_token)
    {
        
    }
}