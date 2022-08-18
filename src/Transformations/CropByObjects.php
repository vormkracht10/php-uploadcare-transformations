<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Traits\Validations;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Offset;
use Vormkracht10\UploadcareTransformations\Transformations\Enums\Tag;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class CropByObjects implements TransformationInterface
{
    use Validations;

    public const TAG = 'tag';
    public const RATIO = 'ratio';
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const OFFSET_X = 'offset_x';
    public const OFFSET_Y = 'offset_y';
    public const ALIGN = 'align';

    public static function transform(...$args): array
    {
        $tag = $args[0];
        $ratio = $args[1] ?? null;
        $width = $args[2] ?? null;
        $height = $args[3] ?? null;
        $offsetX = $args[4] ?? null;
        $offsetY = $args[5] ?? null;


        if (! Tag::tryFrom($tag)) {
            throw new \InvalidArgumentException('Invalid tag');
        }

        if ($ratio && ! self::validate('ratio', $ratio)) {
            throw new \InvalidArgumentException('Invalid ratio');
        }

        if ($offsetX && ! self::validate('offset_x', $offsetX)) {
            throw new \InvalidArgumentException('Invalid offset X');
        }

        if ($offsetY && ! self::validate('offset_y', $offsetY)) {
            throw new \InvalidArgumentException('Invalid offset Y');
        }

        if (! $offsetY) {
            return [
                self::TAG => $tag,
                self::RATIO => $ratio,
                self::WIDTH => $width,
                self::HEIGHT => $height,
                self::ALIGN => $offsetX,
            ];
        }

        return [
            self::TAG => $tag,
            self::RATIO => $ratio,
            self::WIDTH => $width,
            self::HEIGHT => $height,
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

        if ($key === self::OFFSET_Y || $key === self::WIDTH || $key === self::HEIGHT) {
            return self::isValidPercentage($value);
        }

        return false;
    }

    public static function generateUrl(string $url, array $values): string
    {
        if (isset($values['width']) && isset($values['height']) && isset($values['align'])) {
            // -/crop/:tag/:dimensions/:alignment/
            $url .= '/crop/' . $values['tag'] . '/' . $values['width'] . 'x' . $values['height'] . '/' . $values['align'];
        } elseif (isset($values['width']) && isset($values['height']) && isset($values['x']) && isset($values['y'])) {
            // -/crop/:tag/:dimensions/:alignment/
            $url .= '/crop/' . $values['tag'] . '/' . $values['width'] . 'x' . $values['height'] . '/' . $values['x'] . ',' . $values['y'];
        } elseif (isset($values['ratio']) && isset($values['x']) && isset($values['y'])) {
            // -/crop/:tag/:ratio/:alignment/
            $url .= '/crop/' . $values['tag'] . '/' . $values['ratio'] . '/' . $values['x'] . ',' . $values['y'];
        } elseif (isset($values['width']) && isset($values['height'])) {
            // -/crop/:tag/:dimensions/
            $url .= '/crop/' . $values['tag'] . '/' . $values['width'] . 'x' . $values['height'];
        } elseif (isset($values['ratio']) && isset($values['align'])) {
            // -/crop/:tag/:ratio/:alignment/
            $url .= '/crop/' . $values['tag'] . '/' . $values['ratio'] . '/' . $values['align'];
        } elseif (isset($values['ratio'])) {
            // -/crop/:tag/:ratio/
            $url .= '/crop/' . $values['tag'] . '/' . $values['ratio'];
        } else {
            // -/crop/:tag/
            $url .= '/crop/' . $values['tag'];
        }

        return $url;
    }
}
