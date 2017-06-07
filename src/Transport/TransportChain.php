<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport;

use Communicator\Message;

/**
 * The transport chain will send a notification to all instances in the chain.
 */
class TransportChain implements TransportInterface
{
    /**
     * @var TransportInterface[]
     */
    private $chain;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->chain = [];
    }

    /**
     * Adds the given transport to the chain.
     *
     * @param TransportInterface $transport The transport to add.
     */
    public function addTransport(TransportInterface $transport): void
    {
        $this->chain[] = $transport;
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
        foreach ($this->chain as $transport) {
            $transport->send($recipients, $message);
        }
    }
}
