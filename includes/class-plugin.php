<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Admin\Admin_Menu;
use WP_Trust_Reviews_Plugin\Includes\Admin\Admin_Tophead;
use WP_Trust_Reviews_Plugin\Includes\Admin\Admin_Notice;
use WP_Trust_Reviews_Plugin\Includes\Admin\Admin_Feed_Columns;

use WP_Trust_Reviews_Plugin\Includes\Core\Database;
use WP_Trust_Reviews_Plugin\Includes\Core\Core;
use WP_Trust_Reviews_Plugin\Includes\Core\Connect_Google;
use WP_Trust_Reviews_Plugin\Includes\Core\Connect_Yelp;

final class Plugin {

    protected $plugin_name;
    protected $version;
    protected $activator;

    public function __construct() {
        $this->plugin_name = 'trust-reviews';
        $this->version     = TRP_VERSION;
    }

    public function register() {
        register_activation_hook(TRP_PLUGIN_FILE, array($this, 'activate'));
        register_deactivation_hook(TRP_PLUGIN_FILE, array($this, 'deactivate'));

        add_action('plugins_loaded', array($this, 'register_services'));
    }

    public function register_services() {
        $this->init_language();

        $database = new Database();

        $activator = new Activator($database);
        $activator->register();

        $debug_info = new Debug_Info($activator);

        $assets = new Assets(TRP_ASSETS_URL, $this->version);
        $assets->register();

        $post_types = new Post_Types();
        $post_types->register();

        $feed_deserializer = new feed_Deserializer(new \WP_Query());

        $feed_page = new feed_Page($feed_deserializer);
        $feed_page->register();

        $core = new Core();

        $view = new View();

        $builder_page = new Builder_Page($feed_deserializer, $core, $view);
        $builder_page->register();

        $feed_shortcode = new feed_Shortcode($feed_deserializer, $core, $view, $assets);
        $feed_shortcode->register();

        Feed_Widget::$static_feed_deserializer = $feed_deserializer;
        Feed_Widget::$static_core = $core;
        Feed_Widget::$static_view = $view;
        Feed_Widget::$static_assets = $assets;
        add_action('widgets_init', function() {
            register_widget('WP_Trust_Reviews_Plugin\Includes\Feed_Widget');
        });

        $connect_google = new Connect_Google();

        $connect_yelp = new Connect_Yelp();

        $request_handler = new Request_Handler($feed_shortcode, $assets);
        $request_handler->register();

        if (is_admin()) {
            $feed_serializer = new Feed_Serializer();

            $admin_notice = new Admin_Notice();
            $admin_notice->register();

            $admin_menu = new Admin_Menu();
            $admin_menu->register();

            $admin_tophead = new Admin_Tophead();
            $admin_tophead->register();

            $admin_feed_columns = new Admin_Feed_Columns($feed_deserializer);
            $admin_feed_columns->register();

            $settings_save = new Settings_Save($activator);
            $settings_save->register();

            $plugin_settings = new Plugin_Settings($debug_info);
            $plugin_settings->register();

            $plugin_support = new Plugin_Support();
            $plugin_support->register();
        }
    }

    public function init_language() {
        load_plugin_textdomain('trp', false, basename(dirname(TRP_PLUGIN_FILE)) . '/languages');
    }

    public function activate($network_wide = false) {
        add_option('trp_is_multisite', $network_wide);

        $activator = new Activator(new Database());
        $activator->activate();
    }

    public function deactivate() {
        $deactivator = new Deactivator();
        $deactivator->deactivate();
    }
}