<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Methods;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class BlurRegion implements TransformationInterface
{
    use Methods;

    public const DIMENSION_X = 'dimension_x';
    public const DIMENSION_Y = 'dimension_y';
    public const COORDINATE_X = 'coordinate_x';
    public const COORDINATE_Y = 'coordinate_y';
    public const STRENGTH = 'strength';

    public static function transform(...$args): array
    {
        $dimensionX = $args[0];
        $dimensionY = $args[1];
        $coordinateX = $args[2];
        $coordinateY = $args[3];
        $strength = $args[4] ?? null;

        if (is_string($dimensionX) && ! self::validate('dimension_x', $dimensionX)) {
            throw new \InvalidArgumentException('Invalid dimension x');
        }

        if (is_string($dimensionY) && ! self::validate('dimension_y', $dimensionY)) {
            throw new \InvalidArgumentException('Invalid dimension y');
        }

        if (is_string($coordinateX) && ! self::validate('coordinate_x', $coordinateX)) {
            throw new \InvalidArgumentException('Invalid coordinate x');
        }

        if (is_string($coordinateY) && ! self::validate('coordinate_y', $coordinateY)) {
            throw new \InvalidArgumentException('Invalid coordinate y');
        }

        return [
            self::DIMENSION_X => $dimensionX,
            self::DIMENSION_Y => $dimensionY,
            self::COORDINATE_X => $coordinateX,
            self::COORDINATE_Y => $coordinateY,
            self::STRENGTH => $strength,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::DIMENSION_X ||
            $key === self::DIMENSION_Y ||
            $key === self::COORDINATE_X ||
            $key === self::COORDINATE_Y) {
            return self::isValidPercentage($value);
        }

        return false;
    }
}