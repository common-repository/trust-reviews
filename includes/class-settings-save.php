<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Database;

class Settings_Save {

    public function __construct(Activator $activator) {
        $this->activator = $activator;
    }

    public function register() {
        add_action('admin_post_trp_settings_save', array($this, 'save_from_post_array'));
    }

    public function save_from_post_array() {
        global $wpdb;

        if (!function_exists('wp_nonce_field')) {
            function wp_nonce_field() {}
        }

        if (!current_user_can('manage_options')) {
            die('The account you\'re logged in to doesn\'t have permission to access this page.');
        }

        if (!empty($_POST)) {
            $nonce_result_check = $this->check_nonce();
            if ($nonce_result_check === false) {
                die('Unable to save changes. Make sure you are accessing this page from the Wordpress dashboard.');
            }
        }

        $notice_code = null;

        if (isset($_POST['active']) && isset($_GET['active'])) {
            $active = $_GET['active'] == '1' ? '1' : '0';
            update_option('trp_active', $active);
            $notice_code = 'settings_active_' . $active;
        }

        if (isset($_POST['save'])) {
            $fields = array('trp_demand_assets', 'trp_minified_assets', 'trp_google_api_key', 'trp_google_places_api', 'trp_yelp_api_key');
            foreach ($fields as $key => $value) {
                if (isset($_POST[$value])) {
                    update_option($value, trim(sanitize_text_field(wp_unslash($_POST[$value]))));
                }
            }
            $notice_code = 'settings_save';
        }

        if (isset($_POST['create_db'])) {
            $this->activator->create_db();
            $notice_code = 'settings_create_db';
        }

        if (isset($_POST['install'])) {
            $install_multisite = sanitize_text_field(wp_unslash($_POST['install_multisite']));
            $this->activator->drop_db($install_multisite);
            $this->activator->delete_all_options($install_multisite);
            $this->activator->delete_all_feeds($install_multisite);
            $this->activator->activate();
            $notice_code = 'settings_install';
        }

        if (isset($_POST['reset_all'])) {
            $reset_all_multisite = sanitize_text_field(wp_unslash($_POST['reset_all_multisite']));
            $this->activator->drop_db($reset_all_multisite);
            $this->activator->delete_all_options($reset_all_multisite);
            $this->activator->delete_all_feeds($reset_all_multisite);
            $notice_code = 'settings_reset_all';
        }

        $this->redirect_to_tab($notice_code);
    }

    public function redirect_to_tab($notice_code = '') {
        if (empty($_GET['trp_tab'])) {
            wp_safe_redirect(wp_get_referer());
            exit;
        }

        $tab = sanitize_text_field(wp_unslash($_GET['trp_tab']));

        $query_args = array(
            'trp_tab' => $tab,
        );

        if (!empty($notice_code)) {
            $query_args['trp_notice'] = $notice_code;
        }

        wp_safe_redirect(add_query_arg($query_args, wp_get_referer()));
        exit;
    }

    private function check_nonce() {
        $nonce_actions = array('active', 'save', 'create_db', 'reset', 'reset_all');
        $nonce_form_prefix = 'trp-form_nonce_';
        $nonce_action_prefix = 'trp-wpnonce_';
        foreach ($nonce_actions as $key => $value) {
            if (isset($_POST[$nonce_form_prefix.$value])) {
                check_admin_referer($nonce_action_prefix.$value, $nonce_form_prefix.$value);
                return true;
            }
        }
        return false;
    }

}
