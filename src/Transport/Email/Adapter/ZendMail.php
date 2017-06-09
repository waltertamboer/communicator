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
use Zend\Mail\Message as ZendMessage;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;

/**
 * An e-mail transport that makes use of Zend\Mail.
 */
final class ZendMail extends AbstractAdapter
{
    /**
     * The mailer used to send messages.
     *
     * @var TransportInterface
     */
    private $transport;

    /**
     * Initializes a new instance of this class.
     *
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
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
            /** @var ZendMessage $emailMessage */
            $emailMessage = new ZendMessage();
            $emailMessage->setSubject($subject);
            $emailMessage->setTo($address);
            $emailMessage->setBody($text);
            $emailMessage->setEncoding('UTF-8');

            if ($this->getFromAddress() !== null) {
                $emailMessage->setFrom($this->getFromAddress(), $this->getFromName());
            }

            $textPart = new Part($text);
            $textPart->type = 'text/plain';

            $bodyPart = new MimeMessage();
            $bodyPart->addPart($textPart);

            if ($html) {
                $htmlPart = new Part($html);
                $htmlPart->type = 'text/html';

                $bodyPart->addPart($htmlPart);
            }

            $this->transport->send($emailMessage);
        }
    }
}
