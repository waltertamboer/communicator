<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator;

use Communicator\Transport\TransportInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CommunicatorTest extends TestCase
{
    /**
     * Test that event listeners can be added.
     *
     * @cover Communicator::__construct
     * @cover Communicator::addListener
     */
    public function testAddListener()
    {
        // Arrange
        $listenerCalled = false;
        $communicator = new Communicator();

        // Act
        $communicator->addListener(function () use (&$listenerCalled) {
            $listenerCalled = true;
        });

        $communicator->broadcast([], 'channel', [], []);

        // Assert
        static::assertTrue($listenerCalled);
    }

    /**
     * Test that event listeners can be added with a priority.
     *
     * @cover Communicator::__construct
     * @cover Communicator::addListener
     */
    public function testAddListenerWithPriority()
    {
        // Arrange
        $callstack = [];
        $communicator = new Communicator();

        // Act
        $communicator->addListener(function () use (&$callstack) {
            $callstack[] = 1;
        }, 1);

        $communicator->addListener(function () use (&$callstack) {
            $callstack[] = 2;
        }, 2);

        $communicator->broadcast([], 'channel', [], []);

        // Assert
        static::assertEquals([
            2,
            1
        ], $callstack);
    }

    /**
     * Test that event listeners can be removed.
     *
     * @cover Communicator::__construct
     * @cover Communicator::removeListener
     */
    public function testRemoveListener()
    {
        // Arrange
        $listenerCalled = false;
        $communicator = new Communicator();

        $callback = function () use (&$listenerCalled) {
            $listenerCalled = true;
        };

        // Act
        $communicator->addListener($callback);
        $communicator->removeListener($callback);
        $communicator->broadcast([], 'channel', [], []);

        // Assert
        static::assertFalse($listenerCalled);
    }

    /**
     * Test that transport can be bound.
     *
     * @cover Communicator::__construct
     * @cover Communicator::bindTransport
     */
    public function testBindTransport()
    {
        // Arrange
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $transport->expects(static::once())->method('send');

        $communicator = new Communicator();
        $communicator->bindTransport('channel', $transport);

        // Act
        $communicator->broadcast([], 'channel', [], []);

        // Assert
        // ...
    }

    /**
     * Test that transport can be unbound.
     *
     * @cover Communicator::__construct
     * @cover Communicator::unbindTransport
     */
    public function testUnbindTransport()
    {
        // Arrange
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $transport->expects(static::never())->method('send');

        $communicator = new Communicator();
        $communicator->bindTransport('channel', $transport);
        $communicator->unbindTransport('channel', $transport);

        // Act
        $communicator->broadcast([], 'channel', [], []);

        // Assert
        // ...
    }

    /**
     * Test that when a wrong channel is provided, an exception is thrown.
     *
     * @cover Communicator::__construct
     * @cover Communicator::unbindTransport
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The channel "channel123" does not exists.
     */
    public function testUnbindTransportWithWrongChannel()
    {
        // Arrange
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $communicator = new Communicator();

        // Act
        $communicator->unbindTransport('channel123', $transport);

        // Assert
        // ...
    }

    /**
     * Test that when a wrong transport is unbound, an exception is thrown.
     *
     * @cover Communicator::__construct
     * @cover Communicator::unbindTransport
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The provided transport is not bound for channel "channel"
     */
    public function testUnbindTransportWithWrongTransport()
    {
        // Arrange
        $transport = $this->getMockForAbstractClass(TransportInterface::class);
        $transportWrong = new Transport\Noop\Transport();

        $communicator = new Communicator();
        $communicator->bindTransport('channel', $transport);

        // Act
        $communicator->unbindTransport('channel', $transportWrong);

        // Assert
        // ...
    }
}
