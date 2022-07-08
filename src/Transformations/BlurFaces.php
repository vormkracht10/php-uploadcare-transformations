<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class BlurFaces implements TransformationInterface
{
    public const STRENGTH = 'strength';

    public static function transform(...$args): array
    {
        $strength = $args[0] ?? null;

        return [
            self::STRENGTH => $strength,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }
}
