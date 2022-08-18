<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

if (! function_exists('uploadcare')) {
    function uploadcare(string $uuid, string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        return new UploadcareTransformation($uuid, $cdnUrl);
    }
}

if (! function_exists('uc')) {
    function uc(string $uuid, string $cdnUrl = 'https://ucarecdn.com/'): UploadcareTransformation
    {
        return uploadcare($uuid, $cdnUrl);
    }
}
