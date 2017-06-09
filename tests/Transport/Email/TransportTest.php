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
use Communicator\Transport\Email\Adapter\AdapterInterface;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public function testSend()
    {
        // Arrange
        $emailTransport = $this->getMockForAbstractClass(AdapterInterface::class);
        $emailTransport->expects(static::once())->method('send');

        $templateResolver = $this->getMockForAbstractClass(ResolverInterface::class);
        $templateResolver->expects(static::exactly(2))->method('resolveTemplate')->willReturn('');
        $templateResolver->expects(static::once())->method('resolveSubject');

        $transport = new Transport($emailTransport, $templateResolver);

        // Act
        $transport->send([], new Message('channel', [], []));

        // Assert
        // ...
    }
}
