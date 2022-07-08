<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\ColorProfile;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class ConvertToSRGB implements TransformationInterface
{
    public const PROFILE = 'profile';

    public static function transform(...$args): array
    {
        $profile = $args[0];

        if (! ColorProfile::tryFrom($profile)) {
            throw new \InvalidArgumentException('Invalid color profile');
        }

        return [
            self::PROFILE => $profile,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }
}
