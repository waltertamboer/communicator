<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator\Recipient;

/**
 * The interface that should be implemented by recipients.
 */
interface RecipientInterface
{
    /**
     * Gets an array with addresses for the specific channel.
     *
     * @param string $transport The name of the transport that is sending the message.
     * @param array $parameters Optional parameters that can be used to retrieve the information.
     * @return array
     */
    public function getNotificationRecipientAddresses(string $transport, array $parameters): array;
}
