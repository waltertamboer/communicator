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
use PHPMailer as PHPMailerInstance;
use PHPUnit\Framework\TestCase;

final class PHPMailerTest extends TestCase
{
    public function testGetSetFromAddress()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(PHPMailerInstance::class);
        $mailerBuilder->disableOriginalConstructor();

        $transport = new PHPMailer($mailerBuilder->getMock());

        // Act
        $transport->setFromAddress('from');

        // Assert
        static::assertEquals('from', $transport->getFromAddress());
    }

    public function testGetSetFromName()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(PHPMailerInstance::class);
        $mailerBuilder->disableOriginalConstructor();

        $transport = new PHPMailer($mailerBuilder->getMock());

        // Act
        $transport->setFromName('name');

        // Assert
        static::assertEquals('name', $transport->getFromName());
    }

    public function testSendWithoutAddresses()
    {
        // Arrange
        $mailerBuilder = $this->getMockBuilder(PHPMailerInstance::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::never())->method('send');


        $transport = new PHPMailer($mailer);

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

        $mailerBuilder = $this->getMockBuilder(PHPMailerInstance::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::once())->method('send');

        $transport = new PHPMailer($mailer);
        $transport->setFromAddress('from');

        $message = new Message('channel', [], []);

        // Act
        $transport->send([
            $recipient,
        ], $message, 'subject', 'text', 'html');

        // Assert
        // ...
    }

    public function testSendWithOnlyPlainText()
    {
        // Arrange
        $recipient = $this->getMockForAbstractClass(RecipientInterface::class);
        $recipient->expects(static::once())->method('getNotificationRecipientAddresses')->willReturn([
            'my@email.com'
        ]);

        $mailerBuilder = $this->getMockBuilder(PHPMailerInstance::class);
        $mailerBuilder->disableOriginalConstructor();

        $mailer = $mailerBuilder->getMock();
        $mailer->expects(static::once())->method('send');

        $transport = new PHPMailer($mailer);
        $transport->setFromAddress('from');

        $message = new Message('channel', [], []);

        // Act
        $transport->send([
            $recipient,
        ], $message, 'subject', 'text', null);

        // Assert
        // ...
    }
}
