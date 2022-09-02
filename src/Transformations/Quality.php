<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Quality as QualityEnum;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Quality implements TransformationInterface
{
    public const QUALITY = 'quality';

    public static function transform(...$args): array
    {
        $quality = QualityEnum::tryFrom($args[0]);

        if (! $quality) {
            throw new \InvalidArgumentException('Invalid quality');
        }

        return [
            self::QUALITY => $quality->value,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/quality/:quality
        $url .= '-/quality/' . $values['quality'] . '/';

        return $url;
    }
}
