<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Plugin_Support {

    public function __construct() {
    }

    public function register() {
        add_action('trp_admin_page_trp-support', array($this, 'init'));
        add_action('trp_admin_page_trp-support', array($this, 'render'));
    }

    public function init() {

    }

    public function render() {

        $tab = isset($_GET['trp_tab']) && strlen($_GET['trp_tab']) > 0 ? sanitize_text_field(wp_unslash($_GET['trp_tab'])) : 'active';

        ?>
        <div class="trp-page-title">
            Support and Troubleshooting
        </div>

        <div class="trp-support-workspace">

            <div data-nav-tabs="">
                <div class="nav-tab-wrapper">
                    <a href="#trp-introduction"    class="nav-tab<?php if ($tab == 'active')          { ?> nav-tab-active<?php } ?>">Introduction</a>
                    <a href="#trp-google"          class="nav-tab<?php if ($tab == 'google')          { ?> nav-tab-active<?php } ?>">How to connect Google</a>
                    <a href="#trp-facebook"        class="nav-tab<?php if ($tab == 'facebook')        { ?> nav-tab-active<?php } ?>">How to connect Facebook</a>
                    <a href="#trp-tripadvisor"     class="nav-tab<?php if ($tab == 'tripadvisor')     { ?> nav-tab-active<?php } ?>">How to connect Tripadvisor</a>
                    <a href="#trp-yelp"            class="nav-tab<?php if ($tab == 'yelp')            { ?> nav-tab-active<?php } ?>">How to connect Yelp</a>
                    <a href="#trp-other-platforms" class="nav-tab<?php if ($tab == 'other-platforms') { ?> nav-tab-active<?php } ?>">Other platforms</a>
                </div>
                <div id="trp-introduction" class="tab-content" style="display:<?php echo $tab == 'active' ? 'block' : 'none'?>;">
                    <h3>Trust Reviews for WordPress</h3>
                    <p>Trust.Reviews is a first WordPress plugin with ability to merge business reviews from several platforms such a Google, Facebook, TripAdvisor, Yelp and others. You can show these in a separate ratings or summary header. It is also an easy and fast way to integrate business reviews right into your WordPress website through Widgets or Shortcodes.</p>
                </div>
                <div id="trp-google" class="tab-content" style="display:<?php echo $tab == 'google' ? 'block' : 'none'?>;">
                    <h3>How to connect Google reviews</h3>
                    <?php include_once(dirname(__FILE__) . '/support-google.php'); ?>
                </div>
                <div id="trp-facebook" class="tab-content" style="display:<?php echo $tab == 'facebook' ? 'block' : 'none'?>;">
                    <h3>How to connect Facebook reviews</h3>
                    <?php include_once(dirname(__FILE__) . '/support-facebook.php'); ?>
                </div>
                <div id="trp-tripadvisor" class="tab-content" style="display:<?php echo $tab == 'tripadvisor' ? 'block' : 'none'?>;">
                    <h3>How to connect Tripadvisor reviews</h3>
                    <div>It will available soon!</div>
                </div>
                <div id="trp-yelp" class="tab-content" style="display:<?php echo $tab == 'yelp' ? 'block' : 'none'?>;">
                    <h3>How to connect Yelp reviews</h3>
                    <?php include_once(dirname(__FILE__) . '/support-yelp.php'); ?>
                </div>
                <div id="trp-other-platforms" class="tab-content" style="display:<?php echo $tab == 'other-platforms' ? 'block' : 'none'?>;">
                    <h3>How to connect other business reviews</h3>
                    <div>It will available soon!</div>
                </div>
            </div>
        </div>
        <?php
    }
}
