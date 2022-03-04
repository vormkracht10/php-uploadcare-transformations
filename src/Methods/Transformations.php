<?php

namespace Vormkracht10\UploadcareTransformations\Methods;

use Vormkracht10\UploadcareTransformations\Traits\Methods;

class Transformations
{
    use Methods;

    protected array $offsetShortcuts = ['center', 'top', 'bottom', 'left', 'right'];
    protected array $resizeModes = ['on', 'off', 'fill'];
    protected array $tags = ['face', 'image'];

    /**
     * Downscales an image proportionally to fit the given width and height in pixels.
     *
     * @param int $width in pixels.
     * @param int $height in pixels.
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
     * @param int|null $width in pixels.
     * @param int|null $height in pixels.
     * @param bool $stretch
     * @param string|null $mode one of the resize modes.
     * @return self
     */
    public function resize(int $width = null, int $height = null, bool $stretch = false, string $mode = null): self
    {
        // Check if $mode is a valid resize mode
        if ($mode !== null && ! in_array($mode, $this->resizeModes)) {
            throw new \InvalidArgumentException('Invalid resize mode. Valid modes are: ' . implode(', ', $this->resizeModes));
        }

        $this->transformations['resize'] = ['width' => $width, 'height' => $height, 'stretch' => $stretch, 'mode' => $mode];

        return $this;
    }

    /**
     * Content-aware resize helps retaining original proportions of faces and other visually
     * sensible objects while resizing the rest of the image using intelligent algorithms.
     *
     * @param int $width in pixels
     * @param int $height in pixels
     * @return self
     */
    public function smartResize(int $width, int $height): self
    {
        $this->transformations['smart_resize'] = ['width' => $width, 'height' => $height];

        return $this;
    }

    /**
     * Crops an image by using specified dimensions and alignment.
     *
     * @param int $width in pixels or percents.
     * @param int $height in pixels or percents.
     * @param int|string $offsetX horizontal and vertical offsets in pixels or percents (e.g. 50p) or shortcuts.
     * @param int|string $offsetY 
     * @return self
     */
    public function crop(int|string $width, int|string $height, int|string $offsetX, int|string $offsetY = null): self
    {
        // If width, height or offsetY is a string, we should check if it is valid
        if (is_string($width) && ! $this->isValidPercentage($width) || is_string($height) && ! $this->isValidPercentage($height) || is_string($offsetY) && ! $this->isValidPercentage($offsetY)) {
            throw new \InvalidArgumentException("Invalid percentage.");
        }

        // Check if offsetX is a string and if it is a valid offset shortcut or percentage
        if (is_string($offsetX) && ! in_array($offsetX, $this->offsetShortcuts) && ! $this->isValidPercentage($offsetX)) {
            throw new \InvalidArgumentException("Invalid offset shortcut or percentage.");
        }

        if (is_string($offsetX) && in_array($offsetX, $this->offsetShortcuts) && ! $this->isValidPercentage($offsetX)) {
            $this->transformations['crop'] = ['width' => $width, 'height' => $height, 'align' => $offsetX];
        } else {
            $this->transformations['crop'] = ['width' => $width, 'height' => $height, 'x' => $offsetX, 'y' => $offsetY];
        }

        return $this;
    }

    /**
     * Crops the image to the specified aspect ratio, cutting off the rest of the image.
     *
     * @param string $ratio two numbers greater than zero separated by :
     * @param int|string $offsetX horizontal and vertical offsets in pixels or percents or shortcuts.
     * @param int $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function cropByRatio(string $ratio, int|string $offsetX, int|string $offsetY = null): self
    {
        // Check if offsetX is a string and if it is a valid offset shortcut or percentage
        if (is_string($offsetX) && ! in_array($offsetX, $this->offsetShortcuts) && ! $this->isValidPercentage($offsetX)) {
            throw new \InvalidArgumentException("Invalid offset shortcut or percentage.");
        }

        // Check if offsetY is a string and if it is a valid percentage
        if (is_string($offsetY) && ! $this->isValidPercentage($offsetY)) {
            throw new \InvalidArgumentException("Invalid offset percentage.");
        }

        // Check if ratio is valid (two numbers greater
        if (! preg_match('/^[0-9]+:[0-9]+$/', $ratio)) {
            throw new \InvalidArgumentException('Invalid ratio.');
        }

        if (is_string($offsetX) && in_array($offsetX, $this->offsetShortcuts)) {
            $this->transformations['crop_by_ratio'] = ['ratio' => $ratio, 'align' => $offsetX];
        }

        if (! is_string($offsetX) && $offsetY) {
            $this->transformations['crop_by_ratio'] = ['ratio' => $ratio, 'x' => $offsetX, 'y' => $offsetY];
        }

        if (! $offsetX && ! $offsetY) {
            $this->transformations['crop_by_ratio'] = ['ratio' => $ratio];
        }

        return $this;
    }

    /**
     * Crops the image to the object specified by the :tag parameter.
     *
     * @param string $tag one of the tags.
     * @param string $ratio two numbers greater than zero separated by :
     * @param string $width in percentages e.g. 50p.
     * @param string $heigt in percentages e.g. 50p.
     * @param string $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param string $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function cropByObjects(string $tag, string $ratio = null, string $width = null, string $heigt = null, string $offsetX = null, string $offsetY = null): self
    {
        // Check if tag is valid
        if (! in_array($tag, $this->tags)) {
            throw new \InvalidArgumentException('Invalid tag');
        }

        // Check if ratio is valid 
        if (isset($ratio) && ! preg_match('/^[0-9]+:[0-9]+$/', $ratio)) {
            throw new \InvalidArgumentException('Invalid ratio.');
        }

        // Check if valid percentages
        if (isset($width) && ! $this->isValidPercentage($width) || isset($height) && ! $this->isValidPercentage($heigt)) {
            throw new \InvalidArgumentException('Invalid percentage.');
        }

        // Check if offsetX is a string and if it is a valid offset shortcut or percentage
        if (!in_array($offsetX, $this->offsetShortcuts) && isset($offsetX) && !$this->isValidPercentage($offsetX)) {
            throw new \InvalidArgumentException("Invalid offset shortcut or percentage.");
        }

        // Check if alignment is set by shortcut or percentages
        if (!$offsetY) {
            $this->transformations['crop_by_objects'] = ['tag' => $tag, 'ratio' => $ratio, 'width' => $width, 'height' => $heigt, 'align' => $offsetX];
        } else {
            $this->transformations['crop_by_objects'] = ['tag' => $tag, 'ratio' => $ratio, 'width' => $width, 'height' => $heigt, 'x' => $offsetX, 'y' => $offsetY];
        }

        return $this;
    }

    /**
     * Scales an image until it fully covers the specified dimensions; the rest gets cropped.
     *
     * @param integer $width in pixels.
     * @param integer $height in pixels.
     * @param integer $offsetX horizontal and vertical offsets in percents or shortcuts.
     * @param integer|null $offsetY horizontal and vertical offsets in percents.
     * @return self
     */
    public function scaleCrop(int $width, int $height, int $offsetX, int $offsetY = null): self
    {
        // Check if offsetX is a string and if it is a valid offset shortcut or percentage
        if (!in_array($offsetX, $this->offsetShortcuts) && isset($offsetX) && !$this->isValidPercentage($offsetX)) {
            throw new \InvalidArgumentException("Invalid offset shortcut or percentage.");
        }

        // Check if alignment is set by shortcut or percentages
        if (!$offsetY) {
            $this->transformations['scale_crop'] = ['width' => $width, 'height' => $height, 'align' => $offsetX];
        } else {
            $this->transformations['scale_crop'] = ['width' => $width, 'height' => $height, 'x' => $offsetX, 'y' => $offsetY];
        }

        return $this;
    }
}

