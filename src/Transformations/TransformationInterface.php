<?php 

namespace Vormkracht10\UploadcareTransformations\Transformations;

interface TransformationInterface
{
    public static function validate(string $key, ...$args): bool;

    public static function transform(...$args): array;
}