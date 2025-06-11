<?php
defined('WPINC') or die;
class AtomicEventTags_Taxonomy {
    public function __construct() {
        // add_action('init', array($this, 'register_taxonomy'));
    }

    public function register_taxonomy() {
        $labels = array(
            'name' => 'Event Tags',
            'singular_name' => 'Event Tag',
            'search_items' => 'Search Event Tags',
            'all_items' => 'All Event Tags',
            'parent_item' => 'Parent Event Tag',
            'parent_item_colon' => 'Parent Event Tag:',
            'edit_item' => 'Edit Event Tag',
            'update_item' => 'Update Event Tag',
            'add_new_item' => 'Add New Event Tag',
            'new_item_name' => 'New Event Tag Name',
            'menu_name' => 'Event Tags',
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
            'rewrite' => array('slug' => 'atomic-event-tags'),
        );

        register_taxonomy('atomic_event_tag', array('atomic-event'), $args);
    }
}
