<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Blur implements TransformationInterface
{
    public const STRENGTH = 'strength';
    public const AMOUNT = 'amount';

    public static function transform(...$args): array
    {
        $strength = $args[0];
        $amount = $args[1] ?? null;

        if (! self::validate('amount', $amount)) {
            throw new \InvalidArgumentException('Invalid amount');
        }

        return [
            self::AMOUNT => $strength,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        $value = $args[0];

        if ($key === self::AMOUNT) {
            return $value >= -200 && $value <= 100;
        }

        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // Strength and amount might be null
        // -/blur/:strength/:amount
        $url .= '-/blur/' . $values['strength'] . '/' . $values['amount'] . '/';

        return $url;
    }
}
