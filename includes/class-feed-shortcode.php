<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Core;

class Feed_Shortcode {

    public function __construct(Feed_Deserializer $feed_deserializer, Core $core, View $view, Assets $assets) {
        $this->feed_deserializer = $feed_deserializer;
        $this->core = $core;
        $this->view = $view;
        $this->assets = $assets;
    }

    public function register() {
        add_shortcode('trp_feed', array($this, 'init'));
    }

    public function init($atts) {
        if (get_option('trp_active') === '0') {
            return '';
        }

        $atts = shortcode_atts(array('id' => 0), $atts, 'trp_feed');
        $feed = $this->feed_deserializer->get_feed($atts['id']);

        if (!$feed) {
            return null;
        }

        $trp_demand_assets = get_option('trp_demand_assets');
        if ($trp_demand_assets || $trp_demand_assets == 'true') {
            $this->assets->enqueue_public_styles();
            $this->assets->enqueue_public_scripts();
        }

        $data = $this->core->get_reviews($feed);
        $businesses = $data['businesses'];
        $reviews = $data['reviews'];
        $options = $data['options'];

        return $this->view->render($feed->ID, $businesses, $reviews, $options);
    }
}
