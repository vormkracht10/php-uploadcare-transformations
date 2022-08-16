<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Format as FormatEnum;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Format implements TransformationInterface
{
    public const FORMAT = 'format';

    public static function transform(...$args): array
    {
        $format = FormatEnum::tryFrom($args[0]);

        if (! $format) {
            throw new \InvalidArgumentException('Invalid format');
        }

        return [
            self::FORMAT => $format,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/format/:format
        $url .= '/format/' . $values['format'];

        return $url;
    }
}
