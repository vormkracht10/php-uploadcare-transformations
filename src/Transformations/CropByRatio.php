<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Validations;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class CropByRatio implements TransformationInterface
{
    use Validations;

    public const RATIO = 'ratio';
    public const OFFSET_X = 'offset_x';
    public const OFFSET_Y = 'offset_y';
    public const ALIGN = 'align';

    public static function transform(...$args): array
    {
        $ratio = $args[0];
        $offsetX = $args[1];
        $offsetY = $args[2] ?? null;

        if (! self::validate('ratio', $ratio)) {
            throw new \InvalidArgumentException('Invalid ratio');
        }

        if ($offsetX && ! self::validate('offset_x', $offsetX)) {
            throw new \InvalidArgumentException('Invalid offset X');
        }

        if ($offsetY && ! self::validate('offset_y', $offsetY)) {
            throw new \InvalidArgumentException('Invalid offset Y');
        }

        if (isset($offsetX) && Offset::tryFrom($offsetX)) {
            return [
                self::RATIO => $ratio,
                self::ALIGN => $offsetX,
            ];
        }

        if (! $offsetX && ! $offsetY) {
            return [
                self::RATIO => $ratio,
            ];
        }

        return [
            self::RATIO => $ratio,
            self::OFFSET_X => $offsetX,
            self::OFFSET_Y => $offsetY,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        $value = $args[0];

        if ($key === self::RATIO) {
            return preg_match('/^[0-9]+:[0-9]+$/', $value);
        }

        if ($key === self::OFFSET_X) {
            return Offset::tryFrom($value) || self::isValidPercentage($value);
        }

        if ($key === self::OFFSET_Y) {
            return self::isValidPercentage($value);
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        if (isset($values['align'])) {
            // -/crop/:ratio/:alignment/
            $url .= '/crop/' . $values['ratio'] . '/' . $values['align'];
        } elseif (isset($values['offset_y']) && isset($values['offset_x'])) {
            // -/crop/:ratio/:alignment/
            $url .= '/crop/' . $values['ratio'] . '/' . $values['offset_x'] . ',' . $values['offset_y'];
        } else {
            // -/crop/:ratio/
            $url .= '/crop/' . $values['ratio'];
        }

        return $url;
    }
}
