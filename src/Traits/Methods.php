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
            $resizePrefix = $transformation['resize']['stretch'] ? '/stretch/' . $transformation['mode'] . '/-/resize/' : '/resize/';

            if ($transformation['height'] == null && $transformation['width'] !== null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['width'] . 'x';
            }

            elseif ($transformation['height'] !== null && $transformation['width'] == null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['height'] . 'x';
            }

            elseif ($transformation['height'] !== null && $transformation['width'] !== null) {
                // -/resize/:one_or_two_dimensions/
                $url .= $resizePrefix . $transformation['width'] . 'x' . $transformation['height'];
            }
        }

        if (isset($this->transformations['smart_resize'])) {
            $transformation = $this->transformations['smart_resize'];

            // -/smart_resize/:dimensions/
            $url .= '/smart/' . $transformation['smart_resize']['width'] . 'x' . $transformation['smart_resize']['height'];
        }

        if (isset($this->transformations['crop'])) {
            $transformation = $this->transformations['crop'];

            if (isset($transformation['align'])) {
                // -/crop/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['align'];
            } 
            
            elseif (isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            }
            
            else {
                // -/crop/:dimensions/
                $url .= '/crop/' . $transformation['width'] . 'x' . $transformation['height'];
            }
        }

        if (isset($this->transformations['crop_by_ratio'])) {

            $transformation = $this->transformations['crop_by_ratio'];

            if (isset($transformation['align'])) {
                // -/crop/:ratio/:alignment/
                $url .= '/crop/' . $transformation['ratio'] . '/' . $transformation['align'];
            }

            elseif (isset($transformation['align']) && isset($transformation['x'])) {
                // -/crop/:ratio/:alignment/
                $url .= '/crop/' . $transformation['ratio'] . '/' . $transformation['align'];
            }
            
            else {
                // -/crop/:ratio/
                $url .= '/crop/' . $transformation['ratio'] . 'x' . $transformation['height'];
            }
        }

        if (isset($this->transformations['crop_by_objects'])) {

            $transformation = $this->transformations['crop_by_objects'];

            if (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['align'])) {
                // -/crop/:tag/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['align'];
            } 

            elseif (isset($transformation['width']) && isset($transformation['height']) && isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:tag/:dimensions/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            }

            elseif (isset($transformation['ratio']) && isset($transformation['x']) && isset($transformation['y'])) {
                // -/crop/:tag/:ratio/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'] . '/' . $transformation['x'] . ',' . $transformation['y'];
            }

            elseif (isset($transformation['width']) && isset($transformation['height'])) {
                // -/crop/:tag/:dimensions/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['width'] . 'x' . $transformation['height'];
            }

            elseif (isset($transformation['ratio']) && isset($transformation['align'])) {
                // -/crop/:tag/:ratio/:alignment/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'] . '/' . $transformation['align'];
            }

            elseif (isset($transformation['ratio'])) {
                // -/crop/:tag/:ratio/
                $url .= '/crop/' . $transformation['tag'] . '/' . $transformation['ratio'];
            }

            else {
                // -/crop/:tag/
                $url .= '/crop/' . $transformation['tag'];
            }
        }

        return $url;
    }

    /**
     * Check if value is a valid percentage format.
     *
     * @param string $value
     * @return boolean
     */
    public function isValidPercentage(string $value): bool
    {
        if (preg_match('/^[0-9]+p$/', $value)) {
            return true;
        }

        return false;
    }
}
