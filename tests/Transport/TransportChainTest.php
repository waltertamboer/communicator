<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport;

use Communicator\Message;
use PHPUnit\Framework\TestCase;

final class TransportChainTest extends TestCase
{
    public function testSend()
    {
        // Arrange
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $transport->expects(static::once())->method('send');

        $chain = new TransportChain();
        $chain->addTransport($transport);

        // Act
        $chain->send([], new Message('channel', [], []));

        // Assert
        // ...
    }
}
