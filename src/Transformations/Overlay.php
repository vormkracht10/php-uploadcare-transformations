<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Validations;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Overlay implements TransformationInterface
{
    use Validations;

    public const UUID = 'uuid';
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const COORDINATE_X = 'coordinateX';
    public const COORDINATE_Y = 'coordinateY';
    public const OPACITY = 'opacity';

    public static function transform(...$args): array
    {
        $uuid = $args[0];
        $width = $args[1] ?? null;
        $height = $args[2] ?? null;
        $coordinateX = $args[3] ?? null;
        $coordinateY = $args[4] ?? null;
        $opacity = $args[5] ?? null;

        if (is_string($width) && ! self::validate('width', $width)) {
            throw new \InvalidArgumentException('Invalid width percentage');
        }

        if (is_string($height) && ! self::validate('height', $height)) {
            throw new \InvalidArgumentException('Invalid height percentage');
        }

        if ($coordinateX && ! self::validate('coordinateX', $coordinateX)) {
            throw new \InvalidArgumentException('Invalid coordinate X');
        }

        if ($coordinateY && ! self::validate('coordinateY', $coordinateY)) {
            throw new \InvalidArgumentException('Invalid coordinate Y');
        }

        return [
            self::UUID => $uuid,
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::COORDINATE_X => $coordinateX,
            self::COORDINATE_Y => $coordinateY,
            self::OPACITY => $opacity,
        ];
    }

    /**
     * @todo add proper validation for both coordinates
     * @see https://uploadcare.com/docs/transformations/image/overlay/#overlay-image
     */
    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::COORDINATE_X && is_string($value)) {
            return Offset::tryFrom($value) !== null;
        }

        if ($key === self::WIDTH || $key === self::HEIGHT) {
            return self::isValidPercentage($value);
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // Check if only uuid is set
        if (isset($values[self::UUID]) &&
            ! isset($values[self::WIDTH]) &&
            ! isset($values[self::HEIGHT]) &&
            ! isset($values[self::COORDINATE_X]) &&
            ! isset($values[self::COORDINATE_Y]) &&
            ! isset($values[self::OPACITY])) {
            // -/overlay/:uuid/
            $url .= '-/overlay/' . $values[self::UUID] . '/';
        }

        // Check if only width/height is passed.
        if (isset($values[self::UUID]) &&
            isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            ! isset($values[self::COORDINATE_X]) &&
            ! isset($values[self::COORDINATE_Y])) {
            // -/overlay/:uuid/:relative_dimensions/
            return $url . '-/overlay/' . $values[self::UUID] . '/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/';
        }

        // Check if only width/height and coordinateX is passed.
        if (isset($values[self::UUID]) &&
            isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            ! isset($values[self::COORDINATE_Y])) {
            // -/overlay/:uuid/:relative_dimensions/:coordinateX/
            return $url . '-/overlay/' . $values[self::UUID] . '/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . '/';
        }

        // Check if only width/height and coordinates is passed.
        if (isset($values[self::UUID]) &&
            isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            isset($values[self::COORDINATE_Y])) {
            // -/overlay/:uuid/:relative_dimensions/:coordinateX/:coordinateY/
            return $url . '-/overlay/' . $values[self::UUID] . '/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . 'x' . $values[self::COORDINATE_Y] . '/';
        }

        // Check if only width/height and coordinates and opacity is passed.
        if (
            isset($values[self::UUID]) &&
            isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            isset($values[self::COORDINATE_Y]) &&
            isset($values[self::OPACITY])) {
            // -/overlay/:uuid/:relative_dimensions/:coordinateX/:coordinateY/:opacity/
            return $url . '-/overlay/' . $values[self::UUID] . '/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . 'x' . $values[self::COORDINATE_Y] . '/' . $values[self::OPACITY] . '/';
        }

        return $url;
    }
}
