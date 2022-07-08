<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\ResizeMode;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Resize implements TransformationInterface
{
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const STRETCH = 'stretch';
    public const MODE = 'mode';

    public static function transform(...$args): array
    {
        $width = $args[0] ?? null;
        $height = $args[1] ?? null;
        $stretch = $args[2] ?? false;
        $mode = $args[3] ?? null;

        if ($mode && ! ResizeMode::tryFrom($mode)) {
            throw new \InvalidArgumentException('Invalid resize mode');
        }

        return [
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::STRETCH => $stretch,
            self::MODE => $mode, 
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }
}
