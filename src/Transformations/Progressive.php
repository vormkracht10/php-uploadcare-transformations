<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Progressive implements TransformationInterface
{
    public const PROGRESSIVE = 'progressive';

    public static function transform(...$args): array
    {
        $progressive = $args[0];

        return [
            self::PROGRESSIVE => $progressive,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        $value = ($values['progressive']) ? 'yes' : 'no';

        // -/progressive/:value
        $url .= '-/progressive/' . $value . '/';

        return $url;
    }
}
