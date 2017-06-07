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

/**
 * A base class for email transports.
 */
abstract class AbstractTransport implements TransportInterface
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
