<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Methods;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class ScaleCrop implements TransformationInterface
{
    use Methods;

    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const OFFSET_X = 'offset_x';
    public const OFFSET_Y = 'offset_y';
    public const ALIGN = 'align';

    public static function transform(...$args): array
    {
        $width = $args[0];
        $height = $args[1];
        $offsetX = $args[2] ?? null;
        $offsetY = $args[3] ?? null;

        if ($offsetX && ! self::validate('offset_x', $offsetX)) {
            throw new \InvalidArgumentException('Invalid offset X');
        }

        if ($offsetY && ! self::validate('offset_y', $offsetY)) {
            throw new \InvalidArgumentException('Invalid offset Y');
        }

        if (!$offsetY) {
            return [
                self::WIDTH => $width,
                self::HEIGHT => $height,
                self::ALIGN => $offsetX,
            ];
        }

        return [
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::OFFSET_X => $offsetX,
            self::OFFSET_Y => $offsetY,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::OFFSET_X) {
            return Offset::tryFrom($value) || self::isValidPercentage($value);   
        }

        if ($key === self::OFFSET_Y) {
            return self::isValidPercentage($value);
        }

        return false;
    }
}
