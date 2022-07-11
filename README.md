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

### Various ways of passing certain parameters
In some of the methods you can pass parameters in various ways. For example in the [scaleCrop()](/src/Transformations/ScaleCrop.php) method you can pass the offset in the form of a percentage or pixels. To make it easer to recognize when a pixel or percentage is passed you can pass the parameters as following.

```php
// Using percentages
$url = $transformation->scaleCrop(320, 320, '50p', '60p')->getUrl();
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/scale_crop/320x320/50px60p/


// Using pixels
$url = $transformation->scaleCrop(320, 320, 50, 60)->getUrl();
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/scale_crop/320x320/50x60/
```

>In URLs, % is an escape character and should be encoded with %25 escape sequence, e.g. /scale_crop/440x440/80%25,80%25/. For convenience, we use the p shortcut for percent which doesn't require encoding.

### Pre-defined parameters
In some methods you can pass parameters that are "pre-defined". For example in the [filter()](/src/Transformations/Filter.php) method you can pass the [`name`](/src/Transformations/Enums/Filter.php) parameter. As found in the documentation of the [photo filter](https://uploadcare.com/docs/transformations/image/photo-filters/#image-photo-filters) the name parameter should be one of the 40 filters. To be sure that the name is correct we made a special Enum class for each pre-defined parameter. These can be found inside the [Enums](/src/Transformations/Enums/) folder.


### List of possible transformations
Each transformation follows the documentation on Uploadcare which you may find <a href="https://uploadcare.com/docs/">here</a>. 
The current list of possible transformations and where to find the documentation:

| Transformation        | Documentation link           |
| ------------- |:-------------:|
| Auto rotate      | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/rotate-flip/#operation-autorotate">Link</a> |
| Basic color adjustments      | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#image-colors-operations">Link</a>      |
| Blur | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur">Link</a>      |
| Blur faces | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur-region-faces">Link</a>      |
| Blur region | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/blur-sharpen/#operation-blur-region">Link</a>      |
| Convert to sRGB | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-srgb">Link</a>      |
| Crop | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop">Link</a>      |
| Crop by objects | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop-tags">Link</a>      |
| Crop by ratio | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-crop-aspect-ratio">Link</a>      |
| Enhance | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-enhance">Link</a>      |
| Filter | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-filter">Link</a>      |
| Flip | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-flip">Link</a>      |
| Format | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/compression/#operation-format">Link</a>      |
| Grayscale | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-grayscale">Link</a>      |
| ICC profile size threshold | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-max-icc-size">Link</a>      |
| Inverting | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-inverting">Link</a>      |
| Mirror | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-mirror">Link</a>      |
| Overlay | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-overlay">Link</a>      |
| Preview | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-preview">Link</a>      |
| Progressive | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/compression/#operation-progressive">Link</a>      |
| Quality | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/compression/#operation-quality">Link</a>      |
| Resize | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-resize">Link</a>      |
| Rotate | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-rotate">Link</a>      |
| Scale crop | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-scale-crop">Link</a>      |
| Set fill | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-setfill">Link</a>      |
| Sharpen | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/colors/#operation-sharpen">Link</a>      |
| Smart crop | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-smart-crop">Link</a>      |
| Smart resize | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-smart-resize">Link</a>      |
| Zoom objects | <a target="_blank" href="https://uploadcare.com/docs/transformations/image/resize-crop/#operation-zoom-objects">Link</a>      |

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
