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

    public static function generateUrl(string $url, array $values): string
    {

        // if (isset($this->transformations['icc_profile_size_threshold'])) {
        //     $transformation = $this->transformations['icc_profile_size_threshold'];

        //     // -/max_icc_size/:number
        //     $url .= '/max_icc_size/' . $transformation['number'];
        // }

        // -/srgb/:profile
        $url .= '/srgb/' . $values['profile'];

        return $url;
    }
}
