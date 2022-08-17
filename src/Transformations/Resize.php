<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\ResizeMode;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Resize implements TransformationInterface
{
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const STRETCH = 'stretch';
    public const MODE = 'mode';

    public static function transform(...$args): array
    {
        $width = $args[0] ?? null;
        $height = $args[1] ?? null;
        $stretch = $args[2] ?? false;
        $mode = $args[3] ?? null;

        if ($mode && ! ResizeMode::tryFrom($mode)) {
            throw new \InvalidArgumentException('Invalid resize mode');
        }

        return [
            self::WIDTH => $width,
            self::HEIGHT => $height,
            self::STRETCH => $stretch,
            self::MODE => $mode,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/stretch/:mode/ (optional)
        $resizePrefix = $values['stretch'] ? '/stretch/' . $values['mode'] . '/-/resize/' : '/resize/';

        if ($values['height'] == null && $values['width'] !== null) {
            // -/resize/:one_or_two_dimensions/
            $url .= $resizePrefix . $values['width'] . 'x';
        } elseif ($values['height'] !== null && $values['width'] == null) {
            // -/resize/:one_or_two_dimensions/
            $url .= $resizePrefix . $values['height'] . 'x';
        } elseif ($values['height'] !== null && $values['width'] !== null) {
            // -/resize/:one_or_two_dimensions/
            $url .= $resizePrefix . $values['width'] . 'x' . $values['height'];
        }

        return $url;
    }
}
