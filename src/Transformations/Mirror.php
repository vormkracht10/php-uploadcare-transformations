<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Mirror implements TransformationInterface
{
    public static function transform(...$args): array
    {
        return [];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // /mirror/
        $url .= '-/mirror/';

        return $url;
    }
}
