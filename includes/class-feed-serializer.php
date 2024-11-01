<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Feed_Serializer {

    protected $post_type = 'trp_feed';

    public function __construct() {
        add_action('admin_post_trp_feed_save', array($this, 'feed_save'), 30);
    }

    public function feed_save() {

        $raw_data_array = wp_unslash($_POST[$this->post_type]);

        $post_id = wp_insert_post(array(
            'ID'           => $raw_data_array['post_id'],
            'post_title'   => $raw_data_array['title'],
            'post_content' => $raw_data_array['content'],
            'post_type'    => $this->post_type,
            'post_status'  => 'publish',
        ));

        // NOT: $referer = empty(wp_get_referer()) ? $raw_data_array['current_url'] : wp_get_referer();
        // COZ: Fatal error: Can't use function return value in write context in .../includes/class-feed-serializer.php on line ...
        $referer = wp_get_referer();
        $referer = empty($referer) ? $raw_data_array['current_url'] : wp_get_referer();

        wp_safe_redirect(
            add_query_arg(array(
                'trp_feed_id' => $post_id,
            ), $referer)
        );
        exit;
    }

}
