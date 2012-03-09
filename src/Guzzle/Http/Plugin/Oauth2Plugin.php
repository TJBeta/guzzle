<?php

namespace Guzzle\Http\Plugin;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Url;
use Guzzle\Service\Inspector;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * OAuth2 signing plugin
 */
class Oauth2Plugin implements EventSubscriberInterface, \Serializable
{
    /**
     * @var Collection Configuration settings
     */
    protected $config;

    /**
     * @var *TBD* The expiration of the token
     */
    protected $tokenExpiration;

    /**
     * @var string Refresh token aquired from provider
     */
    protected $refreshToken = null;

    /**
     * @var string The all important token for providers
     */
    protected $accessToken = null;

    /**
     * Create a new OAuth2 plugin
     *
     * @param array $config Configuration array containing these parameters:
     *     string 'consumer_key'    OAuth application key
     *     string 'consumer_secret' OAuth application secret
     *     string 'auth_endpoint'   URL to initially ask for permission
     *     string 'token_endpoint'  URL (after permission granted) to exchange for permenant token
     */
    public function __construct($config)
    {
        $this->config = Inspector::prepareConfig($config, array(
            'scope'         => array()
          , 'code'          => ''
          , 'redirect_uri'  => ''
          , 'state'         => uniqid()
          , 'response_type' => null
          , 'grant_type'    => null
        ), array('consumer_key', 'consumer_secret', 'auth_endpoint', 'token_endpoint'));

        if (null === $this->config->get('grant_type') && null === $this->config->get('response_type')) {
            throw new \InvalidArgumnetException('Authorization grant type not specified. Please pass response_type or grant_type');
        }
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return !(null === $this->accessToken);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    /**
     * Request before-send event handler
     *
     * @param Event $vent Event received
     */
    public function onRequestBeforeSend(Event $event)
    {
        // All this is tailored to the Authorization Grant type - needs to be refactored to that class

        if (null === $this->refreshToken) {
            if (null === ($code = $this->config->get('code'))) {
                // Authentication hasn't even been started!
                throw new \Exception(); // will provide better Exception later
            }

            $this->requestAuthToken($code);

            // if no errors - save tokens to $this
            // otherwise, exception all the things!
        }

        // if (refresh token has expired)
            // $this->refreshAuthToken();

        $event['request']->setHeader('Authorization', '' /*tokens!!! */);
    }

    /**
     * Provides a URL to redirect the user to in order to approve the application with the provider
     *
     * @return string A full URL
     */
    public function getTokenRequestUrl()
    {
    }

    /**
     * After the user has approved the OAuth2 application request a permenant token from provider
     *
     * @param string $code Returned from the provider after successful authorization
     */
    protected function requestAuthToken($code)
    {
    }

    /**
     * Refresh the authorization token
     */
    public function refreshAuthToken()
    {
        if (null === $this->refreshToken) {
            throw new \RuntimeException('A refresh token was not given by the provider');
        }
    }

    /**
     * Serialize the OAuth2 class
     * 
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            'config'  => $this->config
          , 'expires' => $this->tokenExpiration
          , 'refresh' => $this->refreshToken
          , 'access'  => $this->accessToken
        ));
    }

    /**
     * Unserialize the OAuth2 class
     */
    public function unserialize($data)
    {
        extract(unserialize($data));

        $this->config          = $config;
        $this->tokenExpiration = $expires;
        $this->refreshToken    = $refresh;
        $this->accessToken     = $access;
    }
}