<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class AutoRotate implements TransformationInterface
{
    public const AUTO_ROTATE = 'auto_rotate';

    public static function transform(...$args): array
    {
        $autoRotate = $args[0];

        return [
            self::AUTO_ROTATE => $autoRotate
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }
}