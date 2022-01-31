<?php

namespace Vormkracht10\UploadcareTransformation;

use Vormkracht10\UploadcareTransformation\Methods;

class UploadcareTransformationClass extends Methods
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

    public function applyTransformations(string $url): string
    {
        if (isset($this->transformations['preview'])) {
            $url .= '/preview/' . $this->transformations['preview']['width'] . 'x' . $this->transformations['preview']['height'];
        }

        if (isset($this->transformations['resize'])) {
            if (isset($this->transformations['resize']['height']) && isset($this->transformations['resize']['width'])) {
                $url .= '/resize/' . $this->transformations['resize']['width'] . 'x' . $this->transformations['resize']['height'];
            } 
            
            if (isset($this->transformations['resize']['height']) && !isset($this->transformations['resize']['width'])) {
                $url .= '/resize/x' . $this->transformations['resize']['height'];
            }

            if (!isset($this->transformations['resize']['height']) && isset($this->transformations['resize']['width'])) {
                $url .= '/resize/' . $this->transformations['resize']['width'] . 'x';
            }
        }

        if (isset($this->transformations['smart_resize'])) {
            $url .= '/smart/' . $this->transformations['smart_resize']['width'] . 'x' . $this->transformations['smart_resize']['height'];
        }

        if (isset($this->transformations['crop'])) {
            if (isset($this->transformations['crop']['align'])) {
                $url .= '/crop/' . $this->transformations['crop']['width'] . 'x' . $this->transformations['crop']['height'] . '/' . $this->transformations['crop']['align'];
            } else {
                $url .= '/crop/' . $this->transformations['crop']['width'] . 'x' . $this->transformations['crop']['height'];
            }
        }

        return $url;
    }
}
