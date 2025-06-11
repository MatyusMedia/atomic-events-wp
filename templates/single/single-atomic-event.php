<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
?>

<?php

/**
 * The template for displaying all single posts
 *
 * @package Atomic-Events
 */

get_header();
?>

<main id="primary" class="site-main max-w-3xl mx-auto">

    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="">
            <?php
            while (have_posts()) :
                the_post();
                $event_model = new AtomicEventModel(get_the_ID());
                $template_loader = new Atomic_Template_Loader;
                $template_loader
                    ->set_template_data($event_model, 'event')
                    ->get_template_part('content/single', 'event');

            ?>
        </div>
    </div>
</main>

<?php endwhile; // End of the loop. 
?>

</main><!-- #main -->

<?php
get_footer();
