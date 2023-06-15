<?php

namespace Vormkracht10\UploadcareTransformations;

use Vormkracht10\UploadcareTransformations\Transformations\TransformationsFinder;

class UploadcareTransformation extends Transformations implements \Stringable
{
    protected string $url;
    protected ?string $filename = null;

    public function __construct(protected string $uuid, protected string $baseUrl = 'https://ucarecdn.com/')
    {
    }

    public function filename(string $filename): string
    {
        $this->filename = $filename;

        return $this;
    }

    public function transform(array $transformations = []): self
    {
        foreach($transformations as $transformation => $parameters) {
            $this->{$transformation}(...$parameters);
        }

        return $this;
    }

    /**
     * Apply all (chained) transformations to the given URL.
     */
    public function applyTransformations(string $url): string
    {
        $transformations = TransformationsFinder::for($this->transformations);

        foreach ($transformations as $transformation) {
            $url = $transformation['class']::generateUrl($url, $transformation['values']);
        }

        return $url;
    }

    public function getUrl(): string
    {
        $url = $this->applyTransformations($this->baseUrl . $this->uuid . '/');

        // Check if url contains one of the following strings: 'blur_region', 'enhance', 'filter', 'zoom_objects'
        // because these transformations won't work if they do not contain the preview transformation as well.
        // Check if url contains 'resize', 'scale_crop' or 'preview'. If not add, add 'preview' to the url.
        // By using 'preview' the image will not be changed and produce the biggest possible image.
        if (
            preg_match('~\/(blur_region|enhance|filter|rasterize|zoom_objects)\/~', $url) &&
            ! preg_match('~\/(preview|scale_crop|smart_resize|resize)\/~', $url)
        ) {
            $url .= '-/preview/';
        }

        if (! str_ends_with($url, '/')) {
            $url .= '/';
        }

        if ($this->filename) {
            $url = rtrim($url, '/') . '/' . $this->filename;
        }

        return $url;
    }

    public function __toString(): string
    {
        return $this->getUrl();
    }
}
