<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Webhook\Adapter;

use Communicator\Message;
use Communicator\Transport\Webhook\SendData;
use PHPUnit\Framework\TestCase;

final class CurlTest extends TestCase
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

        $adapter = new Curl();

        // Act
        $result = $adapter->send($sendData);

        // Assert
        static::assertTrue($result);
    }
}
