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

/**
 * The Communicator class is the entry point for broadcasting messages.
 */
final class Communicator
{
    /**
     * The channels over which messages can be broadcasted.
     *
     * @var array
     */
    private $channels;

    /**
     * A list with event listeners that will be called when a message is broadcasted.
     *
     * @var array
     */
    private $listeners;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->channels = [];
        $this->listeners = [];

        $this->addListener([$this, 'onSend'], 0);
    }

    /**
     * Attaches a listener to the communicator.
     *
     * @param callable $listener The listener to attach.
     * @param int $priority The priority to add the listener at.
     */
    public function addListener(callable $listener, int $priority = 0): void
    {
        $this->listeners[$priority][] = $listener;
    }

    /**
     * Detaches a listener from the communicator.
     *
     * @param callable $listener The listener to attach.
     */
    public function removeListener(callable $listener): void
    {
        foreach ($this->listeners as $priority => $priorityListeners) {
            foreach ($priorityListeners as $index => $priorityListener) {
                if ($priorityListener === $listener) {
                    unset($this->listeners[$priority][$index]);
                }
            }
        }
    }

    /**
     * Binds a transport to a communication channel.
     *
     * @param string $channel The channel to bind to.
     * @param TransportInterface $transport The transport to bind.
     * @return void
     */
    public function bindTransport($channel, TransportInterface $transport): void
    {
        if (!array_key_exists($channel, $this->channels)) {
            $this->channels[$channel] = [];
        }

        $this->channels[$channel][] = $transport;
    }

    /**
     * Unbinds a transport from a communication channel.
     *
     * @param string $channel The channel to unbind from.
     * @param TransportInterface $transport The transport to unbind.
     * @return void
     * @throws InvalidArgumentException
     */
    public function unbindTransport($channel, TransportInterface $transport): void
    {
        if (!array_key_exists($channel, $this->channels)) {
            throw new InvalidArgumentException(sprintf(
                'The channel "%s" does not exists.',
                $channel
            ));
        }

        $index = array_search($transport, $this->channels[$channel]);

        if ($index === false) {
            throw new InvalidArgumentException(sprintf(
                'The provided transport is not bound for channel "%s"',
                $channel
            ));
        }

        unset($this->channels[$channel][$index]);
    }

    /**
     * Broadcasts a message to the given channel.
     *
     * @param array $recipients A list with recipients that the message will be broadcasted to.
     * @param string $channel The name of the channel to broadcast the message to.
     * @param array $params The parameters of the message.
     * @param array $options The options that should be provided to the transport.
     * @return void
     */
    public function broadcast(array $recipients, $channel, array $params, array $options = []): void
    {
        $message = new Message($channel, $params, $options);

        $this->broadcastMessage($recipients, $message);
    }

    /**
     * Sends the given message to all bound transports.
     *
     * @param array $recipients A list with recipients that the message will be broadcasted to.
     * @param Message $message The message to broadcast.
     * @return void
     */
    public function broadcastMessage(array $recipients, Message $message): void
    {
        krsort($this->listeners);

        foreach ($this->listeners as $priority => $priorityListeners) {
            foreach ($priorityListeners as $priorityListener) {
                call_user_func_array($priorityListener, [
                    'recipients' => $recipients,
                    'message' => $message,
                ]);
            }
        }
    }

    /**
     * Called when the messages can be send to the list of transports.
     *
     * @param array $recipients A list with recipients that the message will be broadcasted to.
     * @param Message $message The message to broadcast.
     * @return void
     * @internal Will be called internally once all listeners have been executed in order.
     */
    public function onSend(array $recipients, Message $message): void
    {
        if (!array_key_exists($message->getChannel(), $this->channels)) {
            return;
        }

        $transportList = $this->channels[$message->getChannel()];

        /** @var TransportInterface $transport */
        foreach ($transportList as $transport) {
            $transport->send($recipients, $message);
        }
    }
}
