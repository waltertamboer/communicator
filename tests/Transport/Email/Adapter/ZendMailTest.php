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
use PHPUnit\Framework\TestCase;
use Zend\Mail\Transport\TransportInterface;

final class ZendMailTest extends TestCase
{
    public function testGetSetFromAddress()
    {
        // Arrange
        $mailTransport = $this->getMockForAbstractClass(TransportInterface::class);
        $transport = new ZendMail($mailTransport);

        // Act
        $transport->setFromAddress('from');

        // Assert
        static::assertEquals('from', $transport->getFromAddress());
    }

    public function testGetSetFromName()
    {
        // Arrange
        $mailTransport = $this->getMockForAbstractClass(TransportInterface::class);
        $transport = new ZendMail($mailTransport);

        // Act
        $transport->setFromName('name');

        // Assert
        static::assertEquals('name', $transport->getFromName());
    }

    public function testSendWithoutAddresses()
    {
        // Arrange
        $mailTransport = $this->getMockForAbstractClass(TransportInterface::class);
        $mailTransport->expects(static::never())->method('send');

        $transport = new ZendMail($mailTransport);

        $message = new Message('channel', [], []);

        // Act
        $transport->send([], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }

    public function testSendWithAddress()
    {
        // Arrange
        $recipient = $this->getMockForAbstractClass(RecipientInterface::class);
        $recipient->expects(static::once())->method('getNotificationRecipientAddresses')->willReturn([
            'my@email.com'
        ]);

        $mailTransport = $this->getMockForAbstractClass(TransportInterface::class);
        $mailTransport->expects(static::once())->method('send');

        $transport = new ZendMail($mailTransport);
        $transport->setFromAddress('test@email.com');

        $message = new Message('channel', [], []);

        // Act
        $transport->send([$recipient], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }
}
