<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Email\Transport;

use Communicator\Message;

/**
 * The interface that should be implemented by all transports.
 */
interface TransportInterface
{
    /**
     * Sends a message over the transport.
     *
     * @param array $recipients A list with all recipients that should receive the message.
     * @param Message $message The message to send.
     * @param string $subject The subject for this message.
     * @param string $text The plain text template.
     * @param null|string $html The HTML template.
     * @return void
     */
    public function send(array $recipients, Message $message, string $subject, string $text, ?string $html): void;
}
