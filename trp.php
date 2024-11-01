<?php
/*
Plugin Name: Trust Reviews plugin for Google, Tripadvisor, Yelp, Airbnb and other platforms
Plugin Title: Trust Reviews plugin for Google, Facebook, Tripadvisor, Yelp, Airbnb and other platforms
Plugin URI: https://wordpress.org/plugins/trust-reviews
Description: All major business reviews from Google, Facebook, Tripadvisor, Yelp and other platforms in a single feed on your website to boost user confidence and SEO.
Author: trust.reviews <support@trust.reviews>
Author URI: https://trust.reviews
Text Domain: trust-reviews
Domain Path: /languages
Version: 1.0
*/

namespace WP_Trust_Reviews_Plugin;

if (!defined('ABSPATH')) {
    exit;
}

require(ABSPATH . 'wp-includes/version.php');

define('TRP_VERSION'         , '1.0');
define('TRP_PLUGIN_FILE'     , __FILE__);
define('TRP_PLUGIN_URL'      , plugins_url(basename(plugin_dir_path(__FILE__ )), basename(__FILE__)));
define('TRP_ASSETS_URL'      , TRP_PLUGIN_URL . '/assets/');

define('TRP_GOOGLE_API'      , 'https://maps.googleapis.com/maps/api/place/');
define('TRP_FACEBOOK_API'    , 'https://graph.facebook.com/v10.0/');
define('TRP_YELP_API'        , 'https://api.yelp.com/v3/businesses');

define('TRP_GOOGLE_AVATAR'   , TRP_ASSETS_URL . 'img/google_avatar.png');
define('TRP_FACEBOOK_AVATAR' , TRP_ASSETS_URL . 'img/fb_avatar.png');
define('TRP_YELP_AVATAR'     , TRP_ASSETS_URL . 'img/yelp_avatar.png');

require_once __DIR__ . '/autoloader.php';

$trp = new Includes\Plugin();
$trp->register();

?>