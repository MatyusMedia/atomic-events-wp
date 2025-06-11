<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div>
    <div class="eventcard eventcard--default max-w-md rounded overflow-hidden shadow-lg">

        <?php if (!empty($event->get_event_image_id())) : ?>
            <figure class="">
                <?php
                $image = new Atomic_Image_Utility($event->get_event_image_id());
                $image->render_img_tag('full', ['object-cover', 'aspect-video']);
                ?>
            </figure>
        <?php else : ?>
            <figure class="">
                <?php
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 16 9" preserveAspectRatio="xMidYMid meet">
                    <rect width="100%" height="100%" fill="#e0e0e0"/>
                    <text x="50%" y="50%" fill="#9e9e9e" font-size="16" text-anchor="middle" dominant-baseline="middle"></text>
                </svg>';
                ?>
            </figure>
        <?php endif; ?>

        <div class="px-6 py-6">
            <div class="eventcard__date">
                <?php AtomicEvents_DateUtils::atomic_formatted_date($event); ?>
            </div>
            <h3 class="card__title font-bold text-xl mb-2"><?php $event->title(); ?></h3>
            <div class="eventcard__place text-gray-700 text-base">
                <?php if (!empty($event->get_event_venue())) : ?>
                    <div>
                        <?php $event->event_venue(); ?>
                    </div>
                <?php endif; ?>
                <?php if ('US' === $event->get_event_country()) : ?>
                    <?php if (!empty($event->get_event_location_city()) || !empty($event->get_event_location_state())) : ?>
                        <div>
                            <div>Location:</div>
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
                    <div>
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
                <?php if ($event->get_event_outbound_link()) : ?>
                    <div class="eventcard__link mt-6">
                        <?php
                        AtomicEvents_Link::render(
                            $event->get_event_outbound_link(),
                            [
                                'text' => 'More',
                                'alt' => $event->get_title(),
                                'class' => 'inline-block bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow'
                            ]
                        );
                        ?>
                    </div>
                <?php else : ?>
                    <div class="eventcard__link mt-6">
                        <?php
                        AtomicEvents_Link::render(
                            $event->get_permalink(),
                            [
                                'text' => 'More',
                                'alt' => $event->get_title(),
                                'class' => 'inline-block bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow'
                            ]
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>