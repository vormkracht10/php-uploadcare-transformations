# Composer package for generating URLs using Uploadcare for image transformations and processing.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/php-uploadcare-transformations.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/php-uploadcare-transformations)
[![Tests](https://github.com/vormkracht10/php-uploadcare-transformations/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/vormkracht10/php-uploadcare-transformations/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/php-uploadcare-transformations.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/php-uploadcare-transformations)

Generate Uploadcare image processing URLs to transform and process your images. No need to write or generate the URL yourself. Just pass the UUID of the file, optionally pass the custom CDN and chain the methods you want to apply and the package generates the URL for you.

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/php-uploadcare-transformations
```

## Usage

<ol>
    <li>
        Include UploadcareTransformation.
    </li>
     <li>
        Get the UUID of the file you want to show.
    </li>
     <li>
        Set your CDN url (optional).
    </li>
     <li>
        Create the transformation URL by chaining one or multiple methods to the UploadcareTransformation class. You can chain as much methods as you want. 
    </li>
    <li>Use the output of the transformation as image source.</li>
</ol>

```php
use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

$uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
$cdnUrl = 'https://example.com/cdn/';

$transformation = (new UploadcareTransformation($uuid, $cdn));

$url = $transformation->crop(320, '50p', 'center')->setFill('#ffffff')->getUrl();

echo $transformation;
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/crop/320x50p/center/set_fill/#ffffff
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Bas van Dinther](https://github.com/baspa)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
