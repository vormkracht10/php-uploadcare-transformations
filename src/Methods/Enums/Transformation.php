<?php

namespace Vormkracht10\UploadcareTransformations\Methods\Enums;

enum Transformation: string
{
    case AUTO_ROTATE = 'auto_rotate';
    case BASIC_COLOR_ADJUSTMENTS = 'basic_color_adjustments';
    case BLUR = 'blur';
    case BLUR_FACES = 'blur_faces';
    case BLUR_REGION = 'blur_region';
    case CONVERT_TO_SRGB = 'convert_to_srgb';
    case CROP = 'crop';
    case CROP_BY_OBJECTS = 'crop_by_objects';
    case CROP_BY_RATIO = 'crop_by_ratio';
    case ENHANCE = 'enhance';
    case FILTER = 'filter';
    case FLIP = 'flip';
    case FORMAt = 'format';
    case GRAYSCALE = 'grayscale';
    case ICC_PROFILE_SIZE_THRESHOLD = 'icc_profile_size_threshold';
    case INVERTING = 'inverting';
    case MIRROR = 'mirror';
    case OVERLAY = 'overlay';
    case PREVIEW = 'preview';
    case PROGRESSIVE = 'progressive';
    case QUALITY = 'quality';
    case RESIZE = 'resize';
    case ROTATE = 'rotate';
    case SCALE_CROP = 'scale_crop';
    case SET_FILL = 'set_fill';
    case SHARPEN = 'sharpen';
    case SMART_CROP = 'smart_crop';
    case SMART_RESIZE = 'smart_resize';
    case ZOOM_OBJECTS = 'zoom_objects';
}
