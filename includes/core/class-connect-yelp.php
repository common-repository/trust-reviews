<?php

namespace WP_Trust_Reviews_Plugin\Includes\Core;

class Connect_Yelp {

    public function __construct() {
        add_action('init', array($this, 'request_handler'));
        add_action('trp_yelp_refresh', array($this, 'trp_yelp_refresh'));
    }

    public function request_handler() {
        global $wpdb;

        if (!empty($_GET['cf_action'])) {

            switch ($_GET['cf_action']) {

                case 'trp_connect_yelp':
                    if (current_user_can('manage_options')) {
                        if (isset($_POST['trp_wpnonce']) === false) {
                            $error = __('Unable to call request. Make sure you are accessing this page from the Wordpress dashboard.');
                            $response = compact('error');
                        } else {
                            check_admin_referer('trp_wpnonce', 'trp_wpnonce');

                            $id = sanitize_text_field(wp_unslash($_POST['id']));
                            $lang = sanitize_text_field(wp_unslash($_POST['lang']));
                            $api_key = sanitize_text_field(wp_unslash($_POST['key']));

                            if (strlen($api_key) > 0) {
                                update_option('trp_yelp_api_key', $api_key);
                            }

                            $yelp_api_key = get_option('trp_yelp_api_key');
                            $req_args = array(
                                'user-agent' => '',
                                'headers' => array(
                                    'Authorization' => 'Bearer ' . $yelp_api_key
                                )
                            );

                            $business = json_decode(wp_remote_retrieve_body(wp_remote_get(TRP_YELP_API . '/' . $id, $req_args)));
                            $reviews = json_decode(wp_remote_retrieve_body(wp_remote_get($this->api_url($id, $lang), $req_args)));

                            $this->save_reviews($business, $reviews, $lang);

                            $result = array(
                                'id'      => $business->id,
                                'name'    => $business->name,
                                'photo'   => $business->photos[0],
                                'reviews' => $reviews
                            );
                            $status = 'success';

                            $response = compact('status', 'result');
                        }
                        header('Content-type: text/javascript');
                        echo json_encode($response);
                        die();
                    }
                break;

            }
        }
    }

    function trp_yelp_refresh($args) {
        $yelp_api_key = get_option('trp_yelp_api_key');
        if (!$yelp_api_key) {
            return;
        }

        $biz_id = $args[0];
        $biz_lang = $args[1];

        $req_args = array(
            'user-agent' => '',
            'headers' => array(
                'Authorization' => 'Bearer ' . $yelp_api_key
            )
        );

        $business = json_decode(wp_remote_retrieve_body(wp_remote_get(TRP_YELP_API . '/' . $biz_id, $req_args)));
        $reviews = json_decode(wp_remote_retrieve_body(wp_remote_get($this->api_url($biz_id, $biz_lang), $req_args)));

        $this->save_reviews($business, $reviews, $lang);

        delete_transient('trp_yelp_refresh_' . join('_', $args));
    }

    function save_reviews($business, $reviews, $lang = null) {
        global $wpdb;

        $business_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . Database::BUSINESS_TABLE . " WHERE place_id = %s AND platform = %s", $business->id, 'yelp'));
        if ($business_id) {

            $wpdb->update($wpdb->prefix . Database::BUSINESS_TABLE, array(
                'name'         => $business->name,
                'photo'        => $business->image_url,
                'rating'       => $business->rating,
                'review_count' => $business->review_count
            ), array('ID' => $business_id));

        } else {

            $address = implode(", ", array(
                $business->location->address1,
                $business->location->city,
                $business->location->state,
                $business->location->zip_code
            ));
            $wpdb->insert($wpdb->prefix . Database::BUSINESS_TABLE, array(
                'place_id'     => $business->id,
                'name'         => $business->name,
                'photo'        => $business->image_url,
                'address'      => $address,
                'rating'       => $business->rating,
                'url'          => $business->url,
                'review_count' => $business->review_count,
                'platform'     => 'yelp'
            ));
            $business_id = $wpdb->insert_id;

        }

        if ($reviews && $reviews->reviews) {
            foreach ($reviews->reviews as $review) {

                $review_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE review_id = %s AND business_id = %d AND platform = %s", $review->id, $business_id, 'yelp'));
                if ($review_id) {

                    $wpdb->update($wpdb->prefix . Database::REVIEW_TABLE, array(
                        'rating'      => $review->rating,
                        'text'        => $review->text,
                        'author_name' => $review->user->name,
                        'author_img'  => $review->user->image_url
                    ), array('ID' => $review_id));

                } else {

                    $wpdb->insert($wpdb->prefix . Database::REVIEW_TABLE, array(
                        'business_id' => $business_id,
                        'review_id'   => $review->id,
                        'rating'      => $review->rating,
                        'text'        => $review->text,
                        'url'         => $review->url,
                        'language'    => $lang,
                        'time_str'    => $review->time_created,
                        'author_name' => $review->user->name,
                        'author_img'  => $review->user->image_url,
                        'platform'    => 'yelp'
                    ));

                }

            }
        }
    }

    function api_url($yelp_business_id, $reviews_lang = '') {
        $url = TRP_YELP_API . '/' . $yelp_business_id . '/reviews';
        if (strlen($reviews_lang) > 0) {
            $url = $url . '?locale=' . $reviews_lang;
        }
        return $url;
    }

}