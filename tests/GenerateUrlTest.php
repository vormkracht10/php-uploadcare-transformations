<?php

use Vormkracht10\UploadcareTransformations\UploadcareTransformation;

it('can generate a url without cdn', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $transformation = (new UploadcareTransformation($uuid));

    $url = $transformation->crop(320, '50p', 'center')->setFill('#ffffff')->getUrl();

    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/320x50p/center/set_fill/#ffffff');
});

it('can generate a url with cdn', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $cdnUrl = 'https://example.com/cdn/';

    $transformation = (new UploadcareTransformation($uuid, $cdnUrl));

    $url = $transformation->crop(320, '50p', 'center')->setFill('#ffffff')->getUrl();

    expect($url)->toBe('https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/crop/320x50p/center/set_fill/#ffffff');
});

it('can generate a url using Conver to SRGB and ICC profile size threshold', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';

    $transformation = (new UploadcareTransformation($uuid));

    $url = $transformation->convertToSRGB('fast')->iccProfileSizeThreshold(10)->getUrl();

    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/max_icc_size/10/srgb/fast');
});