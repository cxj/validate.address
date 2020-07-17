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

## Example Usage

```php
<?php
$address = new Address(
    "8039 Beach Blvd",
    "",
    "Buena Park",
    "CA",
    "90620"
);

$user = YOUR_USER_NAME; // Obtained from the USPS website:
// https://www.usps.com/business/web-tools-apis/#developers

$validate = new ValidateAddress(new CurlPost($user), new DomParser());
$response = $validate->validate($address);

echo sprintf("Corrected ZIP+4 Code: %s-%s\n",
    $response->getAddress()->getZip5(),
    $response->getAddress()->getZip4()
);
```

The main API class for usage is `ValidateAddress`, the address to be validated
or normalized is passed as a Parameter Object or Value Object to the validation
method itself.  The constructor requires has two other dependencies, defined
by the `CommunicationInteface` (which handles the connection and exchange
with the USPS server), and the `ResponseParserInterface` (which handles
decoding the XML response from the server).

Three implementations of the `CommunicationInterface` are provided, using
the PHP Curl extension to send the address request via either HTTP POST or GET,
and a stream socket.

Two implementations of the `ResponseParserInterface` are provided.  One
requires the PHP DOM extension, and the other requires the PHP XML extension.

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
