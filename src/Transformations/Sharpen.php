<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Sharpen implements TransformationInterface
{
    public const STRENGTH = 'strength';

    public static function transform(...$args): array
    {
        $strength = $args[0] ?? null;

        if (! self::validate('strength', $strength)) {
            throw new \InvalidArgumentException('Invalid strength');
        }

        return [
            self::STRENGTH => $strength,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        $value = $args[0];

        if ($key === self::STRENGTH) {
            return $value >= 0 && $value <= 20;
        }

        return null;
    }
}