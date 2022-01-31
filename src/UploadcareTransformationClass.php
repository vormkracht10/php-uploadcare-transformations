<?php

namespace Vormkracht10\UploadcareTransformation;

class UploadcareTransformationClass
{
    protected string $uuid;
    protected array $transformations;
    protected string $url;
    protected string $baseUrl;

    public function __construct($uuid) 
    {
        $this->uuid = $uuid;
        $this->transformations = [];
        $this->baseUrl = 'https://ucarecdn.com/';
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

    public function applyTransformations(string $url)
    {
        if (isset($this->transformations['preview'])) {
            $url .= '/preview/' . $this->transformations['preview']['width'] . 'x' . $this->transformations['preview']['height'];
        }

        return $url;
    }

    public function preview(int $width, int $height)
    {
        $this->transformations['preview'] = ['width' => $width, 'height' => $height];

        return $this;
    }
}
