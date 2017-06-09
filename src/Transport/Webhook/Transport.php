<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Webhook;

use Communicator\Message;
use Communicator\Transport\TransportInterface;
use Communicator\Transport\Webhook\Adapter\AdapterInterface;

/**
 * A transport that triggers a web hook.
 */
final class Transport implements TransportInterface
{
    /**
     * The adapter that is used to send the request.
     *
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * The url to call.
     *
     * @var string
     */
    private $url;

    /**
     * The user agent used to pass along during the request.
     *
     * @var string
     */
    private $userAgent;

    /**
     * Initializes a new instance of this class.
     *
     * @param AdapterInterface $adapter
     * @param string $url
     */
    public function __construct(AdapterInterface $adapter, string $url)
    {
        $this->adapter = $adapter;
        $this->url = $url;
        $this->userAgent = 'waltertamboer/communicator';
    }

    /**
     * Gets the value of field "url".
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Gets the value of field "userAgent".
     *
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * Sets the value of field "userAgent".
     *
     * @param string $userAgent
     */
    public function setUserAgent(string $userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * Sends the message.
     *
     * @param array $recipients A list with all recipients that should receive the message.
     * @param Message $message The message to send.
     * @return void
     */
    public function send(array $recipients, Message $message): void
    {
        $data = new SendData();
        $data->recipients = $recipients;
        $data->message = $message;
        $data->url = $this->getUrl();
        $data->userAgent = $this->getUserAgent();

        $this->adapter->send($data);
    }
}
