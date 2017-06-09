<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Transport\Webhook\Adapter;

use Communicator\Transport\Webhook\SendData;

/**
 * The interface for all web hook adapters.
 */
interface AdapterInterface
{
    /**
     * Sends a message over the transport.
     *
     * @param SendData $data The data that should be send in the request.
     * @return bool Returns true when the call succeeded; false otherwise.
     */
    public function send(SendData $data): bool;
}
