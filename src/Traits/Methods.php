<?php

namespace Vormkracht10\UploadcareTransformations\Traits;

use Vormkracht10\UploadcareTransformations\Transformations\TransformationsFinder;

trait Methods
{
    /**
     * Apply all (chained) transformations to the given URL.
     *
     * @param string $url
     * @return string
     */
    public function applyTransformations(string $url): string
    {
        $transformations = TransformationsFinder::for($this->transformations);

        foreach ($transformations as $transformation) {
            $url = $transformation['class']::generateUrl($url, $transformation['values']);
        }

        return $url;
    }

    /**
     * Check if value is a valid percentage format.
     *
     * @param string $value
     * @return bool
     */
    public static function isValidPercentage(string $value): bool
    {
        if (preg_match('/^[0-9]+p$/', $value)) {
            return true;
        }

        return false;
    }
}
