<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Methods;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\CropType;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class SmartCrop implements TransformationInterface
{
    use Methods;

    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const TYPE = 'type';
    public const OFFSET_X = 'offset_x';
    public const OFFSET_Y = 'offset_y';
    public const ALIGN = 'align';

    public static function transform(...$args): array
    {
        $width = $args[0];
        $height = $args[1];
        $type = CropType::tryFrom($args[2]);
        $offsetX = $args[3] ?? null;
        $offsetY = $args[4] ?? null;

        if (! $type) {
            throw new \InvalidArgumentException('Invalid crop type');
        }

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
                self::TYPE => $type->value,
                self::ALIGN => $offsetX,
            ];
        }

        return [
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::TYPE => $type->value,
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

        if ($key === self::TYPE) {
            return CropType::tryFrom($value);
        }

        return false;
    }
}