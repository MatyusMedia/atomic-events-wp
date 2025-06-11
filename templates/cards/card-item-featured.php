<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div>
    <div class="uk-card uk-card-small uk-card-default uk-card-hover uk-border-rounded-large uk-overflow-hidden">
        <div class="uk-card-media-top uk-inline uk-light">
            <?php
            $event->render_img_tag();
            ?>
            <div class="uk-position-cover uk-overlay-xlight"></div>
            <div class="uk-position-small uk-position-top-left">
                <span class="uk-label uk-text-bold uk-text-price">FEATURED</span>
            </div>
            <div class="uk-position-small uk-position-top-right">
                <a href="#" class="uk-icon-button uk-like uk-position-z-index uk-position-relative" data-uk-icon="heart"></a>
            </div>
        </div>
        <div class="uk-card-body">
            <h3 class="uk-card-title uk-margin-small-bottom"><?php $event->title(); ?></h3>
            <div class="uk-text-muted uk-text-small"><?php AtomicEvents_DateUtils::atomic_formatted_date($event); ?></div>
            <div class="uk-text-muted uk-text-small uk-rating uk-margin-small-top">
                hello
            </div>
        </div>
        <a href="course.html" class="uk-position-cover"></a>
    </div>
</div>