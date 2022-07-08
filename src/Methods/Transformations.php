<?php

namespace Vormkracht10\UploadcareTransformations\Methods;

use Vormkracht10\UploadcareTransformations\Transformations\Crop;
use Vormkracht10\UploadcareTransformations\Transformations\Format;
use Vormkracht10\UploadcareTransformations\Transformations\Resize;
use Vormkracht10\UploadcareTransformations\Transformations\Enhance;
use Vormkracht10\UploadcareTransformations\Transformations\Quality;
use Vormkracht10\UploadcareTransformations\Transformations\SetFill;
use Vormkracht10\UploadcareTransformations\Transformations\Grayscale;
use Vormkracht10\UploadcareTransformations\Transformations\Inverting;
use Vormkracht10\UploadcareTransformations\Transformations\ScaleCrop;
use Vormkracht10\UploadcareTransformations\Transformations\SmartCrop;
use Vormkracht10\UploadcareTransformations\Transformations\CropByRatio;
use Vormkracht10\UploadcareTransformations\Transformations\Progressive;
use Vormkracht10\UploadcareTransformations\Transformations\SmartResize;
use Vormkracht10\UploadcareTransformations\Transformations\ZoomObjects;
use Vormkracht10\UploadcareTransformations\Transformations\ConvertToSRGB;
use Vormkracht10\UploadcareTransformations\Transformations\CropByObjects;
use Vormkracht10\UploadcareTransformations\Transformations\BasicColorAdjustments;
use Vormkracht10\UploadcareTransformations\Transformations\ICCProfileSizeThreshold;

class Transformations
{
    /**
     * Downscales an image proportionally to fit the given width and height in pixels.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
     * @return self
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
     * @param bool $stretch
     * @param string|null $mode one of the resize modes.
     * @return self
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
     * @return self
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
     * @param int|string $offsetY
     * @return self
     */
    public function crop(int|string $width, int|string $height, int|string $offsetX, int|string $offsetY = null): self
    {
        $this->transformations['crop'] = Crop::transform($width, $height, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Crops the image to the specified aspect ratio, cutting off the rest of the image.
     *
     * @param string $ratio two numbers greater than zero separated by :
     * @param int|string $offsetX horizontal and vertical offsets in pixels or percents or shortcuts.
     * @param int $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function cropByRatio(string $ratio, int|string $offsetX, int|string $offsetY = null): self
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
     * @param string $heigt in percentages e.g. 50p.
     * @param string $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param string $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function cropByObjects(string $tag, string $ratio = null, string $width = null, string $heigt = null, int|string $offsetX = null, int $offsetY = null): self
    {
        $this->transformations['crop_by_objects'] = CropByObjects::transform($tag, $ratio, $width, $heigt, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Scales an image until it fully covers the specified dimensions; the rest gets cropped.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
     * @param int $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param int|null $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function scaleCrop(int $width, int $height, string $offsetX = null, $offsetY = null): self
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
     * @param int $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param int|null $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function smartCrop(int $width, int $height, string $type, string $offsetX = null, string $offsetY = null): self
    {
        $this->transformations['smart_crop'] = SmartCrop::transform($width, $height, $type, $offsetX, $offsetY);

        return $this;
    }

    /**
     * Sets the fill color used with crop, stretch or when converting an alpha channel enabled image to JPEG.
     *
     * @param string $color in hexadecimal notation with optional transparency.
     * @return self
     */
    public function setFill(string $color): self
    {
        $this->transformations['set_fill'] = SetFill::transform($color);

        return $this;
    }

    /**
     * Sets the object's size in the image from 1 to 100.
     *
     * @param string integer between 1 and 100.
     * @return self
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
     * @return self
     */
    public function format(string $format): self
    {
        $this->transformations['format'] = Format::transform($format);

        return $this;
    }

    /**
     * Sets output JPEG and WebP quality.
     *
     * @param string $quality
     * @return self
     */
    public function quality(string $quality): self
    {
        $this->transformations['quality'] = Quality::transform($quality);

        return $this;
    }

    /**
     * Returns a progressive image.
     *
     * @param bool $progressive
     * @return self
     */
    public function progressive(bool $progressive): self
    {
        $this->transformations['progressive'] = Progressive::transform($progressive);

        return $this;
    }

    /**
     * Adjust color properties of an image.
     *
     * @param string $color
     * @param int $value
     * @return self
     */
    public function basicColorAdjustments(string $color, int $value): self
    {
        $this->transformations['basic_color_adjustments'] = BasicColorAdjustments::transform($color, $value);

        return $this;
    }

    /**
     * Auto-enhances an image by performing the following operations: auto levels, auto contrast, and saturation sharpening.
     *
     * @param int $strength
     * @return self
     */
    public function enhance(int $strength = 50): self
    {
        $this->transformations['enhance'] = Enhance::transform($strength);

        return $this;
    }

    /**
     * Desaturates images. The operation has no additional parameters and simply produces a grayscale image output when applied.
     *
     * @return self
     */
    public function grayscale(): self
    {
        $this->transformations['grayscale'] = Grayscale::transform();

        return $this;
    }

    /**
     * Inverts images rendering a 'negative' of the input.
     *
     * @return self
     */
    public function inverting(): self
    {
        $this->transformations['inverting'] = Inverting::transform();

        return $this;
    }

    /**
     * Set how Uploadcare behaves depending on different color profiles of uploaded images. 
     * See their documentation to learn more about the possible outcomes.
     * https://uploadcare.com/docs/transformations/image/colors/#image-color-profile-management
     *
     * @param string $profile
     * @return self
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
     * @return self
     */
    public function iccProfileSizeThreshold(int $number = 10): self
    {
        $this->transformations['icc_profile_size_threshold'] = ICCProfileSizeThreshold::transform($number);

        return $this;
    }
}
