<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\ResizeMode;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Preview implements TransformationInterface
{
    public const WIDTH = 'width';
    public const HEIGHT = 'height';

    public static function transform(...$args): array
    {
        $width = $args[0] ?? null;
        $height = $args[1] ?? null;

        return [
            self::WIDTH => $width,
            self::HEIGHT => $height,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }
}
