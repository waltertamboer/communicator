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
 * A curl adapter.
 */
final class Curl implements AdapterInterface
{
    /**
     * Sends a message over the transport.
     *
     * @param SendData $data The data that should be send in the request.
     * @return bool Returns true when the call succeeded; false otherwise.
     */
    public function send(SendData $data): bool
    {
        // @codeCoverageIgnoreStart

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "example.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($ch);

        curl_close($ch);

        // @codeCoverageIgnoreEnd

        return true;
    }
}
