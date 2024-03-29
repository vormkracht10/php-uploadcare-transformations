<?php

namespace Vormkracht10\UploadcareTransformations;

use Vormkracht10\UploadcareTransformations\Transformations\AutoRotate;
use Vormkracht10\UploadcareTransformations\Transformations\BasicColorAdjustments;
use Vormkracht10\UploadcareTransformations\Transformations\Blur;
use Vormkracht10\UploadcareTransformations\Transformations\BlurFaces;
use Vormkracht10\UploadcareTransformations\Transformations\BlurRegion;
use Vormkracht10\UploadcareTransformations\Transformations\ConvertToSRGB;
use Vormkracht10\UploadcareTransformations\Transformations\Crop;
use Vormkracht10\UploadcareTransformations\Transformations\CropByObjects;
use Vormkracht10\UploadcareTransformations\Transformations\CropByRatio;
use Vormkracht10\UploadcareTransformations\Transformations\Enhance;
use Vormkracht10\UploadcareTransformations\Transformations\Filter;
use Vormkracht10\UploadcareTransformations\Transformations\Flip;
use Vormkracht10\UploadcareTransformations\Transformations\Format;
use Vormkracht10\UploadcareTransformations\Transformations\Grayscale;
use Vormkracht10\UploadcareTransformations\Transformations\ICCProfileSizeThreshold;
use Vormkracht10\UploadcareTransformations\Transformations\Invert;
use Vormkracht10\UploadcareTransformations\Transformations\Mirror;
use Vormkracht10\UploadcareTransformations\Transformations\Overlay;
use Vormkracht10\UploadcareTransformations\Transformations\Progressive;
use Vormkracht10\UploadcareTransformations\Transformations\Quality;
use Vormkracht10\UploadcareTransformations\Transformations\Rasterize;
use Vormkracht10\UploadcareTransformations\Transformations\Resize;
use Vormkracht10\UploadcareTransformations\Transformations\Rotate;
use Vormkracht10\UploadcareTransformations\Transformations\ScaleCrop;
use Vormkracht10\UploadcareTransformations\Transformations\SetFill;
use Vormkracht10\UploadcareTransformations\Transformations\Sharpen;
use Vormkracht10\UploadcareTransformations\Transformations\SmartCrop;
use Vormkracht10\UploadcareTransformations\Transformations\SmartResize;
use Vormkracht10\UploadcareTransformations\Transformations\ZoomObjects;

class Transformations
{
    /** @var array<mixed> */
    protected array $transformations = [];

    /**
     * Downscales an image proportionally to fit the given width and height in pixels.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
     */
    public function preview(int $width, int $height): self
    {
        $this->transformations['preview'] = ['width' => $width, 'height' => $height];

        return $this;
    }

    /**
     * Resizes an image to one or two dimensions.
     *
     * @param int|null $width in pixels.
     * @param int|null $height in pixels.
     * @param string|null $mode one of the resize modes.
     */
    public function resize(int $width = null, int $height = null, bool $stretch = false, string $mode = null): self
    {
        $this->transformations['resize'] = Resize::transform($width, $height, $stretch, $mode);

        return $this;
    }

    /**
     * Content-aware resize helps retaining original proportions of faces and other visually
     * sensible objects while resizing the rest of the image using intelligent algorithms.
     *
     * @param int $width in pixels
     * @param int $height in pixels
     */
    public function smartResize(int $width, int $height): self
    {
        $this->transformations['smart_resize'] = SmartResize::transform($width, $height);

        return $this;
    }

    /**
     * Crops an image by using specified dimensions and alignment.
     *
     * @param int $width in pixels or percents.
     * @param int $height in pixels or percents.
     * @param int|string $offsetX horizontal and vertical offsets in pixels or percents (e.g. 50p) or shortcuts.
     */
    public function crop(int|string $width, int|string $height, int|string $offsetX = null, int|string $offsetY = null): self
    {
        $this->transformations['crop'] = Crop::transform($width, $height, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Crops the image to the specified aspect ratio, cutting off the rest of the image.
     *
     * @param string $ratio two numbers greater than zero separated by :
     * @param int|string $offsetX horizontal and vertical offsets in pixels or percents or shortcuts.
     * @param string|null $offsetY horizontal and vertical offsets in percents.
     */
    public function cropByRatio(string $ratio, int|string $offsetX = null, string|null $offsetY = null): self
    {
        $this->transformations['crop_by_ratio'] = CropByRatio::transform($ratio, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Crops the image to the object specified by the :tag parameter.
     *
     * @param string $tag one of the tags.
     * @param string $ratio two numbers greater than zero separated by :
     * @param string $width in percentages e.g. 50p.
     * @param string $height in percentages e.g. 50p.
     * @param int|string $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param string|null $offsetY horizontal and vertical offsets in percents.
     */
    public function cropByObjects(string $tag, string $ratio = null, string $width = null, string $height = null, int|string $offsetX = null, string|null $offsetY = null): self
    {
        $this->transformations['crop_by_objects'] = CropByObjects::transform($tag, $ratio, $width, $height, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Scales an image until it fully covers the specified dimensions; the rest gets cropped.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
     * @param string $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param string|null $offsetY horizontal and vertical offsets in percents.
     */
    public function scaleCrop(int $width, int $height, string $offsetX = null, string|null $offsetY = null): self
    {
        $this->transformations['scale_crop'] = ScaleCrop::transform($width, $height, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Switching the crop type to one of the smart modes enables the content-aware mechanics.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
     * @param string $type one of the types.
     * @param string $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param string|null $offsetY horizontal and vertical offsets in percents.
     */
    public function smartCrop(int $width, int $height, string $type, string $offsetX = null, string|null $offsetY = null): self
    {
        $this->transformations['smart_crop'] = SmartCrop::transform($width, $height, $type, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Sets the fill color used with crop, stretch or when converting an alpha channel enabled image to JPEG.
     *
     * @param string $color in hexadecimal notation with optional transparency.
     */
    public function setFill(string $color): self
    {
        $this->transformations['set_fill'] = SetFill::transform($color);

        return $this;
    }

    /**
     * Sets the object's size in the image from 1 to 100.
     *
     * @param int $zoom integer between 1 and 100.
     */
    public function zoomObjects(int $zoom): self
    {
        $this->transformations['zoom_objects'] = ZoomObjects::transform($zoom);

        return $this;
    }

    /**
     * Converts an image to a different format.
     *
     * @param string $format one of the formats.
     */
    public function format(string $format): self
    {
        $this->transformations['format'] = Format::transform($format);

        return $this;
    }

    /**
     * Sets output JPEG and WebP quality.
     */
    public function quality(string $quality): self
    {
        $this->transformations['quality'] = Quality::transform($quality);

        return $this;
    }

    /**
     * Returns a progressive image.
     */
    public function progressive(bool $progressive): self
    {
        $this->transformations['progressive'] = Progressive::transform($progressive);

        return $this;
    }

    /**
     * Adjust color properties of an image.
     */
    public function basicColorAdjustments(string $color, int $value): self
    {
        $this->transformations['basic_color_adjustments'] = BasicColorAdjustments::transform($color, $value);

        return $this;
    }

    /**
     * Auto-enhances an image by performing the following operations: auto levels, auto contrast, and saturation sharpening.
     */
    public function enhance(int $strength = 50): self
    {
        $this->transformations['enhance'] = Enhance::transform($strength);

        return $this;
    }

    /**
     * Desaturates images. The operation has no additional parameters and simply produces a grayscale image output when applied.
     */
    public function grayscale(): self
    {
        $this->transformations['grayscale'] = Grayscale::transform();

        return $this;
    }

    /**
     * Inverts images rendering a 'negative' of the input.
     */
    public function invert(): self
    {
        $this->transformations['invert'] = Invert::transform();

        return $this;
    }

    /**
     * Set how Uploadcare behaves depending on different color profiles of uploaded images.
     * See their documentation to learn more about the possible outcomes.
     * https://uploadcare.com/docs/transformations/image/colors/#image-color-profile-management
     */
    public function convertToSRGB(string $profile): self
    {
        $this->transformations['convert_to_srgb'] = ConvertToSRGB::transform($profile);

        return $this;
    }

    /**
     * Define which RGB color profile sizes will be considered “small” and “large” when using srgb in fast or icc modes.
     *
     * @param int $number which stands for the ICC profile size in kilobytes.
     */
    public function iccProfileSizeThreshold(int $number = 10): self
    {
        $this->transformations['icc_profile_size_threshold'] = ICCProfileSizeThreshold::transform($number);

        return $this;
    }

    /**
     * Applies one of predefined photo filters by its :name
     *
     * @param string $name one of the filters.
     * @param int $value optional value for the filter.
     */
    public function filter(string $name, int $value = null): self
    {
        $this->transformations['filter'] = Filter::transform($name, $value);

        return $this;
    }

    /**
     * Blurs images by the :strength factor.
     */
    public function blur(int $strength = null, int $amount = null): self
    {
        $this->transformations['blur'] = Blur::transform($strength, $amount);

        return $this;
    }

    /**
     * Blurs the specified region of the image by the :strength factor.
     *
     * @param int $dimensionX horizontal offset in pixels or percentages.
     * @param int $dimensionY vertical offset in pixels or percentages.
     * @param int $coordinateX in pixels or percentages.
     * @param int $coordinateY in pixels or percentages.
     */
    public function blurRegion(int $dimensionX, int|string $dimensionY, int|string $coordinateX, int|string $coordinateY, int $strength = null): self
    {
        $this->transformations['blur_region'] = BlurRegion::transform($dimensionX, $dimensionY, $coordinateX, $coordinateY, $strength);

        return $this;
    }

    /**
     * When faces is specified the regions are selected automatically by utilizing face detection.
     */
    public function blurFaces(int $strength = null): self
    {
        $this->transformations['blur_faces'] = BlurFaces::transform($strength);

        return $this;
    }

    /**
     * Sharpens an image, might be especially useful with images that were subjected to downscaling.
     */
    public function sharpen(int $strength = null): self
    {
        $this->transformations['sharpen'] = Sharpen::transform($strength);

        return $this;
    }

    /**
     * The default behavior goes with parsing EXIF tags of original images and rotating them according to the “Orientation” tag.
     */
    public function autoRotate(bool $rotate): self
    {
        $this->transformations['auto_rotate'] = AutoRotate::transform();

        return $this;
    }

    /**
     * Rasterize SVG images.
     */
    public function rasterize(): self
    {
        $this->transformations['rasterize'] = Rasterize::transform();

        return $this;
    }

    /**
     * Right-angle image rotation, counterclockwise.
     *
     * @param int $angle must be a multiple of 90.
     */
    public function rotate(int $angle): self
    {
        $this->transformations['rotate'] = Rotate::transform($angle);

        return $this;
    }

    /**
     * Flips images.
     */
    public function flip(): self
    {
        $this->transformations['flip'] = Flip::transform();

        return $this;
    }

    /**
     * Mirror images.
     */
    public function mirror(): self
    {
        $this->transformations['mirror'] = Mirror::transform();

        return $this;
    }

    /**
     * Adds an image overlay to the original image.
     *
     * @param int|string|null $width,
     * @param int|string|null $height,
     * @param int|string|null $coordinateX,
     * @param int|string|null $coordinateY,
     *
     */
    public function overlay(
        string $uuid,
        int|string|null $width = null,
        int|string|null $height = null,
        int|string|null $coordinateX = null,
        int|string|null $coordinateY = null,
        string|null $opacity = null
    ): self {
        $this->transformations['overlay'] = Overlay::transform($uuid, $width, $height, $coordinateX, $coordinateY, $opacity);

        return $this;
    }
}
