<?php

namespace Vormkracht10\UploadcareTransformations;

use Vormkracht10\UploadcareTransformations\Methods\Transformations;

class UploadcareTransformation extends Transformations
{
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

    public function applyTransformations(string $url): string
    {
        if (isset($this->transformations['preview'])) {
            $url .= '/preview/' . $this->transformations['preview']['width'] . 'x' . $this->transformations['preview']['height'];
        }

        if (isset($this->transformations['resize'])) {
            $resizePrefix = $this->transformations['resize']['stretch'] ? '/stretch/' . $this->transformations['resize']['mode'] . '/-/resize/' : '/resize/';

            if ($this->transformations['resize']['height'] == null && $this->transformations['resize']['width'] !== null) {
                $url .= $resizePrefix . $this->transformations['resize']['width'] . 'x';
            }

            if ($this->transformations['resize']['height'] !== null && $this->transformations['resize']['width'] == null) {
                $url .= $resizePrefix . $this->transformations['resize']['height'] . 'x';
            }

            if ($this->transformations['resize']['height'] !== null && $this->transformations['resize']['width'] !== null) {
                $url .= $resizePrefix . $this->transformations['resize']['width'] . 'x' . $this->transformations['resize']['height'];
            }
        }

        if (isset($this->transformations['smart_resize'])) {
            $url .= '/smart/' . $this->transformations['smart_resize']['width'] . 'x' . $this->transformations['smart_resize']['height'];
        }

        if (isset($this->transformations['crop'])) {
            if (isset($this->transformations['crop']['align'])) {
                $url .= '/crop/' . $this->transformations['crop']['width'] . 'x' . $this->transformations['crop']['height'] . '/' . $this->transformations['crop']['align'];
            }

            if (isset($this->transformations['crop']['x']) && isset($this->transformations['crop']['y'])) {
                $url .= '/crop/' . $this->transformations['crop']['width'] . 'x' . $this->transformations['crop']['height'] . '/' . $this->transformations['crop']['x'] . ',' . $this->transformations['crop']['y'];
            } else {
                $url .= '/crop/' . $this->transformations['crop']['width'] . 'x' . $this->transformations['crop']['height'];
            }
        }

        if (isset($this->transformations['crop_by_ratio'])) {
            if (isset($this->transformations['crop_by_ratio']['align'])) {
                $url .= '/crop/' . $this->transformations['crop_by_ratio']['ratio'] . '/' . $this->transformations['crop_by_ratio']['align'];
            }

            if (isset($this->transformations['crop_by_ratio']['align']) && isset($this->transformations['crop_by_ratio']['x'])) {
                $url .= '/crop/' . $this->transformations['crop_by_ratio']['ratio'] . '/' . $this->transformations['crop_by_ratio']['align'];
            } else {
                $url .= '/crop/' . $this->transformations['crop_by_ratio']['ratio'] . 'x' . $this->transformations['crop_by_ratio']['height'];
            }
        }

        return $url;
    }
}
