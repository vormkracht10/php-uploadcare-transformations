<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

if (! function_exists('uploadcare')) {
    function uploadcare(?string $uuidOrUrl = '', string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        if (defined('LARAVEL_START')) {
            $cdnUrl = config('services.uploadcare.proxy_url');
        }

        if (strpos($uuidOrUrl, 'http') === 0) {
            return uploadcare('', $cdnUrl)
                ->filename($uuidOrUrl);
        }

        return new UploadcareTransformation($uuidOrUrl, $cdnUrl);
    }
}

if (! function_exists('uc')) {
    function uc(string $uuidOrUrl, string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        return uploadcare($uuidOrUrl, $cdnUrl);
    }
}
