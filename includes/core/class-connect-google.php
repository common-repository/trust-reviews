<?php

namespace WP_Trust_Reviews_Plugin\Includes\Core;

class Connect_Google {

    public function __construct() {
        add_action('init', array($this, 'request_handler'));
        add_action('trp_google_refresh', array($this, 'trp_google_refresh'));
    }

    public function request_handler() {
        global $wpdb;

        if (!empty($_GET['cf_action'])) {

            switch ($_GET['cf_action']) {

                case 'trp_connect_google':
                    if (current_user_can('manage_options')) {
                        if (isset($_POST['trp_wpnonce']) === false) {
                            $error = __('Unable to call request. Make sure you are accessing this page from the Wordpress dashboard.');
                            $response = compact('error');
                        } else {
                            check_admin_referer('trp_wpnonce', 'trp_wpnonce');

                            $key = sanitize_text_field(wp_unslash($_POST['key']));
                            if (strlen($key) > 0) {
                                update_option('trp_google_api_key', $key);
                            }
                            $google_api_key = get_option('trp_google_api_key');

                            $id = sanitize_text_field(wp_unslash($_POST['id']));
                            $lang = sanitize_text_field(wp_unslash($_POST['lang']));
                            $url = $this->api_url($id, $google_api_key, $lang);

                            $res = wp_remote_get($url);
                            $body = wp_remote_retrieve_body($res);
                            $body_json = json_decode($body);

                            if ($body_json && isset($body_json->result)) {
                                $photo = $this->business_avatar($body_json->result, $google_api_key);
                                $body_json->result->business_photo = $photo;

                                $this->save_reviews($body_json->result);

                                $result = array(
                                    'id'      => $body_json->result->place_id,
                                    'name'    => $body_json->result->name,
                                    'photo'   => strlen($photo) ? $photo : $body_json->result->icon,
                                    'reviews' => $body_json->result->reviews
                                );
                                $status = 'success';
                            } else {
                                $result = $body_json;
                                $status = 'failed';
                            }
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

    function trp_google_refresh($args) {
        $google_api_key = get_option('trp_google_api_key');
        if (!$google_api_key) {
            return;
        }

        $place_id = $args[0];
        $reviews_lang = $args[1];

        $url = $this->api_url($place_id, $google_api_key, $reviews_lang);

        $res = wp_remote_get($url);
        $body = wp_remote_retrieve_body($res);
        $body_json = json_decode($body);

        if ($body_json && isset($body_json->result)) {
            $photo = $this->business_avatar($body_json->result, $google_api_key);
            $body_json->result->business_photo = $photo;

            $this->save_reviews($body_json->result);
        }

        delete_transient('trp_google_refresh_' . join('_', $args));
    }

    function save_reviews($place, $min_filter = 0) {
        global $wpdb;

        $business_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . Database::BUSINESS_TABLE . " WHERE place_id = %s AND platform = %s", $place->place_id, 'google'));
        if ($business_id) {
            $update_params = array(
                'name'         => $place->name,
                'rating'       => $place->rating,
                'review_count' => isset($place->user_ratings_total) ? $place->user_ratings_total : null
            );
            if (isset($place->business_photo) && strlen($place->business_photo) > 0) {
                $update_params['photo'] = $place->business_photo;
            }
            $wpdb->update($wpdb->prefix . Database::BUSINESS_TABLE, $update_params, array('ID'  => $business_id));
        } else {
            $wpdb->insert($wpdb->prefix . Database::BUSINESS_TABLE, array(
                'place_id'     => $place->place_id,
                'name'         => $place->name,
                'photo'        => $place->business_photo,
                'icon'         => $place->icon,
                'address'      => $place->formatted_address,
                'rating'       => isset($place->rating)             ? $place->rating             : null,
                'url'          => isset($place->url)                ? $place->url                : null,
                'website'      => isset($place->website)            ? $place->website            : null,
                'review_count' => isset($place->user_ratings_total) ? $place->user_ratings_total : null,
                'platform'     => 'google'
            ));
            $business_id = $wpdb->insert_id;
        }

        if ($place->reviews) {
            $reviews = $place->reviews;
            foreach ($reviews as $review) {
                if ($min_filter > 0 && $min_filter > $review->rating) {
                    continue;
                }

                $review_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE time = %s AND business_id = %d AND platform = %s", $review->time, $business_id, 'google'));
                if ($review_id) {
                    $update_params = array(
                        'rating'      => $review->rating,
                        'text'        => $review->text
                    );
                    if (isset($review->profile_photo_url)) {
                        $update_params['author_img'] = $review->profile_photo_url;
                    }
                    $wpdb->update($wpdb->prefix . Database::REVIEW_TABLE, $update_params, array('ID' => $review_id));
                } else {
                    $wpdb->insert($wpdb->prefix . Database::REVIEW_TABLE, array(
                        'business_id' => $business_id,
                        'rating'      => $review->rating,
                        'text'        => $review->text,
                        'time'        => $review->time,
                        'language'    => $review->language,
                        'author_name' => $review->author_name,
                        'author_url'  => isset($review->author_url) ? $review->author_url : null,
                        'author_img'  => isset($review->profile_photo_url) ? $review->profile_photo_url : null,
                        'platform'    => 'google'
                    ));
                }
            }
        }
    }

    function api_url($placeid, $google_api_key, $reviews_lang = '') {
        $url = TRP_GOOGLE_API . 'details/json?placeid=' . $placeid . '&key=' . $google_api_key;
        if (strlen($reviews_lang) > 0) {
            $url = $url . '&language=' . $reviews_lang;
        }
        return $url;
    }

    function business_avatar($response_result_json, $google_api_key) {
        if (isset($response_result_json->photos)) {
            $url = add_query_arg(
                array(
                    'photoreference' => $response_result_json->photos[0]->photo_reference,
                    'key'            => $google_api_key,
                    'maxwidth'       => '300',
                    'maxheight'      => '300',
                ),
                'https://maps.googleapis.com/maps/api/place/photo'
            );
            $res = wp_remote_get($url, array('timeout' => 8));
            if(!is_wp_error($res)) {
                $bits = wp_remote_retrieve_body($res);
                $filename = $response_result_json->place_id . '.jpg';
                $upload = wp_upload_bits($filename, null, $bits);
                return $upload['url'];
            }
        }
        return null;
    }

}