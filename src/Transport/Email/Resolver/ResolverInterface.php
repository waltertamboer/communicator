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

/**
 * The interface that should be implemented by resolvers.
 */
interface ResolverInterface
{
    /**
     * A html template type.
     */
    const TYPE_HTML = 'html';

    /**
     * A plain text template type.
     */
    const TYPE_TEXT = 'text';

    /**
     * Resolves the subject for the given channel and type.
     *
     * @param Message $message The message to get the subject for.
     * @return null|string Returns the resolved subject as a string.
     */
    public function resolveSubject(Message $message): string;

    /**
     * Resolves the template for the given channel and type.
     *
     * @param Message $message The message to get the template for.
     * @param string $type The type of e-mail to resolve.
     * @return null|string Returns the resolved template as a string or null when no template exists.
     */
    public function resolveTemplate(Message $message, string $type): ?string;
}
