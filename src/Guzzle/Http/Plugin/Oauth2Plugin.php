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
    protected $refreshToken;

    /**
     * Create a new OAuth2 plugin
     *
     * @param array $config Configuration array containing these parameters:
     *     string 'consumer_key'    OAuth application key
     *     string 'consumer_secret' OAuth application secret
     *     string 'auth_endpoint'   URL to initially ask for permission
     *     string 'token_endpoint'  URL (after permission granted) to exchange for permenant token
     *      array 'scope'           Scope of access to reqeust of user
     *     string 'code'            (optional) The $code variable given from the provider - required if returning from authorization
     *     string 'redirect_uri'    (optional) Redirect URL from provider after authentication
     *     string 'state'           (optional) A string to prevent CSRF - plugin will generate a random string if not specified
     */
    public function __construct($config)
    {
        $this->config = Inspector::prepareConfig($config, array(
            'scope' => array()
        ), array('consumer_key', 'consumer_secret', 'auth_endpoint', 'token_endpoint'));
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
    }
}