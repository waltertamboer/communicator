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
final class SwiftMailer extends AbstractTransport
{
    /**
     * The mailer used to send messages.
     *
     * @var Swift_Mailer
     */
    private $mailer;

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
     * Sends a message to the given recipient.
     *
     * @param RecipientInterface $recipient The recipient that should receive the message.
     * @param Message $message The message that should be sent.
     * @param string $subject The subject of the message.
     * @param string $text The plain text message.
     * @param null|string $html An optional HTML version of the message.
     */
    protected function sendToRecipient(
        RecipientInterface $recipient,
        Message $message,
        string $subject,
        string $text,
        ?string $html
    ): void {
        $addresses = $this->getAddresses($recipient, $message);

        foreach ($addresses as $address) {
            /** @var Swift_Message $emailMessage */
            $emailMessage = $this->mailer->createMessage();
            $emailMessage->setSubject($subject);
            $emailMessage->setTo($address);
            $emailMessage->setBody($text);

            if ($this->getFromAddress() !== null) {
                $emailMessage->setFrom($this->getFromAddress(), $this->getFromName());
            }

            if ($html !== null) {
                $emailMessage->addPart($html, 'text/html');
            }

            $this->mailer->send($emailMessage);
        }
    }
}
