<?php

namespace WP_Trust_Reviews_Plugin\Includes;

use WP_Trust_Reviews_Plugin\Includes\Core\Core;

class Builder_Page {

    public function __construct(Feed_Deserializer $feed_deserializer, Core $core, View $view) {
        $this->feed_deserializer = $feed_deserializer;
        $this->core = $core;
        $this->view = $view;
    }

    public function register() {
        add_action('trp_admin_page_trp-builder', array($this, 'init'));
    }

    public function init() {
        if (isset($_GET['trp_notice'])) {
            $this->add_admin_notice();
        }

        $feed = null;
        if (isset($_GET['trp_feed_id'])) {
            $feed = $this->feed_deserializer->get_feed(sanitize_text_field(wp_unslash($_GET['trp_feed_id'])));
        }

        $this->render($feed);
    }

    public function add_admin_notice($notice_code = 0) {

    }

    public function render($feed) {
        global $wp_version;
        if (version_compare($wp_version, '3.5', '>=')) {
            wp_enqueue_media();
        }

        wp_nonce_field('trp_wpnonce', 'trp_nonce');

        $feed_id = '';
        $feed_post_title = '';
        $feed_content = '';
        $feed_inited = false;
        $businesses = null;
        $reviews = null;

        if ($feed != null) {
            $feed_id = $feed->ID;
            $feed_post_title = $feed->post_title;
            $feed_content = trim($feed->post_content);

            $data = $this->core->get_reviews($feed);
            $businesses = $data['businesses'];
            $reviews = $data['reviews'];
            $options = $data['options'];
            if (isset($businesses) && count($businesses) || isset($reviews) && count($reviews)) {
                $feed_inited = true;
            }
        }

        $google_places_api = get_option('trp_google_places_api');

        ?>
        <div class="trp-builder">
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=trp_feed_save')); ?>">
                <input type="hidden" name="trp_feed[post_id]" value="<?php echo esc_attr($feed_id); ?>">
                <input type="hidden" name="trp_feed[current_url]" value="<?php echo home_url($_SERVER['REQUEST_URI']); ?>">
                <div class="trp-builder-workspace">
                    <div class="trp-toolbar">
                        <div class="trp-toolbar-title">
                            <input class="trp-toolbar-title-input" type="text" name="trp_feed[title]" value="<?php if (isset($feed_post_title)) { echo $feed_post_title; } ?>" placeholder="Enter a feed name" maxlength="255" autofocus>
                        </div>
                        <div class="trp-toolbar-control">
                            <?php if ($feed_inited) { ?>
                            <label><span id="trp_sc_msg">Shortcode </span><input id="trp_sc" type="text" value="[trp_feed id=&quot;<?php echo esc_attr($feed_id); ?>&quot;]" data-trp-shortcode="[trp_feed id=&quot;<?php echo esc_attr($feed_id); ?>&quot;]" onclick="this.select(); document.execCommand('copy'); window.trp_sc_msg.innerHTML = 'Shortcode Copied! ';" readonly/></label>
                            <div class="trp-toolbar-options">
                                <label title="Sometimes, you need to use this shortcode in PHP, for instance in header.php or footer.php files, in this case use this option"><input type="checkbox" onclick="var el = window.trp_sc; if (this.checked) { el.value = '&lt;?php echo do_shortcode( \'' + el.getAttribute('data-trp-shortcode') + '\' ); ?&gt;'; } else { el.value = el.getAttribute('data-trp-shortcode'); } el.select();document.execCommand('copy'); window.trp_sc_msg.innerHTML = 'Shortcode Copied! ';"/>Use in PHP</label>
                            </div>
                            <?php } ?>
                            <button type="submit" class="button button-primary">Save & Update</button>
                        </div>
                    </div>
                    <div class="trp-builder-preview">
                        <textarea id="trp-builder-connection" name="trp_feed[content]" style="display:none"><?php echo $feed_content; ?></textarea>
                        <?php
                        if ($feed_inited) {
                            echo $this->view->render($feed_id, $businesses, $reviews, $options);
                        } else {
                            ?>To show reviews in this preview, firstly connect services on the right menu (Google, Facebook and etc.) and click '<b>Save & Update</b>' button. Then you can use this created feed as a widget or shortcode.<?php
                        }
                        ?>
                    </div>
                </div>
                <div id="trp-builder-option" class="trp-builder-options"></div>
            </form>
        </div>
        <script>
            jQuery(document).ready(function($) {
                function trp_builder_init_listener(attempts) {
                    if (!window.trp_builder_init) {
                        if (attempts > 0) {
                            setTimeout(function() { trp_builder_init_listener(attempts - 1); }, 200);
                        }
                        return;
                    }
                    trp_builder_init($, {
                        el: '#trp-builder-option',
                        auth_code: '<?php echo get_option('trp_auth_code'); ?>',
                        use_gpa: true,
                        <?php if (strlen($feed_content) > 0) { ?>
                        conns: <?php echo $feed_content; ?>
                        <?php } ?>
                    });
                }
                trp_builder_init_listener(20);
            });
        </script>
        <style>
            .update-nag { display: none; }
        </style>
        <?php
    }
}
