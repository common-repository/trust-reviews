<?php

namespace WP_Trust_Reviews_Plugin\Includes\Core;

class Core {

    protected $STARS = array('STAR_RATING_UNSPECIFIED' => 0, 'ONE' => 1, 'TWO' => 2, 'THREE' => 3, 'FOUR' => 4, 'FIVE' => 5);

    public function __construct() {

    }

    public function get_reviews($feed) {
        $connection            = json_decode($feed->post_content);
        $cache_time            = isset($connection->options->cache) ? $connection->options->cache : null;
        $data_cache_key        = 'trp_feed_' . TRP_VERSION . '_' . $feed->ID . '_reviews';
        $connection_cache_key  = 'trp_feed_' . TRP_VERSION . '_' . $feed->ID . '_options';

        $data                  = get_transient($data_cache_key);
        $cached_connection     = get_transient($connection_cache_key);
        $serialized_connection = serialize($connection);

        if ($data === false || $serialized_connection !== $cached_connection || !$cache_time) {
            $expiration = $cache_time;
            switch ($expiration) {
                case '1':
                    $expiration = 3600;
                    break;
                case '3':
                    $expiration = 3600 * 3;
                    break;
                case '6':
                    $expiration = 3600 * 6;
                    break;
                case '12':
                    $expiration = 3600 * 12;
                    break;
                case '24':
                    $expiration = 3600 * 24;
                    break;
                case '48':
                    $expiration = 3600 * 48;
                    break;
                case '168':
                    $expiration = 3600 * 168;
                    break;
                default:
                    $expiration = 3600 * 24;
            }
            $data = $this->get_data($connection);
            set_transient($data_cache_key, $data, $expiration);
            set_transient($connection_cache_key, $serialized_connection, $expiration);
        }
        return $data;
    }

    public function get_data($connection) {

        if ($connection == null) {
            return null;
        }

        foreach ($this->get_default_settings() as $field => $value) {
            $connection->options->{$field} = isset($connection->options->{$field}) ? esc_attr($connection->options->{$field}) : $value;
        }
        $options = $connection->options;

        if (isset($connection->connections) && is_array($connection->connections)) {
            $google_business = null;
            $facebook_business = null;
            $yelp_business = null;
            foreach ($connection->connections as $conn) {
                switch ($conn->platform) {
                    case 'google':
                        if (!$google_business) $google_business = array();
                        array_push($google_business, $conn);
                        break;
                    case 'facebook':
                        if (!$facebook_business) $facebook_business = array();
                        array_push($facebook_business, $conn);
                        break;
                    case 'yelp':
                        if (!$yelp_business) $yelp_business = array();
                        array_push($yelp_business, $conn);
                        break;
                }
            }
        } else {
            $google_business     = isset($connection->google)   ? $connection->google   : null;
            $facebook_business   = isset($connection->facebook) ? $connection->facebook : null;
            $yelp_business       = isset($connection->yelp)     ? $connection->yelp     : null;
        }

        $header_merge_social = $options->header_merge_social;
        $header_hide_social  = $options->header_hide_social;

        $google_biz          = array();
        $google_reviews      = array();

        $facebook_biz        = array();
        $facebook_reviews    = array();

        $yelp_biz            = array();
        $yelp_reviews        = array();

        if ($google_business != null) {
            $schedule_step = 60 * 60 * 12;
            foreach ($google_business as $biz) {
                $google_api_limit = isset($options->google_api_limit) && strlen($options->google_api_limit) > 0 ? $options->google_api_limit : '100';
                $review_count_manual = isset($biz->review_count) ? $biz->review_count : null;
                $result = $this->get_google_reviews($biz, $review_count_manual);
                array_push($google_biz, $result['business']);
                $google_reviews = array_merge($google_reviews, $result['reviews']);

                if (isset($biz->refresh) && $biz->refresh) {
                    $args = array($biz->id, $biz->lang);
                    $schedule_cache_key = 'trp_google_refresh_' . join('_', $args);
                    if (get_transient($schedule_cache_key) === false) {
                        wp_schedule_single_event(time() + $schedule_step, 'trp_google_refresh', array($args));
                        set_transient($schedule_cache_key, $schedule_cache_key, $schedule_step + 60 * 10);
                    }
                }
                $schedule_step = $schedule_step + 60 * 60 * 12;
            }
        }
        if ($facebook_business != null) {
            $fb_api_limit = strlen($options->fb_api_limit) > 0 ? $options->fb_api_limit : '100';
            foreach ($facebook_business as $biz) {
                $access_token = isset($biz->props) && isset($biz->props->access_token) ? $biz->props->access_token : $biz->access_token;
                $result = $this->get_facebook_reviews($biz, $access_token, $options->fb_success_api, $options->fb_rating_calc, $options->reviewer_avatar_size, $fb_api_limit);
                if ($result['business'] != null) {
                    array_push($facebook_biz, $result['business']);
                }
                if ($result['reviews'] != null) {
                    $facebook_reviews = array_merge($facebook_reviews, $result['reviews']);
                }
            }
        }
        if ($yelp_business != null) {
            $schedule_step = 60 * 60 * 12;
            foreach ($yelp_business as $biz) {
                $result = $this->get_yelp_reviews($biz);
                array_push($yelp_biz, $result['business']);
                $yelp_reviews = array_merge($yelp_reviews, $result['reviews']);

                if (isset($biz->refresh) && $biz->refresh) {
                    $args = array($biz->id, $biz->lang);
                    $schedule_cache_key = 'trp_yelp_refresh_' . join('_', $args);
                    if (get_transient($schedule_cache_key) === false) {
                        wp_schedule_single_event(time() + $schedule_step, 'trp_yelp_refresh', array($args));
                        set_transient($schedule_cache_key, $schedule_cache_key, $schedule_step + 60 * 10);
                    }
                }
                $schedule_step = $schedule_step + 60 * 60 * 12;
            }
        }

        $social_biz = array();
        if ($header_merge_social) {
            if (count($google_biz) > 0) {
                array_push($social_biz, $this->merge_biz($google_biz));
            }
            if (count($facebook_biz) > 0) {
                array_push($social_biz, $this->merge_biz($facebook_biz));
            }
            if (count($yelp_biz) > 0) {
                array_push($social_biz, $this->merge_biz($yelp_biz));
            }
        } else {
            $social_biz = array_merge($google_biz, $facebook_biz, $yelp_biz);
        }

        $businesses = array();
        if (!$header_hide_social) {
            $businesses = $social_biz;
        }

        if ($options->summary_rating && count($social_biz) > 0) {
            $first_biz = $social_biz[0];
            $summary_name  = isset($options->summary_name)  && strlen($options->summary_name)  > 0 ? $options->summary_name  : $first_biz->name;
            $summary_url   = isset($options->summary_url)   && strlen($options->summary_url)   > 0 ? $options->summary_url   : $first_biz->url;
            $summary_photo = isset($options->summary_photo) && strlen($options->summary_photo) > 0 ? $options->summary_photo : $first_biz->photo;
            array_unshift($businesses, $this->merge_biz($social_biz, 'summary', $summary_name, $summary_url, $summary_photo, 'summary'));
        }

        $reviews = array();
        if (!$options->hide_reviews) {

            $revs = array();
            if (count($google_reviews) > 0) {
                array_push($revs, $google_reviews);
            }
            if (count($facebook_reviews) > 0) {
                array_push($revs, $facebook_reviews);
            }
            if (count($yelp_reviews) > 0) {
                array_push($revs, $yelp_reviews);
            }

            // Sorting
            while (count($revs) > 0) {
                foreach ($revs as $i => $value) {
                    $review = array_shift($revs[$i]);
                    array_push($reviews, $review);
                    if (count($revs[$i]) < 1) {
                        unset($revs[$i]);
                    }
                }
            }

            // Normalize reviews array indexes after unset filter above
            $reviews = array_values($reviews);

            // Trim reviews limit
            if ($options->reviews_limit > 0) {
                $reviews = array_slice($reviews, 0, $options->reviews_limit);
            }
        }

        return array('businesses' => $businesses, 'reviews' => $reviews, 'options' => $options);
    }

    public static function get_default_settings() {
        return array(
            'view_mode'                 => 'list',
            'pagination'                => '10',
            'min_letter'                => '',
            'text_size'                 => '',
            'disable_user_link'         => false,
            'hide_reviews'              => false,

            'summary_rating'            => false,
            'summary_photo'             => '',
            'summary_name'              => '',
            'summary_url'               => '',

            'header_hide_photo'         => false,
            'header_hide_name'          => false,
            'header_hide_count'         => false,
            'header_merge_social'       => false,
            'header_hide_social'        => false,

            'dark_theme'                => false,
            'centred'                   => false,
            'max_width'                 => '',
            'max_height'                => '',

            'open_link'                 => true,
            'nofollow_link'             => true,
            'lazy_load_img'             => true,
            'google_success_api'        => true,
            'google_def_rev_link'       => false,
            'fb_success_api'            => true,
            'fb_rating_calc'            => false,
            'reviewer_avatar_size'      => 56,
            'fb_api_limit'              => 100,
            'reviews_limit'             => '',
            'cache'                     => 12,
        );
    }

    public function get_google_reviews($google_biz, $review_count_manual) {
        global $wpdb;

        $google_place = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::BUSINESS_TABLE . " WHERE place_id = %s AND platform = %s", $google_biz->id, 'google')
        );

        if (strlen($google_biz->lang) > 0) {
            $google_reviews = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE business_id = %d AND language = %s ORDER BY time DESC, rating DESC", $google_place->id, $google_biz->lang)
            );
        } else {
            $google_reviews = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE business_id = %d ORDER BY time DESC, rating DESC", $google_place->id)
            );
        }

        if (isset($google_place->review_count) && $google_place->review_count > 0) {
            $review_count = $google_place->review_count;
        } else {
            $review_count = $wpdb->get_var(
                $wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE business_id = %d", $google_place->id)
            );
        }

        $google_place->photo = strlen($google_biz->photo) > 0 ?
            $google_biz->photo : (strlen($google_place->photo) > 0 ? $google_place->photo : $google_place->icon);

        $rating = 0;
        if ($google_place->rating > 0) {
            $rating = $google_place->rating;
        } elseif ($review_count > 0) {
            foreach ($google_reviews as $google_review) {
                $rating = $rating + $google_review->rating;
            }
            $rating = round($rating / $review_count, 1);
        }
        $rating = number_format((float)$rating, 1, '.', '');

        $business = json_decode(json_encode(
            array(
                'id'                  => $google_biz->id,
                'name'                => $google_biz->name ? $google_biz->name : $google_place->name,
                'url'                 => $google_place->url,
                'photo'               => $google_place->photo,
                'address'             => $google_place->address,
                'rating'              => $rating,
                'review_count'        => $review_count,
                'review_count_manual' => $review_count_manual,
                'provider'            => 'google'
            )
        ));

        $reviews = array();
        foreach ($google_reviews as $rev) {
            $review = json_decode(json_encode(
                array(
                    'biz_id'        => $google_biz->id,
                    'rating'        => $rev->rating,
                    'text'          => wp_encode_emoji($rev->text),
                    'author_avatar' => $rev->author_img,
                    'author_url'    => $rev->author_url,
                    'author_name'   => $rev->author_name,
                    'time'          => $rev->time,
                    'provider'      => 'google',
                )
            ));
            array_push($reviews, $review);
        }

        return array('business' => $business, 'reviews' => $reviews);
    }

    public function get_facebook_reviews($facebook_biz, $page_access_token, $fb_success_api, $fb_rating_calc, $reviewer_avatar_size, $fb_api_limit) {
        $business = null;
        $reviews = array();

        $facebook_api_url = TRP_FACEBOOK_API . $facebook_biz->id . "?access_token=" . $page_access_token . "&fields=ratings.fields(reviewer{id,name,picture.width(" . $reviewer_avatar_size . ").height(" . $reviewer_avatar_size . ")},created_time,rating,recommendation_type,review_text,open_graph_story{id}).limit(" . $fb_api_limit . "),overall_star_rating,rating_count";

        $fb_res = wp_remote_get($facebook_api_url);
        $fb_body = wp_remote_retrieve_body($fb_res);
        $fb_json = json_decode($fb_body);

        if ($fb_success_api) {
            $cache_key_success = 'trp_fb_success_' . $facebook_biz->id;
            if (isset($fb_json->ratings)) {
                set_transient($cache_key_success, $fb_body, 0);
            } else {
                $fb_success_body = get_transient($cache_key_success);
                if ($fb_success_body !== false) {
                    $fb_json = json_decode($fb_success_body);
                }
            }
        }

        $facebook_rating = 0;
        $facebook_count = 0;

        if (isset($fb_json->ratings) && isset($fb_json->ratings->data)) {
            $facebook_reviews = $fb_json->ratings->data;
            $facebook_count = count($facebook_reviews);
            if ($facebook_count > 0) {
                foreach ($facebook_reviews as $facebook_review) {
                    $facebook_review_rating = $this->get_facebook_review_rating($facebook_review);
                    $facebook_rating = $facebook_rating + $facebook_review_rating;
                    $review = json_decode(json_encode(
                        array(
                            'biz_id'        => $facebook_biz->id,
                            'rating'        => $facebook_review_rating,
                            'text'          => isset($facebook_review->review_text) ?
                                                   wp_encode_emoji(str_replace("\n", '<br>', $facebook_review->review_text)) : '',
                            'author_avatar' => isset($facebook_review->reviewer->picture) ?
                                                   $facebook_review->reviewer->picture->data->url : TRP_FACEBOOK_AVATAR,
                            'author_url'    => 'https://facebook.com/' .
                                               (isset($facebook_review->open_graph_story) ?
                                                   $facebook_review->open_graph_story->id : $facebook_biz->id . '/reviews'),
                            'author_name'   => $facebook_review->reviewer->name,
                            'time'          => strtotime($facebook_review->created_time),
                            'provider'      => 'facebook',
                        )
                    ));
                    array_push($reviews, $review);
                }
                $facebook_rating = round($facebook_rating / $facebook_count, 1);
                $facebook_rating = number_format((float)$facebook_rating, 1, '.', '');
            }
        }

        if (isset($fb_json->overall_star_rating) && !$fb_rating_calc) {
            $facebook_rating = number_format((float)$fb_json->overall_star_rating, 1, '.', '');
        }
        if (isset($fb_json->rating_count) && $fb_json->rating_count > 0) {
            $facebook_count = $fb_json->rating_count;
        }

        $business = json_decode(json_encode(
            array(
                'id'           => $facebook_biz->id,
                'name'         => $facebook_biz->name,
                'photo'        => strlen($facebook_biz->photo) > 0 ?
                                  $facebook_biz->photo : 'https://graph.facebook.com/' . $facebook_biz->id . '/picture',
                'url'          => 'https://fb.com/' . $facebook_biz->id,
                'rating'       => $facebook_rating,
                'review_count' => $facebook_count,
                'provider'     => 'facebook'
            )
        ));

        return array('business' => $business, 'reviews' => $reviews);
    }

    public function get_facebook_review_rating($review) {
        if (isset($review->rating)) {
            return $review->rating;
        } elseif (isset($review->recommendation_type)) {
            return ($review->recommendation_type == 'negative' ? 1 : 5);
        } else {
            return 5;
        }
    }

    public function get_yelp_reviews($yelp_biz) {
        global $wpdb;

        $yelp_business = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::BUSINESS_TABLE . " WHERE place_id = %s AND platform = %s", $yelp_biz->id, 'yelp')
        );

        if (strlen($yelp_biz->lang) > 0) {
            $yelp_reviews = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE business_id = %d AND language = %s ORDER BY time_str DESC, rating DESC", $yelp_business->id, $yelp_biz->lang)
            );
        } else {
            $yelp_reviews = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE . " WHERE business_id = %d ORDER BY time_str DESC, rating DESC", $yelp_business->id)
            );
        }

        $business = json_decode(json_encode(
            array(
                'id'           => $yelp_biz->id,
                'name'         => $yelp_biz->name ? $yelp_biz->name : $yelp_business->name,
                'url'          => $yelp_business->url,
                'photo'        => isset($yelp_biz->photo) && strlen($yelp_biz->photo) > 0 ? $yelp_biz->photo : $yelp_business->photo,
                'address'      => $yelp_business->address,
                'rating'       => number_format((float)$yelp_business->rating, 1, '.', ''),
                'review_count' => $yelp_business->review_count,
                'provider'     => 'yelp'
            )
        ));

        $reviews = array();
        foreach ($yelp_reviews as $yelp_review) {
            $author_img = strlen($yelp_review->author_img) > 0 ? str_replace('o.jpg', 'ms.jpg', $yelp_review->author_img) : TRP_YELP_AVATAR;
            $review = json_decode(json_encode(
                array(
                    'biz_id'        => $yelp_biz->id,
                    'rating'        => $yelp_review->rating,
                    'text'          => wp_encode_emoji($yelp_review->text),
                    'author_avatar' => $author_img,
                    'author_url'    => $yelp_review->url,
                    'author_name'   => $yelp_review->author_name,
                    'time'          => strtotime($yelp_review->time_str),
                    'provider'      => 'yelp',
                )
            ));
            array_push($reviews, $review);
        }

        return array('business' => $business, 'reviews' => $reviews);
    }

    private function merge_biz($businesses, $id = '', $name = '', $url = '', $photo = '', $provider = '') {
        $count = 0;
        $rating = 0;
        $review_count = array();
        $review_count_manual = array();
        $business_platform = array();
        $biz_merge = null;
        foreach ($businesses as $business) {
            if ($business->rating < 1) {
                continue;
            }

            $count++;
            $rating += $business->rating;

            if (isset($business->review_count_manual) && $business->review_count_manual > 0) {
                $review_count_manual[$business->id] = $business->review_count_manual;
            } else {
                $review_count[$business->id] = $business->review_count;
            }

            array_push($business_platform, $business->provider);

            if ($biz_merge == null) {
                $biz_merge = json_decode(json_encode(
                    array(
                        'id'           => strlen($id)       > 0 ? $id       : $business->id,
                        'name'         => strlen($name)     > 0 ? $name     : $business->name,
                        'url'          => strlen($url)      > 0 ? $url      : $business->url,
                        'photo'        => strlen($photo)    > 0 ? $photo    : $business->photo,
                        'provider'     => strlen($provider) > 0 ? $provider : $business->provider,
                        'review_count' => 0,
                    )
                ));
            }
            $rating_tmp = round($rating / $count, 1);
            $rating_tmp = number_format((float)$rating_tmp, 1, '.', '');
            $biz_merge->rating = $rating_tmp;
        }
        $review_count = array_merge($review_count, $review_count_manual);
        foreach ($review_count as $id => $count) {
            $biz_merge->review_count += $count;
        }
        $biz_merge->platform = array_unique($business_platform);
        return $biz_merge;
    }

}