<?php
defined('WPINC') or die;

class Atomic_Image_Utility {

    private $img_obj_id;

    /**
     * Constructor for Urbi_Image class.
     *
     * @param string $img_obj_id The image object ID.
     */
    public function __construct($img_obj_id) {
        $this->img_obj_id = empty($img_obj_id) ? '' : $img_obj_id;
    }

    /**
     * Output a simple image tag using wp_get_attachment_image.
     *
     * @param string $size The image size.
     */
    public function img_tag_simple($size = 'full') {
        if (!$this->__check_id()) return;
        echo wp_kses(
            wp_get_attachment_image($this->img_obj_id, $size),
            [
                'img' => [
                    'src' => true,
                    'srcset' => true,
                    'sizes' => true,
                    'loading' => true,
                    'decoding' => true,
                    'style' => true,
                    'title' => true,
                    'class' => true,
                    'alt' => true,
                    'width' => true,
                    'height' => true,
                ],
            ]
        );
    }

    /**
     * Render an image tag with additional attributes.
     *
     * @param string $size                  The image size.
     * @param array  $additional_classes    Additional classes for the image tag.
     * @param array  $additional_attributes Additional attributes for the image tag.
     * @param string $alt                   Alt text for the image.
     * @param int    $width                 Width of the image.
     * @param int    $height                Height of the image.
     */
    public function render_img_tag($size = 'full', $additional_classes = [], $additional_attributes = [], $alt = '', $width = null, $height = null) {
        if (!$this->__check_id()) return;

        $default_class = 'urbi-img';
        $classes = implode(' ', array_merge([$default_class], $additional_classes));

        $attributes = [
            'class' => esc_attr($classes),
        ];

        if ($alt !== '') {
            $attributes['alt'] = esc_attr($alt);
        }

        if ($width !== null) {
            $attributes['width'] = $width;
        }

        if ($height !== null) {
            $attributes['height'] = $height;
        }

        // Merge additional attributes
        $attributes = array_merge($attributes, $additional_attributes);

        echo wp_get_attachment_image($this->img_obj_id, $size, false, $attributes);
    }

    /**
     * Output the URL of the image.
     *
     * @param string $size The image size.
     */
    public function url($size = 'full') {
        if (!$this->__check_id()) return;
        echo esc_url(wp_get_attachment_image_url($this->img_obj_id, $size));
    }

    /**
     * Output the image source URL.
     *
     * @param string $size The image size.
     */
    public function src($size = 'full') {
        if (!$this->__check_id()) return;
        $image_data = wp_get_attachment_image_src($this->img_obj_id, $size);
        if ($image_data) {
            echo esc_url($image_data[0]); // Output the URL
        }
    }

    /**
     * Output the image source set.
     *
     * @param string $size The image size.
     */
    public function srcset($size = 'full') {
        if (!$this->__check_id()) return;

        $image_data = wp_get_attachment_image_srcset($this->img_obj_id, $size);
        if ($image_data) {
            echo wp_kses(
                $image_data,
                [
                    'img' => [
                        'srcset' => true,
                    ],
                ]
            ); // Output the srcset
        }
    }

    public function returnImageTagSimple($size = 'full') {
        if (!$this->__check_id()) return;
        return wp_get_attachment_image($this->img_obj_id, $size);
    }

    /**
     * Check if the image object ID is valid.
     *
     * @return bool Returns true if the ID is valid, false otherwise.
     */
    private function __check_id() {
        if (empty($this->img_obj_id)) {
            echo esc_html("invalid \$img_obj_id");
            return false;
        }
        return true;
    }
}


/**
 * Example usage
 */
// $img = new Atomic_Image_Utility(123);
// $img->img_tag_simple('full');
// $img->render_img_tag('full', ['img-class'], ['data-attr' => 'value'], 'Alt text', 100, 100);
// $img->url('full');
// $img->src('full');
// $img->srcset('full');
