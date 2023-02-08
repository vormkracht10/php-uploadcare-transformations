<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Color;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class BasicColorAdjustments implements TransformationInterface
{
    final public const VALUE = 'value';
    final public const COLOR = 'color';

    public static function transform(...$args): array
    {
        $color = Color::tryFrom($args[0]);
        $value = $args[1];

        if (!$color instanceof \Vormkracht10\UploadcareTransformations\Transformations\Enums\Color) {
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
            return match ($comparisonValue) {
                Color::BRIGHTNESS => $value >= -100 && $value <= 100,
                Color::EXPOSURE => $value >= -500 && $value <= 500,
                Color::GAMMA => $value >= 0 && $value <= 1000,
                Color::CONTRAST => $value >= -100 && $value <= 500,
                Color::SATURATION => $value >= -100 && $value <= 500,
                Color::VIBRANCE => $value >= -100 && $value <= 500,
                Color::WARMTH => $value >= -100 && $value <= 100,
                default => false,
            };
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
