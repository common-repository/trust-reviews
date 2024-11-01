<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Request_Handler {

    public function __construct(Feed_Shortcode $feed_shortcode, Assets $assets) {
        $this->feed_shortcode = $feed_shortcode;
        $this->assets = $assets;
    }

    public function register() {
        add_action('init', array($this, 'init'));
    }

    public function init() {
        if (!empty($_GET['cf_action'])) {
            switch ($_GET['cf_action']) {
                case 'trp_embed':
                    header('Content-type: application/javascript');
                    header('Access-Control-Allow-Origin: *');

                    $feed_id  = sanitize_text_field(wp_unslash($_GET['trp_feed_id']));
                    $callback = sanitize_text_field(wp_unslash($_GET['trp_callback']));
                    $response = $this->feed_shortcode->init(array('id' => $feed_id));

                    if (strlen($response) > 0) {
                        $result = array(
                            'status' => 'success',
                            'data'   => $response,
                            'css'    => $this->assets->get_public_styles(),
                            'js'     => $this->assets->get_public_scripts()
                        );
                    } else {
                        $result = array(
                            'status' => 'error',
                            'data'   => 'Reviews feed with ID ' . $feed_id . ' not found'
                        );
                    }
                    echo $this->embed_code($feed_id, $callback) . $callback . "(" . json_encode($result) . ");";
                    die();
                break;
            }
        }
    }

    private function embed_code($id, $cb) {
        return 'function ' . $cb . '(e){document.body.querySelector("#trp_feed_' . $id . '").innerHTML=e.data;if(e.css)for(var t=0;t<e.css.length;t++)trp_load_css(e.css[t]);if(e.js)for(var n=0;n<e.js.length;n++)trp_load_js(e.js[n])}function trp_load_js(e,t){var n=document.createElement("script");n.type="text/javascript",n.src=e,n.async="true",t&&n.addEventListener("load",function(e){t(null,e)},!1),document.getElementsByTagName("head")[0].appendChild(n)}function trp_load_css(e){var t=document.createElement("link");t.rel="stylesheet",t.href=e,document.getElementsByTagName("head")[0].appendChild(t)}';
    }

}
