<?php

namespace Vormkracht10\UploadcareTransformations\Transformations;

use Vormkracht10\UploadcareTransformations\Transformations\Enums\Filter as FilterEnum;
use Vormkracht10\UploadcareTransformations\Transformations\Interfaces\TransformationInterface;

class Filter implements TransformationInterface
{
    public const NAME = 'name';
    public const AMOUNT = 'amount';

    public static function transform(...$args): array
    {
        $name = $args[0];
        $amount = $args[1];

        if (! FilterEnum::tryFrom($name)) {
            throw new \InvalidArgumentException('Invalid filter');
        }

        if (! self::validate('amount', $amount)) {
            throw new \InvalidArgumentException('Invalid amount');
        }

        return [
            self::NAME => $name,
            self::AMOUNT => $amount,
        ];
    }

    public static function validate(string $key, ...$args): ?bool
    {
        $value = $args[0];

        if ($key === self::AMOUNT) {
            return $value >= -100 && $value <= 200;
        }

        return null;
    }

    public static function generateUrl(string $url, array $values): string
    {
        // -/filter/:name/:amount/
        $url .= '-/filter/' . $values['name'] . '/' . $values['amount'] . '/';

        return $url;
    }
}
