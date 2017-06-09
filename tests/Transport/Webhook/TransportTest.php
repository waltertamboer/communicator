<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Webhook;

use Communicator\Message;
use Communicator\Transport\Webhook\Adapter\AdapterInterface;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public function testSend()
    {
        // Arrange
        $message = new Message('channel', [], []);

        $sendData = new SendData();
        $sendData->recipients = [];
        $sendData->message = $message;
        $sendData->userAgent = 'waltertamboer/communicator';
        $sendData->url = 'https://www.waltertamboer.nl';

        $adapter = $this->getMockForAbstractClass(AdapterInterface::class);
        $adapter->expects(static::once())->method('send')->with(static::equalTo($sendData));

        $transport = new Transport($adapter, 'https://www.waltertamboer.nl');

        // Act
        $transport->send([], $message);

        // Assert
        // ...
    }

    public function testSendWithDifferentUserAgent()
    {
        // Arrange
        $message = new Message('channel', [], []);

        $sendData = new SendData();
        $sendData->recipients = [];
        $sendData->message = $message;
        $sendData->userAgent = 'useragent';
        $sendData->url = 'https://www.waltertamboer.nl';

        $adapter = $this->getMockForAbstractClass(AdapterInterface::class);
        $adapter->expects(static::once())->method('send')->with(static::equalTo($sendData));

        $transport = new Transport($adapter, 'https://www.waltertamboer.nl');
        $transport->setUserAgent('useragent');

        // Act
        $transport->send([], $message);

        // Assert
        // ...
    }
}
