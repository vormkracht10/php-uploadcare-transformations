<?php

namespace Vormkracht10\UploadcareTransformations\Transformations\Interfaces;

interface TransformationInterface
{
    public static function validate(string $key, array|string|int ...$args): ?bool;

    public static function transform(array|string|int  ...$args): array;

    public static function generateUrl(string $url, array $values): string;
}
