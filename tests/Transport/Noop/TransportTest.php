<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Noop;

use Communicator\Message;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public function testSend()
    {
        // Arrange
        $transport = new Transport();

        // Act
        $transport->send([], new Message('channel', [], []));

        // Assert
        static::assertEquals(1, $transport->counter);
    }
}
