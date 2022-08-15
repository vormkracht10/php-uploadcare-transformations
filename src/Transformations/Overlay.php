<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Methods;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Overlay implements TransformationInterface
{
    use Methods;

    public const UUID = 'uuid';
    public const DIMENSION_X = 'dimension_x';
    public const DIMENSION_Y = 'dimension_y';
    public const RELATIVE_COORDINATES = 'relative_coordinates';
    public const OPACITY = 'opacity';

    public static function transform(...$args): array
    {
        $uuid = $args[0];
        $dimensionX = $args[1];
        $dimensionY = $args[2];
        $relativeCoordinates = $args[3];
        $opacity = $args[4];

        if (is_string($dimensionX) && ! self::validate('dimension_x', $dimensionX)) {
            throw new \InvalidArgumentException('Invalid dimension X');
        }

        if (is_string($dimensionY) && ! self::validate('dimension_y', $dimensionY)) {
            throw new \InvalidArgumentException('Invalid dimension Y');
        }

        if (is_string($relativeCoordinates) && ! self::validate('relative_coordinates', $relativeCoordinates)) {
            throw new \InvalidArgumentException('Invalid coordinates');
        }

        return [
            self::UUID => $uuid,
            self::DIMENSION_X => $dimensionX,
            self::DIMENSION_Y => $dimensionY,
            self::RELATIVE_COORDINATES => $relativeCoordinates,
            self::OPACITY => $opacity,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::DIMENSION_X ||
            $key === self::DIMENSION_Y) {
            return self::isValidPercentage($value) ;
        }

        if ($key === self::RELATIVE_COORDINATES) {
            if (Offset::tryFrom($value)) {
                return true;
            }

            if (self::isValidPercentage($value)) {
                return true;
            }

            return false;
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // TODO: Overlay
        // -/overlay/:uuid/:relative_dimensions/:relative_coordinates/:opacity/

        return $url;
    }
}
