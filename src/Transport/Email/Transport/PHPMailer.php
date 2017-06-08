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
use PHPMailer as PHPMailerInstance;
use Swift_Message;

/**
 * An e-mail transport that makes use of PHPMailer.
 */
final class PHPMailer extends AbstractTransport
{
    /**
     * The mailer used to send messages.
     *
     * @var PHPMailerInstance
     */
    private $mailer;

    /**
     * Initializes a new instance of this class.
     *
     * @param PHPMailerInstance $mailer
     */
    public function __construct(PHPMailerInstance $mailer)
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
            $phpMailer = clone $this->mailer;
            $phpMailer->Subject = $subject;
            $phpMailer->AddAddress($address, "First name last name");

            if ($this->getFromAddress() !== null) {
                $phpMailer->From = $this->getFromAddress();
                $phpMailer->FromName = $this->getFromName();
            }

            if ($html !== null) {
                $phpMailer->Body = $html;
                $phpMailer->AltBody = $text;
            } else {
                $phpMailer->Body = $text;
            }

            $phpMailer->send();
        }
    }
}
