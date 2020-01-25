<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Email\Resolver;

use Communicator\Message;
use PHPUnit\Framework\TestCase;
use Laminas\View\Renderer\RendererInterface;

final class LaminasViewTest extends TestCase
{
    public function testResolveSubject()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::never())->method('render');

        $resolver = new LaminasView($renderer, [], [
            'channel' => 'subject',
        ]);

        $message = new Message('channel', [], []);

        // Act
        $result = $resolver->resolveSubject($message);

        // Assert
        static::assertEquals('subject', $result);
    }

    public function testResolveSubjectReturnsDefault()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::never())->method('render');

        $resolver = new LaminasView($renderer, [], []);

        $message = new Message('channel', [], []);

        // Act
        $result = $resolver->resolveSubject($message);

        // Assert
        static::assertEquals('', $result);
    }

    public function testResolveTemplateWithUnknownTemplate()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::never())->method('render');

        $resolver = new LaminasView($renderer, [], []);

        $message = new Message('channel', [], []);

        // Act
        $result = $resolver->resolveTemplate($message, 'type');

        // Assert
        static::assertNull($result);
    }

    public function testResolveTemplateWithInvalidLocale()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::never())->method('render');

        $resolver = new LaminasView($renderer, [
            'channel' => [],
        ], []);

        $message = new Message('channel', [], []);

        // Act
        $result = $resolver->resolveTemplate($message, 'type');

        // Assert
        static::assertNull($result);
    }

    public function testResolveTemplateWithInvalidType()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::never())->method('render');

        $resolver = new LaminasView($renderer, [
            'channel' => [
                'en' => [],
            ],
        ], []);

        $message = new Message('channel', [], [
            'locale' => 'en',
        ]);

        // Act
        $result = $resolver->resolveTemplate($message, 'type');

        // Assert
        static::assertNull($result);
    }

    public function testResolveTemplate()
    {
        // Arrange
        $renderer = $this->getMockForAbstractClass(RendererInterface::class);
        $renderer->expects(static::once())->method('render');

        $resolver = new LaminasView($renderer, [
            'channel' => [
                'en' => [
                    'type' => '',
                ],
            ],
        ], []);

        $message = new Message('channel', [], [
            'locale' => 'en',
        ]);

        // Act
        $result = $resolver->resolveTemplate($message, 'type');

        // Assert
        static::assertNull($result);
    }
}
