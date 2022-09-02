<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class SetFill implements TransformationInterface
{
    public const COLOR = 'color';

    public static function transform(...$args): array
    {
        $color = $args[0];

        if (! self::validate('color', $color)) {
            throw new \InvalidArgumentException('Color must be a valid hex color (without #)');
        }

        return [
            self::COLOR => $color,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::COLOR) {
            if (preg_match('/^[a-f0-9]{6}$/i', $value)) {
                return true;
            }
        }

        return true;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/set_fill/:color
        $url .= '-/setfill/' . $values['color'] . '/';

        return $url;
    }
}
