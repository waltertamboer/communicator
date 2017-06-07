<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator;

/**
 * A message that can be sent over a transport.
 */
final class Message
{
    /**
     * @var string
     */
    private $channel;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $options;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $channel The name of the channel to broadcast the message to.
     * @param array $params The parameters that belong to the message.
     * @param array $options Options that can be passed along to the transport.
     */
    public function __construct(string $channel, array $params, array $options)
    {
        $this->channel = $channel;
        $this->params = $params;
        $this->options = $options;

        if (!array_key_exists('locale', $this->options)) {
            $this->options['locale'] = class_exists('Locale') ? \Locale::getDefault() : 'en-US';
        }
    }

    /**
     * Gets the value of field "channel".
     *
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Gets the value of field "params".
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Gets the parameter with the given name.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getParam(string $name, $default = null)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return $default;
    }

    /**
     * Gets the value of field "options".
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Gets the option with the given name.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $name, $default = null)
    {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }

        return $default;
    }
}
