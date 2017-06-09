<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Email\Adapter;

use Communicator\Message;
use Communicator\Recipient\RecipientInterface;

/**
 * A base class for email transports.
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * The address used as a "from" address.
     *
     * @var string
     */
    private $fromAddress;

    /**
     * The name of the sender that belongs to the from address.
     *
     * @var string
     */
    private $fromName;

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
    public function send(array $recipients, Message $message, string $subject, string $text, ?string $html): void
    {
        /** @var RecipientInterface $recipient */
        foreach ($recipients as $recipient) {
            $this->sendToRecipient($recipient, $message, $subject, $text, $html);
        }
    }

    /**
     * Sends a message to the given recipient.
     *
     * @param RecipientInterface $recipient The recipient that should receive the message.
     * @param Message $message The message that should be sent.
     * @param string $subject The subject of the message.
     * @param string $text The plain text message.
     * @param null|string $html An optional HTML version of the message.
     */
    abstract protected function sendToRecipient(
        RecipientInterface $recipient,
        Message $message,
        string $subject,
        string $text,
        ?string $html
    ): void;

    /**
     * Gets the addresses for this transport.
     *
     * @param RecipientInterface $recipient
     * @param Message $message
     * @return array
     */
    protected function getAddresses(RecipientInterface $recipient, Message $message): array
    {
        $parameters = (array)$message->getOption('recipient_parameters', []);

        return $recipient->getNotificationRecipientAddresses('email', $parameters);
    }

    /**
     * Gets the value of field "fromAddress".
     *
     * @return null|string
     */
    public function getFromAddress(): ?string
    {
        return $this->fromAddress;
    }

    /**
     * Sets the value of field "fromAddress".
     *
     * @param null|string $fromAddress
     */
    public function setFromAddress(?string $fromAddress)
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * Gets the value of field "fromName".
     *
     * @return null|string
     */
    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    /**
     * Sets the value of field "fromName".
     *
     * @param null|string $fromName
     */
    public function setFromName(?string $fromName)
    {
        $this->fromName = $fromName;
    }
}
