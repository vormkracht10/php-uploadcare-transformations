<?php

namespace Vormkracht10\UploadcareTransformations\Traits;

trait Validations
{
    /**
     * Check if value is a valid percentage format.
     */
    public static function isValidPercentage(string $value): bool
    {
        return (bool) preg_match('/^\d+p$/', $value);
    }
}
