<?php

namespace WP_Trust_Reviews_Plugin\Includes\Admin;

class Admin_Notice {

    private static $plugin_notices = array(
        'settings_active_0'  => 'Plugin disabled successfully.',
        'settings_active_1'  => 'Plugin enabled successfully.',
        'settings_save'      => 'Settings saved successfully.',
        'settings_create_db' => 'Database re-created successfully.',
        'settings_reset'     => 'Settings deleted successfully.',
        'settings_install'   => 'Plugin installed from scratch successfully.',
        'settings_reset_all' => 'All data including settings and reviews deleted successfully.',
    );

    public function register() {
        add_filter('removable_query_args', array($this, 'remove_query_args'));
        add_action('admin_notices', array($this, 'parse_notices_from_url'));
        add_action('admin_notices', array($this, 'render_notices'));
    }

    public function remove_query_args($args) {
        return array_merge($args, array('trp_notice'));
    }

    public function parse_notices_from_url() {
        if (!isset($_GET['trp_notice'])) {
            return;
        }

        $this->notice_id = sanitize_text_field(wp_unslash($_GET['trp_notice']));
    }

    public function render_notices() {
        if (empty($this->notice_id) || !$this->is_valid_screen()) {
            return;
        }

        if (doing_action('admin_notices') && $this->needs_repositioned()) {
            add_action('trp_admin_notices', array($this, 'render_notices'));
            return;
        }

        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo $this->notice_id != 'custom_msg' ? self::$plugin_notices[$this->notice_id] : get_option('trp_notice_msg'); ?></p>
        </div>
        <?php

        $this->notice_id = '';
    }

    protected function is_valid_screen($screen_id = '') {
        if ($screen_id === '') {
            $screen = get_current_screen();
            $screen_id = $screen->id;
        }

        return ($screen_id === 'dashboard' || $screen_id === 'plugins' || strpos($screen_id, 'trp') !== false) ? true : false;
    }

    protected function needs_repositioned($screen_id = '') {
        if ($screen_id === '') {
            $screen = get_current_screen();
            $screen_id = $screen->id;
        }

        $screen_ids = array('trust-reviews_page_trp-settings');
        return in_array($screen_id, $screen_ids) ? true : false;
    }

}
