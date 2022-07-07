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
            throw new \InvalidArgumentException('Color must be a valid hex color');
        }

        return [
            self::COLOR => $color,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::COLOR) {
            if (preg_match('/^#[a-f0-9]{6}$/i', $value)) {
                return true;
            }
        }

        return false;
    }
}
