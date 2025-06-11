<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div class="uk-grid uk-child-width-1-<?php echo esc_attr($header_atts->columns); ?>@m <?php echo esc_attr(($header_atts->columns > 1) ? 'uk-grid-match ' : ''); ?> " data-uk-grid>