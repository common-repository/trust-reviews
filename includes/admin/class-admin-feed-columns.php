<?php

namespace WP_Trust_Reviews_Plugin\Includes\Admin;

class Admin_Feed_Columns {

    private static $plugin_themes = array(
        'list' => 'List',
    );

    public function __construct($feed_deserializer) {
        $this->feed_deserializer = $feed_deserializer;
    }

    public function register() {
        add_filter('get_edit_post_link', array($this, 'modify_edit_post_link'), 10, 3);
        add_filter('manage_edit-trp_feed_columns', array($this, 'get_columns'));
        add_action('manage_trp_feed_posts_custom_column', array($this, 'render'), 10, 2);
        add_filter('post_row_actions', array($this, 'modify_post_row_actions'), 10, 2);
    }

    public function modify_edit_post_link($link, $id, $context) {
        if (function_exists('get_current_screen')) {
            $screen = get_current_screen();
            if (empty($screen) || $screen->post_type !== 'trp_feed') {
                return $link;
            }
            return admin_url('admin.php?page=trp-builder&trp_feed_id=' . $id);
        } else {
            return;
        }
    }

    public function get_columns($columns) {
        $columns = $columns;
        $columns = array(
            'cb'        => '<input type="checkbox">',
            'title'     => __('Title', 'trust-reviews'),
            'ID'        => __('ID',    'trust-reviews'),
            'trp_theme' => __('Theme', 'trust-reviews'),
            'date'      => __('Date',  'trust-reviews'),
        );
        return $columns;
    }

    public function render($column_name, $post_id) {
        $args = array();

        if (isset($_GET['post_status'])) {
            $post_status = sanitize_text_field(wp_unslash($_GET['post_status']));

            if ($post_status === 'trash') {
                $args['post_status'] = array('trash');
            }
        }

        $feed = $this->feed_deserializer->get_feed($post_id, $args);
        if (!$feed) {
            return null;
        }

        $connection = json_decode($feed->post_content);

        switch ($column_name) {
            case 'ID':
                echo $feed->ID;
                break;
            case 'trp_theme':
                echo isset($connection->options->view_mode) ? self::$plugin_themes[$connection->options->view_mode] : 'List';
                break;
        }
    }

    public function modify_post_row_actions($actions, $post) {
        if (isset($actions) && $post->post_type === "trp_feed") {
            $modified_actions = array(
                'post-id' => '<span class="trp-admin-column-action">ID: ' . $post->ID . '</span>',
            );
            $actions = $modified_actions + $actions;
        }
        return $actions;
    }

}
