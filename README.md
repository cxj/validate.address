# Validate Address

The United States Postal Service (USPS) [Address Standardization Web Tool]
corrects errors in street addresses, including abbreviations and missing
information, and supplies ZIP Codes and ZIP Codes + 4.

This library provides a simple interface to using the above USPS API.

## Installation and Autoloading

This package is installable and PSR-4 autoloadable via Composer as
[cxj/validate.address][].

Alternatively, [download a release][], or clone this repository, then map the
`Cxj\` namespace to the package `src/` directory.

## Dependencies

This package requires PHP 7.4 or later. We recommend using the latest
available version of PHP as a matter of principle.

## Quality

To run the unit tests at the command line, issue `composer install` and then
`./vendor/bin/phpunit` at the package root. This requires [Composer][] to be
available as `composer`, and [PHPUnit][] to be available as `phpunit`.

This package attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][].  If
you notice compliance oversights, please send a patch via pull request.

[Address Standardization Web Tool]: https://www.usps.com/business/web-tools-apis/address-information-api.htm#_Toc34052588
[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[PSR-11]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md
[Composer]: http://getcomposer.org/
[PHPUnit]: http://phpunit.de/
[download a release]: https://github.com/cxj/validate.address/releases
[cxj/validate.address]: https://packagist.org/packages/cxj/validate.address
[composer.json]: ./composer.json
