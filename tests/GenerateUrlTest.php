<?php

it('can generate a url without cdn', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $transformation = uploadcare($uuid);

    $url = (string) $transformation->crop(320, '50p', 'center')->setFill('ffffff');

    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/-/crop/320x50p/center/-/setfill/ffffff/');
});

it('can generate a url with cdn', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $cdnUrl = 'https://example.com/cdn/';

    $transformation = uploadcare($uuid, $cdnUrl);

    $url = (string) $transformation->crop(320, '50p', 'center')->setFill('ffffff');

    expect($url)->toBe('https://example.com/cdn/12a3456b-c789-1234-1de2-3cfa83096e25/-/crop/320x50p/center/-/setfill/ffffff/');
});

it('can generate a url using Conver to SRGB and ICC profile size threshold', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';

    $transformation = uploadcare($uuid);

    $url = (string) $transformation->convertToSRGB('fast')->iccProfileSizeThreshold(10);

    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/-/max_icc_size/10/-/srgb/fast/');
});

it('can generate a url including filename with transformations', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $transformation = uploadcare($uuid);

    $url = (string) $transformation->crop(320, '50p', 'center')->filename('test.jpg');

    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/-/crop/320x50p/center/test.jpg');
});
