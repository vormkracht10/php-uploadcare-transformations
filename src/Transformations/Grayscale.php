<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Grayscale implements TransformationInterface
{
    public static function transform(...$args): array
    {
        return [];
    }

    public static function validate(string $key, ...$args): bool
    {
        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/grayscale
        $url .= '-/grayscale/';

        return $url;
    }
}
