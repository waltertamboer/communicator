<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Noop;

use Communicator\Message;
use Communicator\Transport\TransportInterface;

/**
 * A no-operation transport.
 */
final class Transport implements TransportInterface
{
    /**
     * @var int
     */
    public $counter;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->counter = 0;
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
        $this->counter++;
    }
}
