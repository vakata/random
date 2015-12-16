# random

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-cc]][link-cc]
[![Tests Coverage][ico-cc-coverage]][link-cc]

A random int / string / byte generator for PHP.

## Install

Via Composer

``` bash
$ composer require vakata/random
```

## Usage

``` php
// random 16 char alphanum string
\vakata\random\Generator::string(16);
// random 10 char hex string
\vakata\random\Generator::string(10, 'abcdef01234567890');
// random int between 0 and PHP_INT_MAX (inclusive)
\vakata\random\Generator::number();
// random int between 3 and 12 (inclusive)
\vakata\random\Generator::number(3, 12);
// 16 bytes
\vakata\random\Generator::bytes(16);
```

Read more in the [API docs](docs/README.md)

## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email github@vakata.com instead of using the issue tracker.

## Credits

- [vakata][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 

[ico-version]: https://img.shields.io/packagist/v/vakata/random.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/vakata/random/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/vakata/random.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/vakata/random.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vakata/random.svg?style=flat-square
[ico-cc]: https://img.shields.io/codeclimate/github/vakata/random.svg?style=flat-square
[ico-cc-coverage]: https://img.shields.io/codeclimate/coverage/github/vakata/random.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/vakata/random
[link-travis]: https://travis-ci.org/vakata/random
[link-scrutinizer]: https://scrutinizer-ci.com/g/vakata/random/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/vakata/random
[link-downloads]: https://packagist.org/packages/vakata/random
[link-author]: https://github.com/vakata
[link-contributors]: ../../contributors
[link-cc]: https://codeclimate.com/github/vakata/random

