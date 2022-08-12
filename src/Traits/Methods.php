<?php

namespace Vormkracht10\UploadcareTransformations\Traits;

use Vormkracht10\UploadcareTransformations\Transformations\TransformationsFinder;

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
        $transformations = TransformationsFinder::for($this->transformations);

        foreach ($transformations as $transformation) {
            $url = $transformation['class']::generateUrl($url, $transformation['values']);
        }

        dd($url);


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

        if (isset($this->transformations['filter'])) {
            $transformation = $this->transformations['filter'];

            // -/filter/:name/:amount/
            $url .= '/filter/' . $transformation['name'] . '/' . $transformation['amount'];
        }


        if (isset($this->transformations['blur'])) {
            $transformation = $this->transformations['blur'];

            // Strength and amount might be null
            // -/blur/:strength/:amount
            $url .= '/blur/' . $transformation['strength'] . '/' . $transformation['amount'];
        }

        if (isset($this->transformations['blur_region'])) {
            $transformation = $this->transformations['blur_region'];
            // -/blur_region/:two_dimensions/:two_coords/:strength/

            $url .= '/blur_region/' . $transformation['dimension_x'] . 'x' . $transformation['dimension_y'] . '/' . $transformation['coordinate_x'] . ',' . $transformation['coordinate_y'] . '/' . $transformation['strength'];
        }

        if (isset($this->transformations['blur_faces'])) {
            $transformation = $this->transformations['blur_faces'];
            // -/blur_region/faces/:strength/
            $url .= '/blur_region/faces/' . $transformation['strength'];
        }

        if (isset($this->transformations['sharpen'])) {
            $transformation = $this->transformations['sharpen'];

            // -/sharp/:strength/
            $url .= '/sharp/' . $transformation['strength'];
        }


        if (isset($this->transformations['auto_rotate'])) {
            $transformation = $this->transformations['auto_rotate'];

            $value = ($transformation['auto_rotate']) ? 'yes' : 'no';

            // -/autorotate/:no/
            $url .= '/autorotate/' . $value;
        }

        if (isset($this->transformations['rotate'])) {
            $transformation = $this->transformations['rotate'];

            // -/rotate/:angle/
            $url .= '/rotate/' . $transformation['angle'];
        }

        if (isset($this->transformations['flip'])) {

            // /flip/
            $url .= '/flip/' . $value;
        }


        if (isset($this->transformations['mirror'])) {

            // /flip/
            $url .= '/mirror/';
        }

        if (isset($this->transformations['overlay'])) {
            $transformation = $this->transformations['overlay'];

            // -/overlay/:uuid/:relative_dimensions/:relative_coordinates/:opacity/
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
