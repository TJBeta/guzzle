<?php

namespace Guzzle\Http\Plugin\OAuth2\TokenType;

class Bearer implements TokenTypeInterface {
    /**
     * {@inheritdoc}
     */
    public function getAuthDescriptor()
    {
        return 'Bearer';
    }

    /**
     * {@inheritdoc}
     */
    public function createAuthHeader($access_token)
    {
        return "Authorization: Bearer {$access_token}";
    }
}