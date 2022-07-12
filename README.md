# Composer package for generating URLs using Uploadcare for image transformations and processing.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/php-uploadcare-transformations.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/php-uploadcare-transformations)
[![Tests](https://github.com/vormkracht10/php-uploadcare-transformations/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/vormkracht10/php-uploadcare-transformations/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/php-uploadcare-transformations.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/php-uploadcare-transformations)

Generate Uploadcare image processing URLs to transform and process your images. No need to write or generate the URL yourself. Just pass the UUID of the file, optionally pass the custom CDN and chain the methods you want to apply and the package generates the URL for you.

- [Installation](#installation)
- [Usage](#usage)
- [Documentation](#documentation)
  * [Transformations](#transformations)
    + [Preview](#preview)
    + [Resize](#resize)
    + [Smart resize](#smart-resize)
    + [Crop](#crop)
    + [Crop by ratio](#crop-by-ratio)
    + [Crop by objects](#crop-by-objects)
    + [Scale crop](#scale-crop)
    + [Smart crop](#smart-crop)
    + [Set fill](#set-fill)
    + [Zoom objects](#zoom-objects)
    + [Format](#format)
    + [Quality](#quality)
  * [Using percentages or pixels as parameter](#using-percentages-or-pixels-as-parameter)
  * [List of possible transformations](#list-of-possible-transformations)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Credits](#credits)
- [License](#license)

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

### Transformations

#### Preview
Downscales an image proportionally to fit the given width and height in pixels.
```php
$url = $transformation->preview(100, 100)->getUrl();
// https://example.com/cdn/.../preview/100x100/
```

#### Resize
Resizes an image to one or two dimensions. When you set both width and height explicitly, it may result in a distorted image. If you specify either side, this operation will preserve the original aspect ratio and resize the image accordingly. Mode should be one of the following values: `on`, `off`, `fill`.

```php
// Using width, height, stretch and 'fill' mode. 
$url = $transformation->resize(100, null, true, 'fill')->getUrl();
// https://example.com/cdn/.../resize/100x/stretch/fill/

// Using only height, no stretch and no mode. 
$url = $transformations->resize(null, 250, false)->getUrl();
// https://example.com/cdn/.../resize/250x/
```

#### Smart resize
Content-aware resize helps retaining original proportions of faces and other visually sensible objects while resizing the rest of the image using intelligent algorithms.

```php
$url = $transformation->smartResize(500, 500)->getUrl();
// https://example.com/cdn/.../smart_resize/500x500/
```

#### Crop
Crops an image by using specified dimensions and alignment. 

Dimensions parameters can be in pixels or percentages. To see how pixels or percentages can be used, see the [Using percentages or pixels as parameter](#using-percentages-or-pixels-as-parameter) paragraph.

Alignment can also be in pixels and percentages but also a shortcut can be used.  The possible values are: `top`, `center`, `bottom`, `left`, `right`.

```php
// Using percentages and a shortcut.
$url = $transformation->crop(100, '50p', 'center')->getUrl();
// https://example.com/cdn/.../crop/100x50p/center/

// Using pixels only.
$url = $transformation->crop(100, 100, 50, 50)->getUrl();
// https://example.com/cdn/.../crop/100x100/50,50/

// Using both pixels and percentages.
$url = $transformation->crop(100, '50p', '25p', '25p')->getUrl();
// https://example.com/cdn/.../crop/100x50p/25p,25p/
```

#### Crop by ratio 
Crops the image to the specified aspect ratio, cutting off the rest of the image.

Ratio are two numbers greater than zero separated by :. Ratio is the quotient from the division of these numbers.

Alignment can be set in pixels and percentages but also a shortcut can be used. The possible values are: `top`, `center`, `bottom`, `left`, `right`. If alignment is not specified, `center` value is used.

```php
// Using percentages and a shortcut.
$url = $transformation->cropByRatio('4:3', 'bottom')->getUrl();
// https://example.com/cdn/.../crop/4:3/bottom/

// Using percentage in combination with pixels.
$url = $transformation->cropByRatio('4:3', '50p', 240)->getUrl();
// https://example.com/cdn/.../crop/4:3/50p,240/
```

#### Crop by objects 
Crops the image to the object specified by the tag parameter.

Tag can be one of `face` or `image`. 

Ratio are two numbers greater than zero separated by :. Ratio is the quotient from the division of these numbers.

Dimensions and alignment must be set in percentages. In case of the alignment you can also use the shortcut. The possible values are: `top`, `center`, `bottom`, `left`, `right`. If alignment is not specified, `center` value is used.

```php
// Using no ratio, percentages and pixels combined.
$url = $transformation->cropByObject('face', null, 200, '50p')->getUrl();
// "https://example.com/cdn/../crop/face/200x50p"

// Using ratio, percentages and a shortcut.
$url = $transformation->cropByObject('face', '4:3', '50p', '50p', 'bottom')->getUrl();
// "https://example.com/cdn/../crop/face/4:3/50px50p/bottom"
```

#### Scale crop
Scales an image until it fully covers the specified dimensions; the rest gets cropped. Mostly used to place images with various dimensions into placeholders (e.g., square shaped).

Dimensions must be set in pixels.

Alignment must be set in percentages or shortcut. The possible values are: `top`, `center`, `bottom`, `left`, `right`. If alignment is not specified, `0,0` value is used.

```php
// Using percentages.
$url = $transformation->scaleCrop(100, 100, '30p', '50p')->getUrl();
// https://example.com/cdn/.../scale_crop/100x100/30p,50p/

// Using shortcut.
$url = $transformation->scaleCrop(100, 100, 'bottom')->getUrl();
// "https://example.com/cdn/../scale_crop/100x100/bottom"
```

#### Smart crop
Switching the crop type to one of the smart modes enables the content-aware mechanics. Uploadcare applies AI-based algorithms to detect faces and other visually sensible objects to crop the background and not the main object.

Dimensions must be set in pixels.

Type must be one of the following values: `smart`, `smart_faces_objects`, `smart_faces`, `smart_objects`, `smart_faces_points`, `smart_points`, `smart_objects_faces_points`, `smart_objects_points` or `smart_objects_faces`.

Aligment must be set in percentages or shortcut. The possible values are: `top`, `center`, `bottom`, `left`, `right`. If alignment is not specified, `0,0` value is used.

```php
// Using percentages.
$url = $transformation->smartCrop(100, 100, 'smart_faces_objects', '30p', '50p')->getUrl();
// https://example.com/cdn/.../smart_crop/100x100/smart_faces_objects/30p,50p/

// Using shortcut.
$url = $transformation->smartCrop(100, 100, 'smart_faces_objects', 'right')->getUrl();
// https://example.com/cdn/.../smart_crop/100x100/smart_faces_objects/right/
```

#### Set fill 
Sets the fill color used with crop, stretch or when converting an alpha channel enabled image to JPEG.

Color must be a hex color code.

```php
$url = $transformation->setFill('#ff0000')->getUrl();
// https://example.com/cdn/.../set_fill/ff0000/
```

#### Zoom objects
Zoom objects operation is best suited for images with solid or uniform backgrounds.

Zoom must be a number between 1 and 100.

```php 
$url = $transformation->zoomObjects(50)->getUrl();
// https://example.com/cdn/.../zoom_objects/50/
```

#### Format
Converts an image to one of the following formats: `jpg`, `png`, `webp`, `auto`.

```php
$url = $transformation->format('jpg')->getUrl();
// https://example.com/cdn/.../format/jpg/
```

#### Quality
Sets output JPEG and WebP quality. Since actual settings vary from codec to codec, and more importantly, from format to format, we provide five simple tiers and two automatic values which suits most cases of image distribution and are consistent.

Quality must be one of the following values: `smart`, `smart_retina`, `normal`, `better`, `best`, `lighter`, `lightest`.

```php
$url = $transformation->quality('smart')->getUrl();
// https://example.com/cdn/.../quality/smart/
```




### Using percentages or pixels as parameter
In some of the methods you can pass parameters in various ways. For example in the [scaleCrop()](/src/Transformations/ScaleCrop.php) method you can pass the offset in the form of a percentage or pixels. To make it easier to recognize when a pixel or percentage is used you can pass the parameters as following.

```php
// Using percentages
$url = $transformation->scaleCrop(320, 320, '50p', '60p')->getUrl();
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/scale_crop/320x320/50px60p/


// Using pixels
$url = $transformation->scaleCrop(320, 320, 50, 60)->getUrl();
// https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/scale_crop/320x320/50x60/
```

>As stated in the Uploadcare Documentation, in URLs, % is an escape character and should be encoded with %25 escape sequence, e.g. /scale_crop/440x440/80%25,80%25/. For convenience, we can use the p shortcut for percent which doesn't require encoding.

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
