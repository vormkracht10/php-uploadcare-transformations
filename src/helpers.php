<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

if (! function_exists('uploadcare')) {
    function uploadcare(string $uuidOrUrl, ?string $cdnUrl = null, ?string $proxyUrl = null): UploadcareTransformation
    {
        if (
            defined('LARAVEL_START') &&
            function_exists('config')
        ) {
            if (is_null($cdnUrl)) {
                $cdnUrl = config('services.uploadcare.cdn_url');
            }

            if (is_null($proxyUrl)) {
                $proxyUrl = config('services.uploadcare.proxy_url');
            }
        }

        if (strpos($uuidOrUrl, 'http') === 0) {
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
