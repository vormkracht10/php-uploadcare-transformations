<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

if (! function_exists('uploadcare')) {
    function uploadcare(string $uuidOrUrl, ?string $cdnUrl = null): UploadcareTransformation
    {
        if (strpos($uuidOrUrl, 'http') === 0) {
            if (
                is_null($cdnUrl) &&
                defined('LARAVEL_START') &&
                function_exists('config')
            ) {
                $proxyUrl = config('services.uploadcare.proxy_url');
            }

            return new UploadcareTransformation(proxyUrl: $proxyUrl, filename: $uuidOrUrl);
        }

        return new UploadcareTransformation(uuid: $uuidOrUrl, cdnUrl: $cdnUrl);
    }
}

if (! function_exists('uc')) {
    function uc(string $uuidOrUrl, ?string $cdnUrl = null): UploadcareTransformation
    {
        return uploadcare($uuidOrUrl, $cdnUrl);
    }
}
