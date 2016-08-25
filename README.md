# Formatter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


Formatter is a real time value decorator system. It's designed to provide a
consistent interface for formatting values, regardless of the method designed.

This allows for runtime formatting to be controlled via data rather than via
code.

The formatter allows you to register & override formatter providers, giving you
full control over the final output.

## Install

Via Composer

``` bash
$ composer require benrowe/formatter
```

## Usage

``` php
$formatter = new Benrowe\Formatter\Formatter;
$formatter->addFormatter('return', function($value) {
    return $value;
});
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email ben.rowe.83@gmail.com instead of using the issue tracker.

## Credits

- [Ben Rowe](http://benrowe.info/p/
    formatter)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/benrowe/formatter.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/benrowe/formatter/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/benrowe/formatter.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/benrowe/formatter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/benrowe/formatter.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/benrowe/formatter
[link-travis]: https://travis-ci.org/benrowe/formatter
[link-scrutinizer]: https://scrutinizer-ci.com/g/benrowe/formatter/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/benrowe/formatter
[link-downloads]: https://packagist.org/packages/benrowe/formatter
[link-author]: https://github.com/benrowe
[link-contributors]: ../../contributors
