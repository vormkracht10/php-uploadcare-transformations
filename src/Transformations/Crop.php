<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Validations;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Crop implements TransformationInterface
{
    use Validations;

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

        if (is_string($width) && ! self::validate('width', $width)) {
            throw new \InvalidArgumentException('Invalid width percentage');
        }

        if (is_string($height) && ! self::validate('height', $height)) {
            throw new \InvalidArgumentException('Invalid height percentage');
        }

        if ($offsetX && ! self::validate('offset_x', $offsetX)) {
            throw new \InvalidArgumentException('Invalid offset X');
        }

        if ($offsetY && ! self::validate('offset_y', $offsetY)) {
            throw new \InvalidArgumentException('Invalid offset Y');
        }

        if (isset($offsetX) && Offset::tryFrom($offsetX)) {
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

        if ($key === self::OFFSET_Y || $key === self::WIDTH || $key === self::HEIGHT) {
            return self::isValidPercentage($value);
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        if (isset($values['align'])) {
            // -/crop/:dimensions/:alignment/
            $url .= '-/crop/' . $values['width'] . 'x' . $values['height'] . '/' . $values['align'] . '/';
        } elseif (isset($values['offset_x']) && isset($values['offset_y'])) {
            // -/crop/:dimensions/:alignment/
            $url .= '-/crop/' . $values['width'] . 'x' . $values['height'] . '/' . $values['offset_x'] . ',' . $values['offset_y'] . '/';
        } else {
            // -/crop/:dimensions/:alignment/
            $url .= '-/crop/' . $values['width'] . 'x' . $values['height'] . '/';
        }

        return $url;
    }
}
