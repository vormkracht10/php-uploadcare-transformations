<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Quality as QualityEnum;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Quality implements TransformationInterface
{
    final public const QUALITY = 'quality';

    public static function transform(...$args): array
    {
        $quality = QualityEnum::tryFrom($args[0]);

        if (! $quality instanceof \Vormkracht10\UploadcareTransformations\Transformations\Enums\Quality) {
            throw new \InvalidArgumentException('Invalid quality');
        }

        return [
            self::QUALITY => $quality->value,
        ];
    }

    public static function validate(string $key, ...$args): bool
    {
        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/quality/:quality
        $url .= '-/quality/' . $values['quality'] . '/';

        return $url;
    }
}
