<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Database;

class Activator {

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function options() {
        return array(
            'trp_latest_version',
            'trp_version',
            'trp_previous_version',
            'trp_active',
            'trp_demand_assets',
            'trp_minified_assets',
            'trp_google_api_key',
            'trp_google_places_api',
            'trp_yelp_api_key',
            'trp_auth_code',
        );
    }

    public function register() {
        add_action('init', array($this, 'check_version'));
    }

    public function check_version() {
        if (version_compare(get_option('trp_version'), TRP_VERSION, '<')) {
            $this->activate();
        }
    }

    public function activate() {
        $network_wide = get_option('trp_is_multisite');
        if ($network_wide) {
            $this->activate_multisite();
        } else {
            $this->activate_single_site();
        }
    }

    public function create_db() {
        $network_wide = get_option('trp_is_multisite');
        if ($network_wide) {
            $this->create_db_multisite();
        } else {
            $this->create_db_single_site();
        }
    }

    public function drop_db($multisite = false) {
        $network_wide = get_option('trp_is_multisite');
        if ($multisite && $network_wide) {
            $this->drop_db_multisite();
        } else {
            $this->drop_db_single_site();
        }
    }

    public function delete_all_options($multisite = false) {
        $network_wide = get_option('trp_is_multisite');
        if ($multisite && $network_wide) {
            $this->delete_all_options_multisite();
        } else {
            $this->delete_all_options_single_site();
        }
    }

    public function delete_all_feeds($multisite = false) {
        $network_wide = get_option('trp_is_multisite');
        if ($multisite && $network_wide) {
            $this->delete_all_feeds_multisite();
        } else {
            $this->delete_all_feeds_single_site();
        }
    }

    private function activate_multisite() {
        global $wpdb;

        $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach($site_ids as $site_id) {
            switch_to_blog($site_id);
            $this->activate_single_site();
            restore_current_blog();
        }
    }

    private function activate_single_site() {
        $current_version     = TRP_VERSION;
        $last_active_version = get_option('trp_version');

        if (empty($last_active_version)) {
            $this->first_install();
            update_option('trp_version', $current_version);
            update_option('trp_auth_code', $this->random_str(127));
        } elseif ($last_active_version !== $current_version) {
            $this->exist_install($current_version, $last_active_version);
            update_option('trp_version', $current_version);
            update_option('trp_previous_version', $last_active_version);
        }
    }

    private function first_install() {
        $this->database->create();
        add_option('trp_active', '1');
    }

    private function exist_install($current_version, $last_active_version) {
        global $wpdb;
        switch($last_active_version) {
            case version_compare($last_active_version, '1.0', '<'):
                // Specific version updates
            break;
        }
    }

    private function create_db_multisite() {
        global $wpdb;

        $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach($site_ids as $site_id) {
            switch_to_blog($site_id);
            $this->create_db_single_site();
            restore_current_blog();
        }
    }

    private function create_db_single_site() {
        $this->database->create();
    }

    private function drop_db_multisite() {
        global $wpdb;

        $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach($site_ids as $site_id) {
            switch_to_blog($site_id);
            $this->drop_db_single_site();
            restore_current_blog();
        }
    }

    private function drop_db_single_site() {
        $this->database->drop();
    }

    private function delete_all_options_multisite() {
        global $wpdb;

        $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach($site_ids as $site_id) {
            switch_to_blog($site_id);
            $this->delete_all_options_single_site();
            restore_current_blog();
        }
    }

    private function delete_all_options_single_site() {
        foreach ($this->options() as $opt) {
            delete_option($opt);
        }
    }

    private function delete_all_feeds_multisite() {
        global $wpdb;

        $site_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach($site_ids as $site_id) {
            switch_to_blog($site_id);
            $this->delete_all_feeds_single_site();
            restore_current_blog();
        }
    }

    private function delete_all_feeds_single_site() {
        $args = array(
            'post_type'      => 'trp_feed',
            'post_status'    => array('any', 'trash'),
            'posts_per_page' => -1,
            'fields'         => 'ids',
        );

        $query = new \WP_Query($args);
        $trp_posts = $query->posts;

        if (!empty($trp_posts)) {
            foreach ($trp_posts as $trp_post) {
                wp_delete_post($trp_post, true);
            }
        }
    }

    private function random_str($len) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charlen = strlen($chars);
        $randstr = '';
        for ($i = 0; $i < $len; $i++) {
            $randstr .= $chars[rand(0, $charlen - 1)];
        }
        return $randstr;
    }

}
