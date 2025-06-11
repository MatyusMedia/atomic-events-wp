<?php
defined('WPINC') or die;
class AtomicEventModel {
    public $post_id;
    public $title;
    public $event_featured;
    public $event_member_only;
    public $event_start_date;
    public $event_start_time;
    public $event_end_date;
    public $event_end_time;
    public $event_venue;
    public $event_location_city;
    public $event_country;
    public $event_location_state;
    public $event_location_region;
    public $event_outbound_link;
    public $event_tag;
    public $event_all_day;
    public $event_image_id;
    public $event_start_timestamp;
    public $event_end_timestamp;
    public $event_permalink;

    const DBDATEFORMAT = 'M d, Y';
    const DBTIMEFORMAT = 'H:i:s';
    const HOURFORMAT = 'H';
    const MINUTEFORMAT = 'i';
    const MERIDIANFORMAT = 'a';

    public function __construct($post_id) {
        $this->post_id = $post_id;
        $this->title = get_the_title($post_id);

        $this->event_featured = get_post_meta($post_id, 'event_featured', true);
        $this->event_member_only = get_post_meta($post_id, 'event_member_only', true);

        $this->event_all_day = get_post_meta($post_id, 'event_all_day', true);
        $this->event_start_date = get_post_meta($post_id, 'event_start_date', true);
        $this->event_start_time = get_post_meta($post_id, 'event_start_time', true);

        $this->event_end_date = get_post_meta($post_id, 'event_end_date', true);
        $this->event_end_time = get_post_meta($post_id, 'event_end_time', true);

        $this->event_venue = get_post_meta($post_id, 'event_venue', true);
        $this->event_location_city = get_post_meta($post_id, 'event_location_city', true);
        $this->event_country = get_post_meta($post_id, 'event_country', true);
        $this->event_location_state = get_post_meta($post_id, 'event_location_state', true);
        $this->event_location_region = get_post_meta($post_id, 'event_location_region', true);

        $this->event_outbound_link = get_post_meta($post_id, 'event_outbound_link', true);

        $this->event_tag = get_post_meta($post_id, 'event_tag', true);
        $this->event_image_id = get_post_thumbnail_id($post_id); // Retrieve attachment image ID

        $this->event_start_timestamp = get_post_meta($post_id, 'event_start_timestamp', true);
        $this->event_end_timestamp = get_post_meta($post_id, 'event_end_timestamp', true);

        $this->event_permalink = get_permalink($post_id);
    }

    public function get_post_id() {
        return intval($this->post_id);
    }

    public function get_title() {
        return sanitize_text_field($this->title);
    }

    public function get_permalink() {
        return esc_url($this->event_permalink);
    }



    public function get_event_featured() {
        return sanitize_text_field($this->event_featured);
    }

    public function get_event_member_only() {
        return sanitize_text_field($this->event_member_only);
    }

    public function is_featured() {
        return !empty($this->event_featured);
    }

    public function is_member_only() {
        return !empty($this->event_member_only);
    }

    public function get_event_start_date() {
        return sanitize_text_field($this->event_start_date);
    }

    public function get_event_start_time() {
        return sanitize_text_field($this->event_start_time);
    }

    public function get_event_end_date() {
        return sanitize_text_field($this->event_end_date);
    }

    public function get_event_end_time() {
        return sanitize_text_field($this->event_end_time);
    }

    public function get_event_venue() {
        return sanitize_text_field($this->event_venue);
    }

    public function get_event_location_city() {
        return sanitize_text_field($this->event_location_city);
    }

    public function get_event_country() {
        return sanitize_text_field($this->event_country);
    }

    public function get_event_location_state() {
        return sanitize_text_field($this->event_location_state);
    }

    public function get_event_location_region() {
        return sanitize_text_field($this->event_location_region);
    }

    public function get_event_outbound_link() {
        return esc_url($this->event_outbound_link);
    }

    public function get_event_tag() {
        return sanitize_text_field($this->event_tag);
    }

    public function get_event_all_day() {
        return sanitize_text_field($this->event_all_day);
    }

    public function get_event_image_id() {
        return $this->event_image_id;
    }
    public function image_id() {
        return $this->event_image_id;
    }

    public function get_event_tags() {

        $tags = wp_get_post_terms($this->post_id, 'atomic_event_tag');
        return $tags;
    }

    /**
     * Echo Values
     */

    public function title() {
        echo esc_html(sanitize_text_field($this->title));
    }

    public function content() {
        echo wp_kses_post(apply_filters('the_content', get_post_field('post_content', $this->post_id)));
    }

    public function event_start_date() {
        echo esc_html(sanitize_text_field($this->event_start_date));
    }

    public function event_start_time() {
        echo esc_html(sanitize_text_field($this->event_start_time));
    }

    public function event_end_date() {
        echo esc_html(sanitize_text_field($this->event_end_date));
    }

    public function event_end_time() {
        echo esc_html(sanitize_text_field($this->event_end_time));
    }

    public function event_venue() {
        echo esc_html(sanitize_text_field($this->event_venue));
    }

    public function event_location_city() {
        echo esc_html(sanitize_text_field($this->event_location_city));
    }

    public function event_country() {
        echo esc_html(sanitize_text_field($this->event_country));
    }

    public function event_location_state() {
        echo esc_html(sanitize_text_field($this->event_location_state));
    }

    public function event_location_region() {
        echo esc_html(sanitize_text_field($this->event_location_region));
    }

    public function event_outbound_link() {
        echo esc_url($this->event_outbound_link);
    }

    public function event_tag() {
        echo esc_html(sanitize_text_field($this->event_tag));
    }

    public function event_all_day() {
        echo esc_html(sanitize_text_field($this->event_all_day));
    }
    public function has_event_image_caption() {
        return !empty(get_post_field('post_excerpt', $this->event_image_id));
    }
    public function event_image_caption() {
        echo esc_html(sanitize_text_field(get_post_field('post_excerpt', $this->event_image_id)));
    }


    /**
     * Extracts the date part from a given datetime string.
     * @param string $date The datetime string.
     * @param string|null $format The format to use for the date. Defaults to 'Y-m-d'.
     * @return string The formatted date.
     */
    public function date_only($date, $format = null) {
        if (!$format) {
            $format = self::DBDATEFORMAT;
        }
        return gmdate($format, strtotime($date));
    }

    /**
     * Extracts the time part from a given datetime string.
     * @param string $date The datetime string.
     * @param string|null $format The format to use for the time. Defaults to 'H:i:s'.
     * @return string The formatted time.
     */
    public function time_only($date, $format = null) {
        if (!$format) {
            $format = self::DBTIMEFORMAT;
        }
        return gmdate($format, strtotime($date));
    }

    /**
     * Get the formatted start date of the event.
     * @param string|null $date_format The format of the date. Default is Y-m-d.
     * @return string The formatted start date.
     */
    public function get_start_date($date_format = self::DBDATEFORMAT) {
        return $this->date_only($this->event_start_date, $date_format);
    }
    public function start_date($date_format = self::DBDATEFORMAT) {
        echo esc_url(sanitize_text_field($this->get_start_date($date_format)));
    }


    /**
     * Get the formatted end date of the event.
     * @param string|null $date_format The format of the date. Default is Y-m-d.
     * @return string The formatted end date.
     */
    public function get_end_date($date_format = self::DBDATEFORMAT) {
        return $this->date_only($this->event_end_date, $date_format);
    }

    /**
     * Get the formatted start time of the event.
     * @param string|null $time_format The format of the time. Default is H:i:s.
     * @return string The formatted start time.
     */
    public function get_start_time($time_format = self::DBTIMEFORMAT) {
        return $this->time_only($this->event_start_date, $time_format);
    }

    /**
     * Get the formatted end time of the event.
     * @param string|null $time_format The format of the time. Default is H:i:s.
     * @return string The formatted end time.
     */
    public function get_end_time($time_format = self::DBTIMEFORMAT) {
        return $this->time_only($this->event_end_date, $time_format);
    }

    /**
     * Get the formatted start date and time of the event.
     * @param string|null $date_format The format of the date. Default is Y-m-d.
     * @param string|null $time_format The format of the time. Default is H:i:s.
     * @return string The formatted start date and time.
     */
    public function get_start_date_and_time($date_format = self::DBDATEFORMAT, $time_format = self::DBTIMEFORMAT) {
        return $this->date_only($this->event_start_date, $date_format) . ' ' . $this->time_only($this->event_start_date, $time_format);
    }

    /**
     * Get the formatted end date and time of the event.
     * @param string|null $date_format The format of the date. Default is Y-m-d.
     * @param string|null $time_format The format of the time. Default is H:i:s.
     * @return string The formatted end date and time.
     */
    public function get_end_date_and_time($date_format = self::DBDATEFORMAT, $time_format = self::DBTIMEFORMAT) {
        return $this->date_only($this->event_end_date, $date_format) . ' ' . $this->time_only($this->event_end_date, $time_format);
    }

    /**
     * Render Methods
     */

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
    public function render_img_tag(
        $size = 'full',
        $additional_classes = [],
        $additional_attributes = [],
        $alt = '',
        $width = null,
        $height = null
    ) {
        $eventimage = new AtomicEvents_Image($this->image_id());
        $eventimage->render_img_tag(
            $size,
            $additional_classes,
            $additional_attributes,
            $alt,
            $width,
            $height
        );
    }
}
