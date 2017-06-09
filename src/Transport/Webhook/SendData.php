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

/**
 * A value object containing all data to be send.
 */
final class SendData
{
    /**
     * @var array
     */
    public $recipients;

    /**
     * @var Message
     */
    public $message;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $userAgent;
}
