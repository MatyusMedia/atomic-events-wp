<?php

defined('WPINC') or die;

class AtomicEvents_MemberUtils {

    public static function should_show_in_list(AtomicEventModel $event) {

        $should_show = true;

        // Determine whether to show the event
        if ($event->is_member_only()) {
            // Check if the user is logged in
            $user_logged_in = is_user_logged_in();
            $should_show = $user_logged_in ? true : false;
        }

        // Override whether to show the event
        $should_show = apply_filters('atomic_events_should_show_in_list', $should_show, $event);

        return $should_show;
    }
}




// // Define a function to override the should_show method
// function override_should_show($should_show, $event) {
//     // Your custom logic to override the value if needed
//     return false; // For example, always return false to hide the event
// }

// // Add a filter to override the should_show method
// add_filter('atomic_events_should_show', 'override_should_show', 10, 2);
