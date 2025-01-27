<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Database;

class Debug_Info {

    public function __construct(Activator $activator) {
        $this->activator = $activator;
    }

    public function render() {
        global $wpdb;
        global $wp_version;

        ?>

URL: <?php echo esc_url(get_option('siteurl')); ?>

PHP Version: <?php echo esc_html(phpversion()); ?>

WP Version: <?php echo esc_html($wp_version); ?>

Active Theme:
<?php
if (!function_exists('wp_get_theme')) {
    $theme = get_theme(get_current_theme());
    echo esc_html($theme['Name'] . ' ' . $theme['Version']);
} else {
    $theme = wp_get_theme();
    echo esc_html($theme->Name . ' ' . $theme->Version);
}
?>

Outgoing HTTPS requests: <?php
$res = wp_remote_get('https://app.trust.reviews/checkconn');
$body = wp_remote_retrieve_body($res);
echo ($body && $body == 'success') ? 1 : 'Outgoing HTTPS requests are closed'; ?>

Plugin Version: <?php echo esc_html(TRP_VERSION); ?>

Settings:
<?php foreach ($this->activator->options() as $opt) {
    echo esc_html($opt.': '.get_option($opt)."\n");
}
?>

Widgets: <?php $widget = get_option('widget_trp_widget'); echo ($widget ? print_r($widget) : '')."\n"; ?>

Plugins:
<?php
foreach (get_plugins() as $key => $plugin) {
    $isactive = "";
    if (is_plugin_active($key)) {
        $isactive = "(active)";
    }
    echo esc_html($plugin['Name'].' '.$plugin['Version'].' '.$isactive."\n");
}
?>

------------ Feeds ------------

<?php
$wp_query = new \WP_Query();
$wp_query->query(array(
    'post_type'      => 'trp_feed',
    'fields'         => array('ID', 'post_title', 'post_content'),
    'posts_per_page' => 300,
    'no_found_rows'  => true,
));
$feeds = $wp_query->posts;
foreach ($feeds as $feed) {
    echo $feed->ID . " " . $feed->post_title . ": " . $feed->post_content . "\r\n\r\n";
}
?>

<?php
$places = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . Database::BUSINESS_TABLE);
$places_error = $wpdb->last_error;
$reviews = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE);
$reviews_error = $wpdb->last_error; ?>

------------ Places ------------

<?php if (isset($places_error) && strlen($places_error) > 0) { echo 'DB Places error: ' . $places_error; } ?>

<?php echo print_r($places); ?>


------------ Reviews ------------

<?php if (isset($reviews_error) && strlen($reviews_error) > 0) { echo 'DB Reviews error: ' . $reviews_error; } ?>

<?php echo print_r($reviews);

    }

}
