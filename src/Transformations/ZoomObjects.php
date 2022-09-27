<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class ZoomObjects implements TransformationInterface
{
    public const ZOOM = 'zoom';

    /**
     * Validate and return the values.
     *
     * @param array<mixed>|string|int ...$args
     * @return array<mixed>
     */
    public static function transform(array|string|int ...$args): array
    {
        $zoom = $args[0];

        if (! self::validate('zoom', [$zoom])) {
            throw new \InvalidArgumentException('Invalid zoom');
        }

        return [
            self::ZOOM => $zoom,
        ];
    }

    /**
     * Validate the values.
     *
     * @param array<mixed>|string|int ...$args
     * @return bool
     */
    public static function validate(string $key, array|string|int ...$args): bool
    {
        $zoom = (float) $args[0];

        if ($key === self::ZOOM) {
            return $zoom >= 0 && $zoom <= 100;
        }

        return false;
    }

    /**
     * Generate the url.
     *
     * @param array<mixed> $values
     * @return string
     */
    public static function generateUrl(string $url, array $values): string
    {
        // -/zoom_objects/:zoom
        $url .= '-/zoom_objects/' . $values['zoom'] . '/';

        return $url;
    }
}
