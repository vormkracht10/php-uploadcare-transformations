<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

if (! function_exists('uploadcare')) {
    function uploadcare(string $uuidOrUrl, string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        if(defined('LARAVEL_START')) {
            $cdnUrl = config('uploadcare.proxy_url');
        }

        if(strpos($uuidOrUrl, 'http') === 0) {
            return uploadcare(null, $cdnUrl)
                ->filename($uuidOrUrl);
        }

        return new UploadcareTransformation($uuid, $cdnUrl);
    }
}

if (! function_exists('uc')) {
    function uc(string $uuidOrUrl, string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        return uploadcare($uuidOrUrl, $cdnUrl);
    }
}
