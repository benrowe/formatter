# Formatter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://travis-ci.org/benrowe/formatter.svg?branch=master)](https://travis-ci.org/benrowe/formatter)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

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

- [Ben Rowe][http://benrowe.info/formatter]
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
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
