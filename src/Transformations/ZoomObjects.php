<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

class ZoomObjects implements TransformationInterface
{
    public const ZOOM = 'zoom';

    public static function transform(...$args): array
    {
        $zoom = $args[0];

        if (! self::validate('zoom', $zoom)) {
            throw new \InvalidArgumentException('Invalid zoom');
        }

        return [
            self::ZOOM => $zoom,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $zoom = $args[0];

        if ($key === self::ZOOM) {
            return $zoom >= 0 && $zoom <= 100;
        }

        return false;
    }
}
