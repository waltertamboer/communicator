<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Email;

use Communicator\Message;
use Communicator\Transport\Email\Resolver\ResolverInterface;
use Communicator\Transport\Email\Transport\TransportInterface as EmailTransportInterface;
use Communicator\Transport\TransportInterface;

/**
 * The e-mail transport will send an e-mail for the given message.
 */
class Transport implements TransportInterface
{
    /**
     * @var EmailTransportInterface
     */
    private $transport;

    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * Initializes a new instance of this class.
     *
     * @param EmailTransportInterface $transport
     * @param ResolverInterface $resolver
     */
    public function __construct(EmailTransportInterface $transport, ResolverInterface $resolver)
    {
        $this->transport = $transport;
        $this->resolver = $resolver;
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
        $text = $this->resolver->resolveTemplate($message, ResolverInterface::TYPE_TEXT);
        $html = $this->resolver->resolveTemplate($message, ResolverInterface::TYPE_HTML);

        $subject = $this->resolver->resolveSubject($message);

        $this->transport->send($recipients, $message, $subject, $text, $html);
    }
}
