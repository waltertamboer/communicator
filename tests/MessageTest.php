<?php
/**
 * Communicator (https://github.com/waltertamboer/communicator)
 *
 * @link https://github.com/waltertamboer/communicator for the canonical source repository
 * @copyright Copyright (c) 2017 Communicator (https://github.com/waltertamboer/communicator)
 * @license https://github.com/waltertamboer/communicator/blob/master/LICENSE.md MIT
 */

namespace Communicator;

use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    /**
     * Test that the channel is initialized and can be retrieved.
     *
     * @cover Message::__construct
     * @cover Message::getChannel
     */
    public function testChannelCanBeRetrieved()
    {
        // Arrange
        $message = new Message('channel', [], []);

        // Act
        $result = $message->getChannel();

        // Assert
        static::assertEquals('channel', $result);
    }

    /**
     * Test that the params are initialized and can be retrieved.
     *
     * @cover Message::__construct
     * @cover Message::getParams
     */
    public function testParamsCanBeRetrieved()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
        ], []);

        // Act
        $result = $message->getParams();

        // Assert
        static::assertEquals([
            'param1' => 'value1',
        ], $result);
    }

    /**
     * Test that a parameter can be retrieved via getParam.
     *
     * @cover Message::__construct
     * @cover Message::getParam
     */
    public function testIndividualParamCanBeRetrieved()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
            'param2' => 'value2',
        ], []);

        // Act
        $result = $message->getParam('param1');

        // Assert
        static::assertEquals('value1', $result);
    }

    /**
     * Test that getParam returns a default value for a non-existing parameter.
     *
     * @cover Message::__construct
     * @cover Message::getParam
     */
    public function testGetParamReturnsDefaultValue()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
            'param2' => 'value2',
        ], []);

        // Act
        $result = $message->getParam('param3', 'value3');

        // Assert
        static::assertEquals('value3', $result);
    }

    /**
     * Test that the options are initialized and can be retrieved.
     *
     * @cover Message::__construct
     * @cover Message::getOptions
     */
    public function testOptionsCanBeRetrieved()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
        ], [
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        ]);

        // Act
        $result = $message->getOptions();

        // Assert
        static::assertArrayHasKey('option1', $result);
    }

    /**
     * Test that the locale is always set as an option.
     */
    public function testLocaleIsSet()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
        ], [
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        ]);

        // Act
        $result = $message->getOptions();

        // Assert
        static::assertArrayHasKey('locale', $result);
    }

    /**
     * Test that an option can be retrieved via getOption.
     *
     * @cover Message::__construct
     * @cover Message::getOption
     */
    public function testIndividualOptionCanBeRetrieved()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
            'param2' => 'value2',
        ], [
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        ]);

        // Act
        $result = $message->getOption('option1');

        // Assert
        static::assertEquals('value1', $result);
    }

    /**
     * Test that getOption returns a default value for a non-existing parameter.
     *
     * @cover Message::__construct
     * @cover Message::getOption
     */
    public function testGetOptionReturnsDefaultValue()
    {
        // Arrange
        $message = new Message('channel', [
            'param1' => 'value1',
            'param2' => 'value2',
        ], [
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        ]);

        // Act
        $result = $message->getOption('option4', 'value4');

        // Assert
        static::assertEquals('value4', $result);
    }
}
