<?php

namespace Vormkracht10\UploadcareTransformations\Methods;

class Methods
{
    /**
     * Check if value is a valid percentage format.
     *
     * @param string $value
     * @return bool
     */
    public function isValidPercentage(string $value): bool
    {
        if (preg_match('/^[0-9]+p$/', $value)) {
            return true;
        }

        return false;
    }
}
