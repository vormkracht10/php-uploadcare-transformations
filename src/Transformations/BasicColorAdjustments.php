<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Color;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class BasicColorAdjustments implements TransformationInterface
{
    public const VALUE = 'value';
    public const COLOR = 'color';

    public static function transform(...$args): array
    {
        $color = Color::tryFrom($args[0]);
        $value = $args[1];

        if (! $color) {
            throw new \InvalidArgumentException('Invalid color');
        }

        if (! self::validate('value', $value, $color)) {
            throw new \InvalidArgumentException('Invalid value');
        }

        return [
            self::COLOR => $color,
            self::VALUE => $value,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = (float) $args[0];
        $comparisonValue = $args[1] ?? null;

        if ($key === self::VALUE) {
            switch ($comparisonValue) {
                case Color::BRIGHTNESS:
                    return $value >= -100 && $value <= 100;
                case Color::EXPOSURE:
                    return $value >= -500 && $value <= 500;
                case Color::GAMMA:
                    return $value >= 0 && $value <= 1000;
                case Color::CONTRAST:
                    return $value >= -100 && $value <= 500;
                case Color::SATURATION:
                    return $value >= -100 && $value <= 500;
                case Color::VIBRANCE:
                    return $value >= -100 && $value <= 500;
                case Color::WARMTH:
                    return $value >= -100 && $value <= 100;
                default:
                    return false;
            }
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/:value/:color
        $url .= '-/basic_color_adjustments/' . $values['value'] . '/' . $values['color']->value . '/';

        return $url;
    }
}
