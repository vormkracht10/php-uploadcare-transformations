<?php

namespace Vormkracht10\UploadcareTransformation\Methods;

class Transformations
{
    protected $offsetShortcuts = ['center', 'top', 'bottom', 'left', 'right'];

    /**
     * Downscales an image proportionally to fit the given width and height in pixels.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function preview(int $width, int $height): self
    {
        $this->transformations['preview'] = ['width' => $width, 'height' => $height];

        return $this;
    }

    /**
     * Resizes an image to one or two dimensions.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function resize(int $width = null, int $height = null): self
    {
        if (! $height && $width) {
            $this->transformations['resize'] = ['width' => $width];
        }

        if ($height && ! $width) {
            $this->transformations['resize'] = ['height' => $height];
        }

        if ($height && $width) {
            $this->transformations['resize'] = ['width' => $width, 'height' => $height];
        }

        return $this;
    }

    /**
     * Content-aware resize helps retaining original proportions of faces and other visually
     * sensible objects while resizing the rest of the image using intelligent algorithms.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function smartResize(int $width, int $height): self
    {
        $this->transformations['smart_resize'] = ['width' => $width, 'height' => $height];

        return $this;
    }

    /**
     * Crops an image by using specified dimensions and alignment.
     * Width and height in pixels or percents.
     * Horizontal and vertical offsets in pixels or percents, shortcuts as values are allowed: center, top, right, bottom, left.
     *
     * @param int $width
     * @param int $height
     * @param int|string $x
     * @param int $y
     * @return self
     */
    public function crop(int $width, int $height, int|string $x, ?int $y): self
    {
        if (is_string($x) && ! in_array($x, $this->offsetShortcuts)) {
            throw new \InvalidArgumentException('Invalid offset value.');
        }

        if (is_string($x) && in_array($x, $this->offsetShortcuts)) {
            $this->transformations['crop'] = ['width' => $width, 'height' => $height, 'align' => $x];
        } else {
            $this->transformations['crop'] = ['width' => $width, 'height' => $height, 'x' => $x, 'y' => $y];
        }

        return $this;
    }
}
