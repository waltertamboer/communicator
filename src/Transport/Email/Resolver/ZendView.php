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
use Zend\View\Renderer\RendererInterface;

/**
 * An e-mail resolver that uses Zend\View.
 */
final class ZendView implements ResolverInterface
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var array
     */
    private $templates;

    /**
     * @var array
     */
    private $subjects;

    /**
     * Initializes a new instance of this class.
     *
     * @param RendererInterface $renderer
     * @param array $templates
     * @param array $subjects
     */
    public function __construct(RendererInterface $renderer, array $templates, array $subjects)
    {
        $this->renderer = $renderer;
        $this->templates = $templates;
        $this->subjects = $subjects;
    }

    /**
     * Resolves the subject for the given channel and type.
     *
     * @param Message $message The message to get the subject for.
     * @return null|string Returns the resolved subject as a string.
     */
    public function resolveSubject(Message $message): string
    {
        $channel = $message->getChannel();
        $locale = $message->getOptions()['locale'];

        if (!array_key_exists($channel, $this->subjects)) {
            return '';
        }

        if (!array_key_exists($locale, $this->subjects[$channel])) {
            return '';
        }

        $subject = $this->subjects[$channel][$locale];

        // Only translate when the i18n module has been loaded
        if (method_exists($this->renderer, 'translate')) {
            $subject = $this->renderer->translate($subject);
        }

        return $subject;
    }

    /**
     * Resolves the template for the given channel and type.
     *
     * @param Message $message The message to get the template for.
     * @param string $type The type of e-mail to resolve.
     * @return null|string Returns the resolved template as a string or null when no template exists.
     */
    public function resolveTemplate(Message $message, string $type): ?string
    {
        $channel = $message->getChannel();
        $locale = $message->getOptions()['locale'];

        if (!array_key_exists($channel, $this->templates)) {
            return null;
        }

        if (!array_key_exists($locale, $this->templates[$channel])) {
            return null;
        }

        if (!array_key_exists($type, $this->templates[$channel][$locale])) {
            return null;
        }

        return $this->renderer->render($this->templates[$channel][$locale][$type], $message->getParams());
    }
}
