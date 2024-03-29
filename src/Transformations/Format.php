<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Format as FormatEnum;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Format implements TransformationInterface
{
    final public const FORMAT = 'format';

    public static function transform(...$args): array
    {
        $format = $args[0];

        if (FormatEnum::tryFrom($format) === null) {
            throw new \InvalidArgumentException('Invalid format');
        }

        return [
            self::FORMAT => $format,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/format/:format
        $url .= '-/format/' . $values['format'] . '/';

        return $url;
    }
}
