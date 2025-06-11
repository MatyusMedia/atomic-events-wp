<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div class="atomic-event-single-content">
    <h1 class="card__title font-bold text-2xl sm:text-3xl mb-6"><?php $event->title(); ?></h1>

    <?php if (!empty($event->get_event_image_id())) : ?>
        <figure class="mt-6 mb-6">
            <?php
            $image = new Atomic_Image_Utility($event->get_event_image_id());
            $image->render_img_tag('full', ['rounded-xl']);
            ?>
            <?php if ($event->has_event_image_caption()) : ?>
                <figcaption class="mt-4 flex gap-x-2 text-sm leading-6 text-gray-900">
                    <svg class="mt-0.5 h-5 w-5 flex-none text-gray-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                    <?php $event->event_image_caption(); ?>
                </figcaption>
            <?php endif; ?>
        </figure>
    <?php endif; ?>

    <div class="overflow-hidden rounded-lg bg-white shadow ">
        <div class="px-4 py-5 ">
            <dl class="mt-10 mb-0 grid grid-cols-1 gap-8 border-t border-gray-900/10 pt-10">
                <div>
                    <dt class="text-md font-semibold leading-6 text-gray-700">Date:</dt>
                    <dd class="mt-2 mb-4 text-2xl font-bold leading-10 tracking-tight text-gray-900">
                        <?php AtomicEvents_DateUtils::atomic_formatted_date($event); ?>
                    </dd>
                    <dt class="text-md font-semibold leading-6 text-gray-700">Venue:</dt>
                    <dd class="mt-2 mb-0 text-2xl font-bold leading-10 tracking-tight text-gray-900">
                        <?php if (!empty($event->get_event_venue())) : ?>
                            <div class="">
                                <?php $event->event_venue(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ('US' === $event->get_event_country()) : ?>
                            <?php if (!empty($event->get_event_location_city()) || !empty($event->get_event_location_state())) : ?>
                                <div class="">
                                    <div class="">Location:</div>
                                    <?php
                                    $city_state = [];
                                    if (!empty($event->get_event_location_city())) {
                                        $city_state[] = $event->get_event_location_city();
                                    };
                                    if (!empty($event->get_event_location_state())) {
                                        $city_state[] = $event->get_event_location_state();
                                    };
                                    ?>
                                    <?php
                                    echo esc_html(sanitize_text_field(implode(', ', $city_state)));
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="">
                                <?php
                                $city_state = [];
                                if (!empty($event->get_event_location_city())) {
                                    $city_state[] = $event->get_event_location_city();
                                };
                                if (!empty($event->get_event_location_region())) {
                                    $city_state[] = $event->get_event_location_region();
                                };
                                ?>
                                <?php
                                echo esc_html(sanitize_text_field(implode(', ', $city_state)));
                                ?>
                            </div>
                        <?php endif; ?>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <div class="">
        <?php if (false) : ?>
            <?php if (!empty($event->get_event_start_date())) : ?>
                <div class="">
                    <span class="font-bold">Start Date: </span>
                    <?php $event->event_start_date(); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($event->get_event_end_date())) : ?>
                <div class="">
                    <span class="font-bold">End Date: </span>
                    <?php $event->event_end_date(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="mt-6 py-6 text-lg text-slate-700 dark:text-slate-400">
        <?php $event->content(); ?>
    </div>
    <div class="mb-6">
        <?php if (!empty($event->get_event_tags())) : ?>
            <div class="font-bold mb-2 text-gray-700">Tags:</div>
            <div>
                <?php
                foreach ($event->get_event_tags() as $tag) {
                    echo '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">' .
                        esc_html($tag->name) .
                        '</span>';
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>