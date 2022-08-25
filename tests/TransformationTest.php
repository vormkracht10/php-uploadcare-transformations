<?php

it('can crop by objects', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $transformation = uploadcare($uuid);

    // -/crop/:tag/:dimensions/:alignment/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: null, width: 200, height: 200, offsetX: 'center');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/200x200/center/');

    // -/crop/:tag/:dimensions/:alignment/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: null, width: 200, height: 200, offsetX: '50p', offsetY: '50p');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/200x200/50p,50p/');

    // -/crop/:tag/:ratio/:alignment/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: '1:1', width: null, height: null, offsetX: '50p', offsetY: '50p');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/1:1/50p,50p/');

    // -/crop/:tag/:dimensions/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: null, width: 200, height: 200);
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/200x200/');

    // -/crop/:tag/:ratio/:alignment/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: '1:1', width: null, height: null, offsetX: 'center');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/1:1/center/');

    // -/crop/:tag/:ratio/
    $url = (string) $transformation->cropByObjects(tag: 'face', ratio: '1:1');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/1:1/');

    // -/crop/:tag/
    $url = (string) $transformation->cropByObjects(tag: 'face');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/face/');
});

it('can crop', function () {
    $uuid = '12a3456b-c789-1234-1de2-3cfa83096e25';
    $transformation = uploadcare($uuid);

    // -/crop/:dimensions/:alignment/
    $url = (string) $transformation->crop(width: 200, height: 200, offsetX: 'center');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/200x200/center/');

    // -/crop/:dimensions/:alignment/
    $url = (string) $transformation->crop(width: 200, height: 200, offsetX: '50p', offsetY: '50p');
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/200x200/50p,50p/');

    // -/crop/:dimensions/:alignment/
    $url = (string) $transformation->crop(width: 200, height: 200);
    expect($url)->toBe('https://ucarecdn.com/12a3456b-c789-1234-1de2-3cfa83096e25/crop/200x200/');
});
