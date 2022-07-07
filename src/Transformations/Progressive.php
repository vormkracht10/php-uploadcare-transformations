<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

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
}
