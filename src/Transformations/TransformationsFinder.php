<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

class TransformationsFinder
{
    public const AUTO_ROTATE = 'auto_rotate';
    public const BASIC_COLOR_ADJUSTMENTS = 'basic_color_adjustments';
    public const BLUR = 'blur';
    public const BLUR_FACES = 'blur_faces';
    public const BLUR_REGION = 'blur_region';
    public const CONVERT_TO_SRGB = 'convert_to_srgb';
    public const CROP = 'crop';
    public const CROP_BY_OBJECTS = 'crop_by_objects';
    public const CROP_BY_RATIO = 'crop_by_ratio';
    public const ENHANCE = 'enhance';
    public const FILTER = 'filter';
    public const FLIP = 'flip';
    public const FORMAT = 'format';
    public const GRAYSCALE = 'grayscale';
    public const ICC_PROFILE_SIZE_THRESHOLD = 'icc_profile_size_threshold';
    public const INVERT = 'invert';
    public const MIRROR = 'mirror';
    public const PREVIEW = 'preview';
    public const PROGRESSIVE = 'progressive';
    public const QUALITY = 'quality';
    public const RESIZE = 'resize';
    public const ROTATE = 'rotate';
    public const SCALE_CROP = 'scale_crop';
    public const SET_FILL = 'set_fill';
    public const SHARPEN = 'sharpen';
    public const SMART_CROP = 'smart_crop';
    public const SMART_RESIZE = 'smart_resize';
    public const ZOOM_OBJECTS = 'zoom_objects';

    /**
     * Get transformation class
     *
     * @param string $key
     * @return string|null
     */
    public static function getTransformation(string $key): string|null
    {
        $transformations = [
            self::AUTO_ROTATE => AutoRotate::class,
            self::BASIC_COLOR_ADJUSTMENTS => BasicColorAdjustments::class,
            self::BLUR => Blur::class,
            self::BLUR_FACES => BlurFaces::class,
            self::BLUR_REGION => BlurRegion::class,
            self::CONVERT_TO_SRGB => ConvertToSRGB::class,
            self::CROP => Crop::class,
            self::CROP_BY_OBJECTS => CropByObjects::class,
            self::CROP_BY_RATIO => CropByRatio::class,
            self::ENHANCE => Enhance::class,
            self::FILTER => Filter::class,
            self::FLIP => Flip::class,
            self::FORMAT => Format::class,
            self::GRAYSCALE => Grayscale::class,
            self::ICC_PROFILE_SIZE_THRESHOLD => ICCProfileSizeThreshold::class,
            self::INVERT => Invert::class,
            self::MIRROR => Mirror::class,
            self::PREVIEW => Preview::class,
            self::PROGRESSIVE => Progressive::class,
            self::QUALITY => Quality::class,
            self::RESIZE => Resize::class,
            self::ROTATE => Rotate::class,
            self::SCALE_CROP => ScaleCrop::class,
            self::SET_FILL => SetFill::class,
            self::SHARPEN => Sharpen::class,
            self::SMART_CROP => SmartCrop::class,
            self::SMART_RESIZE => SmartResize::class,
            self::ZOOM_OBJECTS => ZoomObjects::class,
        ];

        return $transformations[$key] ?? null;
    }

    /**
     * Get all transformations
     *
     * @param array<array<array<string>>> $transformations
     * @return array<array{class: object, values: array<array<string>>}>
     */
    public static function for(array $transformations): array
    {
        $classes = [];

        $keys = array_keys($transformations);

        foreach ($keys as $transformation) {

            // Create a new class instance from the transformation
            $class = self::getTransformation($transformation);
            $class = new $class();
            
            // We need to check if ICCProfileSizeThreshold is used because it is a special case.
            // This is because the URL transformation is a part of the ConvertToSRGB transformation.
            if ($transformation === self::ICC_PROFILE_SIZE_THRESHOLD) {
                $classes[self::CONVERT_TO_SRGB] = [
                    'class' => $class,
                    'values' => [
                        'profile' => $transformations[self::CONVERT_TO_SRGB]['profile'],
                        'size' => $transformations[$transformation]['number'],
                    ],
                ];

                continue;
            }

            $classes[$transformation] = [
                'class' => self::getTransformation($transformation),
                'values' => $transformations[$transformation],
            ];
        }

        return $classes;
    }
}
