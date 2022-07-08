<?php

namespace Vormkracht10\UploadcareTransformations\Traits;

trait Methods
{
    /**
     * Apply all (chained) transformations to the given URL.
     *
     * @param string $url
     * @return string
     */
    public function applyTransformations(string $url): string
    {
        if (isset($this->transformations['preview'])) {
            $transformation = $this->transformations['preview'];

            // -/preview/:dimensions/
            $url .= '/preview/' . $transformation['preview']['width'] . 'x' . $transformation['height'];
        }

        if (isset($this->transformations['resize'])) {
            $transformation = $this->transformations['resize'];

            // -/stretch/:mode/ (optional)
            $resizePrefix = $transformation['stretch'] ? '/stretch/' . $transformation['mode'] . '/-/resize/' : '/resize/';

            if ($transformation['height'] == null && $transformation['width'] !== null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['width'] . 'x';
            } elseif ($transformation['height'] !== null && $transformation['width'] == null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['height'] . 'x';
            } elseif ($transformation['height'] !== null && $transformation['width'] !== null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['width'] . 'x' . $transformation['height'];
            }
        }

        if (isset($this->transformations['smart_resize'])) {
            $transformation = $this->transformations['smart_resize'];

            // -/smart_resize/:dimensions/
            $url .= '/smart/' . $transformation['width'] . 'x' . $transformation['height'];
        }

        if (isset($this->transformations['crop'])) {
            $transformation = $this->transformations['crop'];

            if (isset($transformation['align'])) {
                // -/crop/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['align'];
            } elseif (isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            } else {
                // -/crop/:dimensions/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'];
            }
        }

        if (isset($this->transformations['crop_by_ratio'])) {
            $transformation = $this->transformations['crop_by_ratio'];

            if (isset($transformation['align'])) {
                // -/crop/:ratio/:alignment/
                $url .= '/crop/' . $transformation['ratio'] . '/' . $transformation['align'];
            } elseif (isset($transformation['align']) && isset($transformation['x'])) {
                // -/crop/:ratio/:alignment/
                $url .= '/crop/' . $transformation['ratio'] . '/' . $transformation['align'];
            } else {
                // -/crop/:ratio/
                $url .= '/crop/' . $transformation['ratio'];
            }
        }

        if (isset($this->transformations['crop_by_objects'])) {
            $transformation = $this->transformations['crop_by_objects'];

            if (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['align'])) {
                // -/crop/:tag/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['align'];
            } elseif (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:tag/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            } elseif (isset($transformation['ratio']) && isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:tag/:ratio/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            } elseif (isset($transformation['width']) && isset($transformation['height'])) {
                // -/crop/:tag/:dimensions/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'];
            } elseif (isset($transformation['ratio']) && isset($transformation['align'])) {
                // -/crop/:tag/:ratio/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'] . '/' . $transformation['align'];
            } elseif (isset($transformation['ratio'])) {
                // -/crop/:tag/:ratio/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'];
            } else {
                // -/crop/:tag/
                $url .= '/crop/' . $transformation['tag'];
            }
        }

        if (isset($this->transformations['scale_crop'])) {
            $transformation = $this->transformations['scale_crop'];

            if (! isset($transformation['x']) && ! isset($transformation['y']) && ! isset($transformation['align'])) {
                // -/scale_crop/:dimensions/
                $url .= '/scale_crop/' . $transformation['width'] . 'x' . $transformation['height'];
            } elseif (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['align'])) {
                // -/scale_crop/:dimensions/:alignment/
                $url .= '/scale_crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['align'];
            } elseif (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['x']) && isset($transformation['y'])) {
                // -/scale_crop/:dimensions/:alignment/
                $url .= '/scale_crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            }
        }

        if (isset($this->transformations['smart_crop'])) {
            $transformation = $this->transformations['smart_crop'];

            if (! isset($transformation['align']) && ! isset($transformation['x']) && ! isset($transformation['y'])) {
                // -/smart_crop/:dimensions/:type
                $url .= '/smart_crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['type'];
            } elseif (isset($transformation['align'])) {
                // -/smart_crop/:dimensions/:type/:alignment
                $url .= '/smart_crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['type'] . '/' . $transformation['align'];
            } elseif (isset($transformation['x']) && isset($transformation['y'])) {
                // -/smart_crop/:dimensions/:type/:alignment
                $url .= '/smart_crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['type'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            }
        }

        if (isset($this->transformations['set_fill'])) {
            $transformation = $this->transformations['set_fill'];

            // -/set_fill/:color
            $url .= '/set_fill/' . $transformation['color'];
        }

        if (isset($this->transformations['zoom_objects'])) {
            $transformation = $this->transformations['zoom_objects'];

            // -/zoom_objects/:zoom
            $url .= '/zoom_objects/' . $transformation['zoom'];
        }

        if (isset($this->transformations['format'])) {
            $transformation = $this->transformations['format'];

            // -/format/:format
            $url .= '/format/' . $transformation['format'];
        }

        if (isset($this->transformations['quality'])) {
            $transformation = $this->transformations['quality'];

            // -/quality/:quality
            $url .= '/quality/' . $transformation['quality'];
        }

        if (isset($this->transformations['progressive'])) {
            $transformation = $this->transformations['progressive'];
            $value = ($transformation['progressive']) ? 'yes' : 'no';

            // -/progressive/:value
            $url .= '/progressive/' . $value;
        }

        if (isset($this->transformations['basic_color_adjustments'])) {
            $transformation = $this->transformations['basic_color_adjustments'];

            // -/:value/:color
            $url .= '/basic_color_adjustments/' . $transformation['value'] . '/' . $transformation['color'];
        }

        if (isset($this->transformations['enhance'])) {
            $transformation = $this->transformations['enhance'];

            // -/enhance/:strength
            $url .= '/enhance/' . $transformation['strength'];
        }

        if (isset($this->transformations['grayscale'])) {
            $transformation = $this->transformations['grayscale'];

            // -/grayscale
            $url .= '/grayscale';
        }

        if (isset($this->transformations['inverting'])) {
            $transformation = $this->transformations['inverting'];

            // -/inverting
            $url .= '/inverting';
        }

        if (isset($this->transformations['convert_to_srgb'])) {
            $srgbTransformation = $this->transformations['convert_to_srgb'];

            if (isset($this->transformations['icc_profile_size_threshold'])) {
                $transformation = $this->transformations['icc_profile_size_threshold'];

                // -/max_icc_size/:number
                $url .= '/max_icc_size/' . $transformation['number'];
            }

            // -/srgb/:profile
            $url .= '/srgb/' . $srgbTransformation['profile'];
        }

        return $url;
    }

    /**
     * Check if value is a valid percentage format.
     *
     * @param string $value
     * @return bool
     */
    public static function isValidPercentage(string $value): bool
    {
        if (preg_match('/^[0-9]+p$/', $value)) {
            return true;
        }

        return false;
    }
}
