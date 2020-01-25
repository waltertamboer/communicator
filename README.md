# Communicator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Communicator is a PHP library that helps you broadcast messages over multiple 
channels. This can be useful when you want to send notifcations to users via 
multiple transports such as e-mail, SMS or IRC.

## Install

Via Composer

``` bash
$ composer require waltertamboer/communicator
```

## Usage

Since communicator doesn't know where to send messages to, you need to implement
the `Communicator\Recipient\RecipientInterface` interface. Communicator will use
it to determine the target addresses.

``` php
$recipient = new ... // An implementation of Communicator\Recipient\RecipientInterface

$communicator = new Communicator\Communicator();

// Bind a transport. Of course this can be any transport you require.
// It's also possible to bind multiple transports to the same channel.
$communicator->bindTransport('my-channel', new Communicator\Transport\Noop\Transport());

// Now broadcast a message to all transports.
$communicator->broadcast(
    [
        $recipient,
    ],
    'my-channel', 
    [
        'my-param' => 'some param',
    ]
);

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Install the dependencies via Docker:

```bash
docker run --rm --interactive --tty \
    --volume $PWD:/app \
    --volume $SSH_AUTH_SOCK:/ssh-auth.sock \
    --volume /etc/passwd:/etc/passwd:ro \
    --volume /etc/group:/etc/group:ro \
    --user $(id -u):$(id -g) \
    --env SSH_AUTH_SOCK=/ssh-auth.sock \
    composer install
```

Run the unit tests:

Just make sure the unit tests are present :-)

## Credits

- [Walter Tamboer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/waltertamboer/communicator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/waltertamboer/communicator/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/waltertamboer/communicator.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/waltertamboer/communicator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/waltertamboer/communicator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/waltertamboer/communicator
[link-travis]: https://travis-ci.org/waltertamboer/communicator
[link-scrutinizer]: https://scrutinizer-ci.com/g/waltertamboer/communicator/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/waltertamboer/communicator
[link-downloads]: https://packagist.org/packages/waltertamboer/communicator
[link-author]: https://github.com/waltertamboer
[link-contributors]: ../../contributors
