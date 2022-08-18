<?php

namespace Vormkracht10\UploadcareTransformations;

use Vormkracht10\UploadcareTransformations\Transformations\TransformationsFinder;

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

    /**
     * Apply all (chained) transformations to the given URL.
     *
     * @param string $url
     * @return string
     */
    public function applyTransformations(string $url): string
    {
        $transformations = TransformationsFinder::for($this->transformations);

        foreach ($transformations as $transformation) {
            $url = $transformation['class']::generateUrl($url, $transformation['values']);
        }

        return $url;
    }
}
