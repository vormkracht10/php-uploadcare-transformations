<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Overlay implements TransformationInterface
{
    public const UUID = 'uuid';
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const COORDINATE_X = 'coordinateX';
    public const COORDINATE_Y = 'coordinateY';
    public const OPACITY = 'opacity';

    public static function transform(...$args): array
    {
        $uuid = $args[0];
        $width = $args[1];
        $height = $args[2];
        $coordinateX = $args[3];
        $coordinateY = $args[4];
        $opacity = $args[5];

        return [
            self::UUID => $uuid,
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::COORDINATE_X => $coordinateX,
            self::COORDINATE_Y => $coordinateY,
            self::OPACITY => $opacity,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        /** @todo add validation */
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // Every overlay parameter is optional and can be omitted. However, the order of parameter URL directives should be preserved.
        // -/overlay/:uuid/:relative_dimensions/:relative_coordinates/:opacity/

        // Check if only uuid is set
        /** @todo add UUID checks */
        // if (isset($values[self::UUID]) )

        // Check if only width/height is passed.
        if (isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            ! isset($values[self::COORDINATE_X]) &&
            ! isset($values[self::COORDINATE_Y])) {
            return $url . '-/overlay/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/';
        }

        // Check if only width/height and coordinateX is passed.
        if (isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            ! isset($values[self::COORDINATE_Y])) {
            return $url . '-/overlay/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . '/';
        }

        // Check if only width/height and coordinates is passed.
        if (isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            isset($values[self::COORDINATE_Y])) {
            return $url . '-/overlay/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . 'x' . $values[self::COORDINATE_Y] . '/';
        }

        // Check if only width/height and coordinates and opacity is passed.
        if (isset($values[self::WIDTH]) &&
            isset($values[self::HEIGHT]) &&
            isset($values[self::COORDINATE_X]) &&
            isset($values[self::COORDINATE_Y]) &&
            isset($values[self::OPACITY])) {
            return $url . '-/overlay/' . $values[self::WIDTH] . 'x' . $values[self::HEIGHT] . '/' . $values[self::COORDINATE_X] . 'x' . $values[self::COORDINATE_Y] . '/' . $values[self::OPACITY] . '/';
        }

        return $url;
    }
}
