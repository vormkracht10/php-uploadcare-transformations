<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

class TransformationsFinder
{
    public const CROP_BY_OBJECTS = 'crop_by_objects';
    public const PREVIEW = 'preview';

    public static function getTransformation($key)
    {
        $transformations = [
            self::CROP_BY_OBJECTS => CropByObjects::class,
            self::PREVIEW => Preview::class,
        ];

        return $transformations[$key] ?? null;
    }

    public static function for(array $transformations)
    {
        $classes = [];

        $keys = array_keys($transformations);

        foreach ($keys as $transformation) {
            $classes[$transformation] = [
                'class' => self::getTransformation($transformation),
                'values' => $transformations[$transformation],
            ];
        }

        return $classes;
    }
}
