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
     * Create a new OAuth2 plugin
     *
     * @param array $config Configuration array containing these parameters:
     *     string 'consumer_key'
     *     string 'consumer_secret'
     *     string 'auth_endpiont'
     *     string 'token_endpoint'
     */
    public function __construct($config)
    {
        $this->config = Inspector::prepareConfig($config, array(
        ));
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
        // check expiration lifetime on token
        // do refresh if necessary

        // attach oauth2 header(s) to request
    }

    /**
     * After the user has approved the OAuth2 application request a permenant token from provider
     */
    public function requestAuthToken()
    {
    }

    /**
     * Refresh the authorization token
     */
    public function refreshAuthToken()
    {
    }

    public function serialize()
    {
    }

    public function unserialize()
    {
    }
}