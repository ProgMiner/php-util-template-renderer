# util-template-renderer

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Coverage][ico-coverage]][link-coverage]
[![Scrutinizer Code Quality][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require progminer/util-template-renderer
```

## Usage

The library has some classes and one interface for abstracting from different template engines.

[`ProgMinerUtils\TemplateRenderer\ITemplateRenderer`](lib/ITemplateRenderer.php) is interface for template engines abstractions. You can use it for use abstractions in your code.

Library has some included abstractions: for callable templates, for PHP templates and for [Twig](http://twig.sensiolabs.org/) templates. Also, library has [`ProgMinerUtils\TemplateRenderer\DelegatingTemplateRenderer`](lib/DelegatingTemplateRenderer.php) for use several abstractions at one time.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email eridan200@mail.ru instead of using the issue tracker.

## Credits

- [Eridan Domoratskiy][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/progminer/util-template-renderer.svg?style=flat
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat
[ico-travis]: https://travis-ci.org/ProgMiner/php-util-template-renderer.svg
[ico-coverage]: https://scrutinizer-ci.com/g/ProgMiner/php-util-template-renderer/badges/coverage.png
[ico-scrutinizer]: https://scrutinizer-ci.com/g/ProgMiner/php-util-template-renderer/badges/quality-score.png
[ico-downloads]: https://img.shields.io/packagist/dt/progminer/util-template-renderer.svg?style=flat

[link-packagist]: https://packagist.org/packages/progminer/util-template-renderer
[link-travis]: https://travis-ci.org/ProgMiner/php-util-template-renderer
[link-coverage]: https://scrutinizer-ci.com/g/ProgMiner/php-util-template-renderer/
[link-scrutinizer]: https://scrutinizer-ci.com/g/ProgMiner/php-util-template-renderer/
[link-downloads]: https://packagist.org/packages/progminer/util-template-renderer
[link-author]: https://github.com/ProgMiner
[link-contributors]: ../../contributors
