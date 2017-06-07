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
use Communicator\Recipient\RecipientInterface;
use Swift_Mailer;
use Swift_Message;

/**
 * An e-mail transport that makes use of Swift Mailer.
 */
final class SwiftMailer implements TransportInterface
{
    /**
     * The mailer used to send messages.
     *
     * @var Swift_Mailer
     */
    private $mailer;

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
     * Initializes a new instance of this class.
     *
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
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
    private function sendToRecipient(
        RecipientInterface $recipient,
        Message $message,
        string $subject,
        string $text,
        ?string $html
    ): void {
        $parameters = (array)$message->getOption('recipient_parameters', []);
        $addresses = $recipient->getNotificationRecipientAddresses('email', $parameters);

        foreach ($addresses as $address) {
            /** @var Swift_Message $emailMessage */
            $emailMessage = $this->mailer->createMessage();
            $emailMessage->setSubject($subject);
            $emailMessage->setTo($address);
            $emailMessage->setBody($text);

            if ($this->getFromAddress()) {
                $emailMessage->setFrom($this->getFromAddress(), $this->getFromName());
            }

            if ($html) {
                $emailMessage->addPart($html, 'text/html');
            }

            $this->mailer->send($emailMessage);
        }
    }
}
