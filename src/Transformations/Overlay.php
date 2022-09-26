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
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // Every overlay parameter is optional and can be omitted. However, the order of parameter URL directives should be preserved.

        // -/overlay/:uuid/:relative_dimensions/:relative_coordinates/:opacity/

        // Check if only UUID is passed

        // Check if only UUID and width/height is passed

        // Check if only UUID and width/height and coordinateX is passed

        // Check if only UUID and width/height and coordinates is passed

        // Check if only UUID and width/height and coordinates and opacity is passed

        return $url;
    }
}
