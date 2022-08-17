<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class ICCProfileSizeThreshold implements TransformationInterface
{
    public const NUMBER = 'number';

    public static function transform(...$args): array
    {
        $number = $args[0];

        return [
            self::NUMBER => $number,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // We don't have to do anything here as it is already part of of the ConvertToSRGB transformation.
        return $url;
    }
}
