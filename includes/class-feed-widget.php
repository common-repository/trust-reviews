<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Core;

class Feed_Widget extends \WP_Widget {

    public static $static_feed_deserializer;

    public static $static_core;

    public static $static_view;

    public static $static_assets;

    public function __construct() {
        parent::__construct(
            'trp_widget',
            __('Trust Reviews', 'trust-reviews'),
            array(
                'classname'   => 'trp-feed-widget',
                'description' => __(
                    'Display Trust Business Reviews',
                    'trust-reviews'
                ),
            )
        );

        $this->feed_deserializer = self::$static_feed_deserializer;
        $this->core = self::$static_core;
        $this->view = self::$static_view;
        $this->assets = self::$static_assets;
    }

    public function widget($args, $instance) {
        if (get_option('trp_active') === '0') {
            return;
        }

        if (!isset($instance['feed_id']) || strlen($instance['feed_id']) < 1) {
            return null;
        }

        $trp_demand_assets = get_option('trp_demand_assets');
        if ($trp_demand_assets || $trp_demand_assets == 'true') {
            $this->assets->enqueue_public_styles();
            $this->assets->enqueue_public_scripts();
        }

        $feed = $this->feed_deserializer->get_feed($instance['feed_id']);

        if (!$feed) {
            return null;
        }

        $data = $this->core->get_reviews($feed);

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }

        $businesses = $data['businesses'];
        $reviews = $data['reviews'];
        $options = $data['options'];
        if (count($businesses) > 0 || count($reviews) > 0) {
            echo $this->view->render($feed->ID, $businesses, $reviews, $options);
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $wp_query = new \WP_Query();
        $wp_query->query(array(
            'post_type'      => 'trp_feed',
            'posts_per_page' => 100,
            'no_found_rows'  => true,
        ));
        $feeds = $wp_query->posts;

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'trust-reviews'); ?>
            </label>
            <input
                type="text"
                id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                class="widefat"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                value="<?php if (isset($instance['title'])) { echo esc_attr($instance['title']); } ?>"
            >
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('feed_id')); ?>">
                <?php esc_html_e('Feed:', 'trust-reviews'); ?>
            </label>

            <select
                id="<?php echo esc_attr($this->get_field_id('feed_id')); ?>"
                name="<?php echo esc_attr($this->get_field_name('feed_id')); ?>"
                style="display:block;width:100%"
            >
                <option value="">Select Feed</option>
                <?php foreach ($feeds as $feed) : ?>
                    <option
                        value="<?php echo esc_attr($feed->ID); ?>"
                        <?php if (isset($instance['feed_id'])) { selected($feed->ID, $instance['feed_id']); } ?>
                    >
                        <?php echo esc_html('ID ' . $feed->ID . ': ' . $feed->post_title); ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['feed_id'] = sanitize_text_field(
            $new_instance['feed_id']
        );
        return $instance;
    }
}
