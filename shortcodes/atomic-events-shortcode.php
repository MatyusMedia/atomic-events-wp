<?php
defined('WPINC') or die;
class AtomicEvents_Shortcode {

    private $debug = false;

    public function __construct() {
    }

    public function register_shortcodes() {
        add_shortcode('atomic-events', array($this, 'render_atomic_events_shortcode'));
    }

    public function render_atomic_events_shortcode($atts) {
        // Shortcode attributes
        $atts = shortcode_atts(array(
            'filter' => 'future', // Default filter
            'max' => 20, // Default maximum number of posts
            'columns' => 3, // Default number of columns
            'featured' => null, // Default to show all events
            'skip_first_x' => 0, // Default to not skip any events
            'skip_first_x_featured' => 0, // Default to not skip any featured events
            'order' => 'ASC' // Default order
        ), $atts);

        $transient_key = 'atomic_events_shortcode_' . md5(serialize($atts));
        $output = get_transient($transient_key);

        // Validate and sanitize the order attribute
        $order = strtoupper($atts['order']);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'ASC'; // Default to 'ASC' if the value is not 'ASC' or 'DESC'
        }

        $columns = intval($atts['columns']);
        if ($columns <= 0) {
            $columns = 1; // Set default value if validation fails
        }
        if ($columns > 6) {
            $columns = 6; // Set default value if validation fails
        }

        // Query arguments based on shortcode attributes
        $args = array(
            'post_type' => 'atomic-event',
            'post_status' => 'publish',
            'posts_per_page' => $atts['max'],
            'meta_query' => array(
                array(
                    'key' => 'event_start_date',
                    'value' => gmdate('Y-m-d'), // Current date
                    'compare' => ($atts['filter'] === 'future') ? '>=' : '<', // Future or past events
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'meta_key' => 'event_start_date',
            'order' => $order // Set the order
        );
        /**
         * OPTION - featured: bool
         * If 'featured' attribute is provided
         * Add additional meta queries if 'featured' attribute is provided
         */
        if ($atts['featured'] !== null) {
            $featured_value = filter_var($atts['featured'], FILTER_VALIDATE_BOOLEAN);
            $args['meta_query'][] = array(
                'key' => 'event_featured',
                'value' => $featured_value ? '1' : '0',
                'compare' => '=',
            );
        }

        /**
         * OPTION - skip_first_x: int
         * Skip the first x events
         */
        $skip_first_x = intval($atts['skip_first_x']);
        if ($skip_first_x > 0) {
            $args['offset'] = $skip_first_x;
        }

        /**
         * OPTION - skip_first_x_featured: int
         * Skip the first x featured events
         */
        $skip_first_x_featured = intval($atts['skip_first_x_featured']);

        // Querying posts
        $events_query = new WP_Query($args);

        // Output buffer to capture template
        ob_start();

        // Loop through the posts
        if ($events_query->have_posts()) {

            $template_loader = new Atomic_Template_Loader;

            /**
             * Load List Header
             */
            if (!empty($featured_value)) {
                $template_loader
                    ->set_template_data(['columns' => $columns], 'header_atts')
                    ->get_template_part('cards/card-list-header', 'featured');
            } else {
                $template_loader
                    ->set_template_data(['columns' => $columns], 'header_atts')
                    ->get_template_part('cards/card-list-header', 'default');
            }

            /**
             * Load List content
             */
            $counter = 0;
            $featured_counter = 0;
            while ($events_query->have_posts()) {

                $events_query->the_post();
                $event_model = new AtomicEventModel(get_the_ID());

                if ($this->debug) error_log('event: ' . $event_model->get_title());

                $counter++;
                if ($event_model->is_featured()) {
                    $featured_counter++;
                }

                /**
                 * Skip first X featured
                 * if this is featured and not yet count larger than first x
                 */
                if (!empty($skip_first_x_featured) && $event_model->is_featured()) {
                    if ($featured_counter <= $skip_first_x_featured) {
                        //skip
                        continue;
                    }
                }
                /**
                 * Skip if this is members only and members only condition is not met
                 */

                if (empty(AtomicEvents_MemberUtils::should_show_in_list($event_model))) {
                    if ($this->debug) error_log('skipping event: ' . $event_model->get_title());
                    //skip
                    continue;
                }

                // Load template part
                $tpl_suffix = 'default';
                if (!empty($featured_value)) {
                    $tpl_suffix = 'featured';
                }

                $template_loader
                    ->set_template_data($event_model, 'event')
                    ->set_template_data(['item_nr' => $counter], 'counter')
                    ->get_template_part('cards/card-item', $tpl_suffix);
            }

            /**
             * Load List Footer
             */
            if (!empty($featured_value)) {
                $template_loader->get_template_part('cards/card-list-footer', 'featured');
            } else {
                $template_loader->get_template_part('cards/card-list-footer', 'default');
            }

            wp_reset_postdata();
        } else {
            echo 'No events found.';
        }

        // Return output
        return ob_get_clean();
    }
}
