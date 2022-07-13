<?php

namespace Vormkracht10\UploadcareTransformations\Methods;

use Vormkracht10\UploadcareTransformations\Methods\Enums\Transformation;

class UrlGenerator
{

    public array $transformations;
    public string $url; 

    public function __construct(array $transformations, string $url)
    {
        $this->transformations = $transformations;
        $this->url = $url;
    }

    public function getUrl(): string
    {
        $url = $this->url;

        foreach ($this->transformations as $key => $value) {
            
            $url .= $this->generateUrl($key);
        }

        return $url;
    }

    public function generateUrl(string $transformation): string 
    {
        // TODO: Check by enum
        // TODO: Add url transformation to the class
        dd($transformation);

        return '';
    }


}
