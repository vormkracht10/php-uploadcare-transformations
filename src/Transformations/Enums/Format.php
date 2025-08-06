<?php

namespace Vormkracht10\UploadcareTransformations\Transformations\Enums;

enum Format: string
{
    case JPEG = 'jpeg';
    case PNG = 'png';
    case WEBP = 'webp';
    case AUTO = 'auto';
    case PRESERVE = 'preserve';
}
