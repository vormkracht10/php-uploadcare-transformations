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

echo $url;
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/crop/320x50p/center/set_fill/#ffffff
```

## Documentation

### List of possible transformations
Each transformation follows the documentation on Uploadcare which you may find <a href="https://uploadcare.com/docs/">here</a>. 
The current list of possible transformations and where to find the documentation:

| Transformation        | Documentation link           |
| ------------- |:-------------:|
| Auto rotate      | <a href="https://uploadcare.com/docs/transformations/image/rotate-flip/#operation-autorotate">Link</a> |
| Basic color adjustments      | <a href="https://uploadcare.com/docs/transformations/image/colors/#image-colors-operations">Link</a>      |
| Blur | <a href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur">Link</a>      |
| Blur faces | <a href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur-region-faces">Link</a>      |
| Blur region | <a href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur-region">Link</a>      |
| Convert to sRGB | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-srgb">Link</a>      |
| Crop | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop">Link</a>      |
| Crop by objects | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop-tags">Link</a>      |
| Crop by ratio | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop-aspect-ratio">Link</a>      |
| Enhance | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-enhance">Link</a>      |
| Filter | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-filter">Link</a>      |
| Flip | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-flip">Link</a>      |
| Format | <a href="https://uploadcare.com/docs/transformations/image/compression/#operation-format">Link</a>      |
| Grayscale | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-grayscale">Link</a>      |
| ICC profile size threshold | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-max-icc-size">Link</a>      |
| Inverting | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-inverting">Link</a>      |
| Mirror | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-mirror">Link</a>      |
| Overlay | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-overlay">Link</a>      |
| Preview | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-preview">Link</a>      |
| Progressive | <a href="https://uploadcare.com/docs/transformations/image/compression/#operation-progressive">Link</a>      |
| Quality | <a href="https://uploadcare.com/docs/transformations/image/compression/#operation-quality">Link</a>      |
| Resize | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-resize">Link</a>      |
| Rotate | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-rotate">Link</a>      |
| Scale crop | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-scale-crop">Link</a>      |
| Set fill | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-setfill">Link</a>      |
| Sharpen | <a href="https://uploadcare.com/docs/transformations/image/colors/#operation-sharpen">Link</a>      |
| Smart crop | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-smart-crop">Link</a>      |
| Smart resize | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-smart-resize">Link</a>      |
| Zoom objects | <a href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-zoom-objects">Link</a>      |

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
