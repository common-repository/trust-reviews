<?php

namespace WP_Trust_Reviews_Plugin\Includes\Admin;

class Admin_Tophead {

    public function register() {
        add_action('wp_after_admin_bar_render', array($this, 'render'));
    }

    public function render() {
        $current_screen = get_current_screen();

        if (empty($current_screen)) {
            return;
        }

        if (strpos($current_screen->id, 'trp') !== false) {

            $current_screen->render_screen_meta();

            ?>
            <div class="trp-tophead">
                <div class="trp-tophead-title">
                    <img src="<?php esc_attr_e(TRP_ASSETS_URL . 'img/logo-tp.png') ?>" alt="logo"> Trust Reviews
                </div>
            </div>
            <?php
        }
    }
}
