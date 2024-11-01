<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Feed_Page {

    public function __construct(Feed_Deserializer $feed_deserializer) {
        $this->feed_deserializer = $feed_deserializer;
    }

    public function register() {
        add_filter('views_edit-trp_feed', array($this, 'render'), 20);
    }

    public function render() {
        $feed_count = $this->feed_deserializer->get_feed_count();
        ?>
        <div class="trp-admin-feeds">
            <a class="button button-primary" href="<?php echo admin_url('admin.php'); ?>?page=trp-builder">Create Reviews Feed</a>
            <?php if ($feed_count < 1) { ?>
            <h3 style="display:inline;vertical-align:middle;"> - First of all, create a new Reviews Feed to show reviews through a shortcode or widget</h3>
            <?php } ?>
        </div>
        <?php
    }
}
