<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Assets {

    private $url;
    private $version;
    private $suffix;

    private static $css_asserts = array(
        'trp-admin-css'    => 'css/trp-admin',
        'trp-builder-css'  => 'css/trp-builder',
        'trp-main-css'     => 'css/trp-main',
        'trp-css'          => 'css/trp',
    );

    private static $js_asserts = array(
        'trp-admin-js'     => 'js/trp-admin',
        'trp-builder-js'   => 'js/trp-builder',
        'trp-time-js'      => 'js/wpac-time',
        'blazy-js'         => 'js/blazy.min',
        'trp-main-js'      => 'js/trp-main',
        'trp-js'           => 'js/trp',
    );

    public function __construct($url, $version) {
        $this->url     = $url;
        $this->version = $version;
        $this->suffix  = '';
    }

    public function register() {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'register_styles'));
            add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        } else {
            add_action('wp_enqueue_scripts', array($this, 'register_styles'));
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
            $trp_demand_assets = get_option('trp_demand_assets');
            if (!$trp_demand_assets || $trp_demand_assets != 'true') {
                add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));
                add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
            }
        }
    }

    public function register_styles() {
        $this->register_styles_loop(array('trp-admin-css', 'trp-builder-css', 'trp-css', 'trp-main-css'));
    }

    public function register_scripts() {
        $this->register_scripts_loop(array('trp-admin-js', 'trp-builder-js', 'trp-time-js', 'blazy-js', 'trp-js', 'trp-main-js'));
    }

    public function enqueue_admin_styles() {
        wp_enqueue_style('trp-admin-css');
        wp_enqueue_style('trp-builder-css');
        wp_enqueue_style('trp-css');
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('trp-wpac-js');
        wp_enqueue_script('trp-admin-js');
        wp_localize_script('trp-builder-js', 'TRP_VARS', array(
            'wordpress'      => true,
            'googleAPIKey'   => get_option('trp_google_api_key'),
            'yelpAPIKey'     => get_option('trp_yelp_api_key'),
            'settingsUrl'    => admin_url('admin.php?page=trp-settings'),
            'supportUrl'     => admin_url('admin.php?page=trp-support'),
            'handlerUrl'     => admin_url('options-general.php?page=trp'),
            'TRP_ASSETS_URL' => TRP_ASSETS_URL,
        ));
        wp_enqueue_script('trp-builder-js');
        wp_enqueue_script('trp-time-js');
        wp_enqueue_script('blazy-js');
        wp_enqueue_script('trp-js');
    }

    public function enqueue_public_styles() {
        $trp_minified_assets = get_option('trp_minified_assets');
        if (!$trp_minified_assets || $trp_minified_assets != 'true') {
            wp_enqueue_style('trp-css');
        } else {
            wp_enqueue_style('trp-main-css');
        }
    }

    public function enqueue_public_scripts() {
        $trp_minified_assets = get_option('trp_minified_assets');
        if (!$trp_minified_assets || $trp_minified_assets != 'true') {
            wp_enqueue_script('trp-time-js');
            wp_enqueue_script('blazy-js');
            wp_enqueue_script('trp-js');
        } else {
            wp_enqueue_script('trp-main-js');
        }
    }

    public function get_public_styles() {
        $trp_minified_assets = get_option('trp_minified_assets');
        if (!$trp_minified_assets || $trp_minified_assets != 'true') {
            return array(
                $this->get_css_assert('trp-css'),
            );
        } else {
            return array($this->get_css_assert('trp-main-css'));
        }
    }

    public function get_public_scripts() {
        $trp_minified_assets = get_option('trp_minified_assets');
        if (!$trp_minified_assets || $trp_minified_assets != 'true') {
            return array(
                $this->get_js_assert('trp-time-js'),
                $this->get_js_assert('blazy-js'),
                $this->get_js_assert('trp-js'),
            );
        } else {
            return array($this->get_js_assert('trp-main-js'));
        }
    }

    private function register_styles_loop($styles) {
        foreach ($styles as $style) {
            wp_register_style($style, $this->get_css_assert($style), array(), $this->version);
        }
    }

    private function register_scripts_loop($scripts) {
        foreach ($scripts as $script) {
            wp_register_script($script, $this->get_js_assert($script), array(), $this->version);
        }
    }

    private function get_css_assert($assert) {
        return $this->url . self::$css_asserts[$assert] . $this->suffix . '.css';
    }

    private function get_js_assert($assert) {
        return $this->url . self::$js_asserts[$assert] . $this->suffix . '.js';
    }

}