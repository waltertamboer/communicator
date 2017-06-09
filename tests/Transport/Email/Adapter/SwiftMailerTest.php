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
use Swift_Mailer;

final class SwiftMailerTest extends TestCase
{
    public function testGetSetFromAddress()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(Swift_Mailer::class);
        $mailerBuilder->disableOriginalConstructor();

        $transport = new SwiftMailer($mailerBuilder->getMock());

        // Act
        $transport->setFromAddress('from');

        // Assert
        static::assertEquals('from', $transport->getFromAddress());
    }

    public function testGetSetFromName()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(Swift_Mailer::class);
        $mailerBuilder->disableOriginalConstructor();

        $transport = new SwiftMailer($mailerBuilder->getMock());

        // Act
        $transport->setFromName('name');

        // Assert
        static::assertEquals('name', $transport->getFromName());
    }

    public function testSendWithoutAddresses()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(Swift_Mailer::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::never())->method('send');


        $transport = new SwiftMailer($mailer);

        $message = new Message('channel', [], []);

        // Act
        $transport->send([], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }

    public function testSendWithAddresses()
    {
        // Arrange
        $recipient = $this->getMockForAbstractClass(RecipientInterface::class);
        $recipient->expects(static::once())->method('getNotificationRecipientAddresses')->willReturn([
            'my@email.com'
        ]);

        $mailerBuilder = $this->getMockBuilder(Swift_Mailer::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::once())->method('send');
        $mailer->expects(static::once())->method('createMessage')->willReturn(new \Swift_Message());

        $transport = new SwiftMailer($mailer);

        $message = new Message('channel', [], []);

        // Act
        $transport->send([
            $recipient,
        ], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }

    public function testSendWithAddressesAndFrom()
    {
        // Arrange
        $recipient = $this->getMockForAbstractClass(RecipientInterface::class);
        $recipient->expects(static::once())->method('getNotificationRecipientAddresses')->willReturn([
            'my@email.com'
        ]);

        $swiftMessage = $this->getMockBuilder(\Swift_Message::class)->disableOriginalConstructor()->getMock();
        $swiftMessage->expects(static::once())->method('setFrom');

        $mailerBuilder = $this->getMockBuilder(Swift_Mailer::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::once())->method('send');
        $mailer->expects(static::once())->method('createMessage')->willReturn($swiftMessage);

        $transport = new SwiftMailer($mailer);
        $transport->setFromAddress('from');

        $message = new Message('channel', [], []);

        // Act
        $transport->send([
            $recipient,
        ], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }
}
