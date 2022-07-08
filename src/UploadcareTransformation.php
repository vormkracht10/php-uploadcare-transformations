<?php

namespace Vormkracht10\UploadcareTransformations;

use Vormkracht10\UploadcareTransformations\Traits\Methods;
use Vormkracht10\UploadcareTransformations\Methods\Transformations;

class UploadcareTransformation extends Transformations
{
    use Methods; 
    
    protected string $uuid;
    protected array $transformations;
    protected string $url;
    protected string $baseUrl;

    public function __construct(string $uuid, string $cdnUrl = 'https://ucarecdn.com/')
    {
        $this->uuid = $uuid;
        $this->transformations = [];
        $this->baseUrl = $cdnUrl;
    }

    public function getUrl()
    {
        $url = $this->baseUrl . $this->uuid;

        return $this->applyTransformations($url);
    }

    public function __toString()
    {
        return $this->getUrl();
    }
}
