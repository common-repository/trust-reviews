<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class View {

    public function render($feed_id, $businesses, $reviews, $options) {
        ob_start();

        $options->schema_rating = false;
        $options->header_hide_seeall = true;
        $options->header_hide_write  = true;
        $options->hide_avatar = false;
        $options->hide_name  = false;
        $options->short_last_name = false;
        $options->disable_review_time  = false;

        $max_width = $options->max_width;
        if (is_numeric($max_width)) {
            $max_width = $max_width . 'px';
        }

        $max_height = $options->max_height;
        if (is_numeric($max_height)) {
            $max_height = $max_height . 'px';
        }

        ?>
        <div class="trp"<?php if (strlen($options->schema_rating) > 0) { ?> itemscope="" itemtype="http://schema.org/LocalBusiness"<?php } ?> style="<?php if (strlen($max_width) > 0) { ?>width:<?php echo $max_width;?>!important;<?php } ?><?php if (strlen($max_height) > 0) { ?>height:<?php echo $max_height;?>!important;overflow-y:auto!important;<?php } ?><?php if ($options->centred) { ?>margin:0 auto!important;<?php } ?>" data-id="<?php echo $feed_id; ?>">

        <svg style="display:none">
            <defs>
                <g id="star" width="17" height="17">
                    <path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"></path>
                </g>
                <g id="star-half" width="17" height="17">
                    <path d="M1250 957l257-250-356-52-66-10-30-60-159-322v963l59 31 318 168-60-355-12-66zm452-262l-363 354 86 500q5 33-6 51.5t-34 18.5q-17 0-40-12l-449-236-449 236q-23 12-40 12-23 0-34-18.5t-6-51.5l86-500-364-354q-32-32-23-59.5t54-34.5l502-73 225-455q20-41 49-41 28 0 49 41l225 455 502 73q45 7 54 34.5t-24 59.5z"></path>
                </g>
                <g id="star-o" width="17" height="17">
                    <path d="M1201 1004l306-297-422-62-189-382-189 382-422 62 306 297-73 421 378-199 377 199zm527-357q0 22-26 48l-363 354 86 500q1 7 1 20 0 50-41 50-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z" fill="#ccc"></path>
                </g>
                <g id="logo-g" height="44" width="44" fill="none" fill-rule="evenodd">
                    <path d="M482.56 261.36c0-16.73-1.5-32.83-4.29-48.27H256v91.29h127.01c-5.47 29.5-22.1 54.49-47.09 71.23v59.21h76.27c44.63-41.09 70.37-101.59 70.37-173.46z" fill="#4285f4"></path><path d="M256 492c63.72 0 117.14-21.13 156.19-57.18l-76.27-59.21c-21.13 14.16-48.17 22.53-79.92 22.53-61.47 0-113.49-41.51-132.05-97.3H45.1v61.15c38.83 77.13 118.64 130.01 210.9 130.01z" fill="#34a853"></path><path d="M123.95 300.84c-4.72-14.16-7.4-29.29-7.4-44.84s2.68-30.68 7.4-44.84V150.01H45.1C29.12 181.87 20 217.92 20 256c0 38.08 9.12 74.13 25.1 105.99l78.85-61.15z" fill="#fbbc05"></path><path d="M256 113.86c34.65 0 65.76 11.91 90.22 35.29l67.69-67.69C373.03 43.39 319.61 20 256 20c-92.25 0-172.07 52.89-210.9 130.01l78.85 61.15c18.56-55.78 70.59-97.3 132.05-97.3z" fill="#ea4335"></path><path d="M20 20h472v472H20V20z"></path>
                </g>
                <g id="logo-f" width="30" height="30" transform="translate(23,85) scale(0.05,-0.05)">
                    <path fill="#fff" d="M959 1524v-264h-157q-86 0 -116 -36t-30 -108v-189h293l-39 -296h-254v-759h-306v759h-255v296h255v218q0 186 104 288.5t277 102.5q147 0 228 -12z"></path>
                </g>
                <g id="logo-y" x="0px" y="0px" width="44" height="44" style="enable-background:new 0 0 533.33 533.33;" xml:space="preserve">
                    <path d="M317.119,340.347c-9.001,9.076-1.39,25.586-1.39,25.586l67.757,113.135c0,0,11.124,14.915,20.762,14.915   c9.683,0,19.246-7.952,19.246-7.952l53.567-76.567c0,0,5.395-9.658,5.52-18.12c0.193-12.034-17.947-15.33-17.947-15.33   l-126.816-40.726C337.815,335.292,325.39,331.994,317.119,340.347z M310.69,283.325c6.489,11.004,24.389,7.798,24.389,7.798   l126.532-36.982c0,0,17.242-7.014,19.704-16.363c2.415-9.352-2.845-20.637-2.845-20.637l-60.468-71.225   c0,0-5.24-9.006-16.113-9.912c-11.989-1.021-19.366,13.489-19.366,13.489l-71.494,112.505   C311.029,261.999,304.709,273.203,310.69,283.325z M250.91,239.461c14.9-3.668,17.265-25.314,17.265-25.314l-1.013-180.14   c0,0-2.247-22.222-12.232-28.246c-15.661-9.501-20.303-4.541-24.79-3.876l-105.05,39.033c0,0-10.288,3.404-15.646,11.988   c-7.651,12.163,7.775,29.972,7.775,29.972l109.189,148.831C226.407,231.708,237.184,242.852,250.91,239.461z M224.967,312.363   c0.376-13.894-16.682-22.239-16.682-22.239L95.37,233.079c0,0-16.732-6.899-24.855-2.091c-6.224,3.677-11.738,10.333-12.277,16.216   l-7.354,90.528c0,0-1.103,15.685,2.963,22.821c5.758,10.128,24.703,3.074,24.703,3.074L210.37,334.49   C215.491,331.048,224.471,330.739,224.967,312.363z M257.746,361.219c-11.315-5.811-24.856,6.224-24.856,6.224l-88.265,97.17   c0,0-11.012,14.858-8.212,23.982c2.639,8.552,7.007,12.802,13.187,15.797l88.642,27.982c0,0,10.747,2.231,18.884-0.127   c11.552-3.349,9.424-21.433,9.424-21.433l2.003-131.563C268.552,379.253,268.101,366.579,257.746,361.219z" fill="#D80027"/>
                </g>
                <g id="dots" fill="none" fill-rule="evenodd" width="12" height="12">
                    <circle cx="6" cy="3" r="1" fill="#000"/>
                    <circle cx="6" cy="6" r="1" fill="#000"/>
                    <circle cx="6" cy="9" r="1" fill="#000"/>
                </g>
            </defs>
        </svg>

        <?php
            switch ($options->view_mode) {
                case 'list':
                    $this->render_list($businesses, $reviews, $options);
                    break;
                 case 'list_thin':
                    $this->render_list_thin($businesses, $reviews, $options);
                    break;
                case 'grid4':
                    $this->render_grid($businesses, $reviews, $options, 4);
                    break;
                case 'grid3':
                    $this->render_grid($businesses, $reviews, $options, 3);
                    break;
                case 'grid2':
                    $this->render_grid($businesses, $reviews, $options, 2);
                    break;
                case 'slider':
                    $this->render_slider($businesses, $reviews, $options);
                    break;
                case 'temp':
                    $this->rating_temp($businesses, $reviews, $options);
                    break;
                default:
                    $this->render_badge2($businesses, $reviews, $options);
            }
        ?>
        </div>
        <?php
        return preg_replace('/[\n\r]|(>)\s+(<)/', '$1$2', ob_get_clean());
    }

    private function render_list($businesses, $reviews, $options) {
        ?>
        <div class="trp-list<?php if ($options->dark_theme) { ?> trp-dark<?php } ?>">
            <div class="trp-businesses">
                <?php
                foreach ($businesses as $business) {
                    $this->business_thin($business, $options);
                }
                ?>
            </div>
            <?php if (count($businesses) > 0) { ?><div class="trp-hr2"></div><?php } ?>
            <div class="trp-reviews">
                <?php
                $hide_review = false;
                if (count($reviews) > 0) {
                    $i = 0;
                    foreach ($reviews as $review) {
                        if ($options->pagination > 0 && $options->pagination <= $i++) {
                            $hide_review = true;
                        }
                        $this->review_thin(
                            $review,
                            $options->hide_avatar,
                            $options->text_size,
                            $options->disable_user_link,
                            $options->hide_name,
                            $options->short_last_name,
                            $options->disable_review_time,
                            $options->open_link,
                            $options->nofollow_link,
                            $options->reviewer_avatar_size,
                            $options->lazy_load_img,
                            true,
                            $hide_review
                        );
                    }
                }
                ?>
            </div>
            <?php
            if ($options->pagination > 0 && $hide_review) {
                $this->anchor('#', 'trp-url', __('Next Reviews', 'trp'), false, false, 'return trp_next_reviews.call(this, ' . $options->pagination . ');');
            }
            ?>
        </div>
        <?php
        $this->js_loader('trp_init_list_theme');
    }

    private function business_thin($business, $options) {
        $hide_photo    = $options->header_hide_photo;
        $hide_name     = $options->header_hide_name;
        $hide_count    = $options->header_hide_count;
        $open_link     = $options->open_link;
        $nofollow_link = $options->nofollow_link;
        $lazy_load_img = $options->lazy_load_img;

        $business_name = $business->name;
        $business_photo = '';
        if ($options->schema_rating && $options->schema_rating == $business->id) {
            $business_name = '<span itemprop="name">' . $business->name . '</span>';
            $business_photo = '<meta itemprop="image" content="' . ($this->correct_url_proto($business->photo)) . '" name="' . $business->name . '"/>';
        }
        ?>
        <div class="trp-list-header">
            <div class="trp-row trp-row-start">
                <?php if (!$hide_photo) { ?>
                <div class="trp-row-left">
                    <?php $this->image($business->photo, $business->name, $lazy_load_img); echo $business_photo; ?>
                    <span class="trp-review-badge"><?php $this->social_logo($business->provider); ?></span>
                </div>
                <?php } ?>
                <div class="trp-row-right">
                    <?php if (!$hide_name) { ?>
                    <div class="trp-biz-name trp-trim">
                        <?php $this->anchor($business->url, '', $business_name, $open_link, $nofollow_link); ?>
                    </div>
                    <?php
                    }
                    $this->render_rating($business, $options);
                    $this->render_action_links($business, $options);
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function render_rating($business, $options, $reviews_count = true) {
        $aggregate_rating = '';
        $rating_value = '';
        if ($business->rating > 0) {
        ?>
        <div <?php echo $aggregate_rating; ?>>
            <div class="trp-biz-rating trp-trim trp-biz-<?php echo $business->provider; ?>">
                <div class="trp-biz-score" <?php echo $rating_value; ?>><?php echo $business->rating; ?></div>
                <?php $this->stars($business->rating, $business->provider, '#0caa41'); ?>
            </div>
            <?php
            if (!$options->header_hide_count && $reviews_count) {
                $this->render_based_on_reviews($business);
            }
            ?>
        </div>
        <?php
        } else {
        ?>
        <div>
            <div class="trp-biz-rating trp-trim trp-biz-<?php echo $business->provider; ?>">
                <?php $this->stars($business->rating, $business->provider, '#0caa41'); ?>
            </div>
        </div>
        <?php
        }
    }

    private function render_based_on_reviews($business) {
        $review_count = isset($business->review_count_manual) && $business->review_count_manual > 0
            ? $business->review_count_manual : $business->review_count;
        ?>
        <div class="trp-biz-based trp-trim">
            <span class="trp-biz-based-text"><?php printf(esc_html__('Based on %s reviews', 'trp'), $review_count); ?></span>
        </div>
        <?php
    }

    private function render_action_links($business, $options, $in_menu = false) {
        if ($business->provider != 'summary') {
        ?><div class="trp-links"><?php
            if (!$options->header_hide_seeall) {
                $this->get_allreview_link($business, $options->google_def_rev_link, $in_menu);
            }
            if (!$options->header_hide_write) {
                $this->get_writereview_link($business, $in_menu);
            }
        ?></div><?php
        }
    }

    private function get_allreview_link($business, $google_def_rev_link, $in_menu = false) {
        ?><a href="<?php echo $this->get_allreview_url($business, $google_def_rev_link); ?>" target="_blank" rel="noopener" onclick="<?php if ($in_menu) { ?>this.parentNode.parentNode.style.display='none';<?php } ?>return true;"><?php echo __('See all reviews', 'trp'); ?></a><?php
    }

    private function get_allreview_url($business, $google_def_rev_link) {
        switch ($business->provider) {
            case 'google':
                return $google_def_rev_link ? $business->url : 'https://search.google.com/local/reviews?placeid=' . $business->id;
            case 'facebook':
                return 'https://facebook.com/' . $business->id . '/reviews';
            case 'yelp':
                return $business->url;
        }
    }

    private function get_writereview_link($business, $in_menu = false) {
        ?><a href="javascript:void(0)" onclick="<?php if ($in_menu) { ?>this.parentNode.parentNode.style.display='none';<?php } ?>_trp_popup('<?php echo $this->get_writereview_url($business); ?>', 800, 600)"><?php echo __('Write a review', 'trp'); ?></a><?php
    }

    private function get_writereview_url($business) {
        switch ($business->provider) {
            case 'google':
                return 'https://search.google.com/local/writereview?placeid=' . $business->id;
            case 'facebook':
                return 'https://facebook.com/' . $business->id . '/reviews';
            case 'yelp':
                return 'https://www.yelp.com/writeareview/biz/' . $business->id;
        }
    }

    private function review_thin($review, $hide_avatar, $text_size, $disable_user_link, $hide_name, $short_last_name, $disable_review_time, $open_link, $nofollow_link, $reviewer_avatar_size, $lazy_load_img, $stars_in_body=false, $hide_review=false) {
        ?>
        <div class="trp-list-review<?php if ($hide_review) { ?> trp-hide<?php } ?>">
            <div class="trp-row trp-row-start">
                <?php if (!$hide_avatar) { ?>
                <div class="trp-row-left">
                    <?php $this->author_avatar($review, $short_last_name, $reviewer_avatar_size, $lazy_load_img); ?>
                    <span class="trp-review-badge"><?php $this->social_logo($review->provider); ?></span>
                </div>
                <?php } ?>
                <div class="trp-row-right">
                    <?php
                    $this->author_name($review, $disable_user_link, $hide_name, $short_last_name, $open_link, $nofollow_link);
                    if (!$stars_in_body) {
                        $this->stars($review->rating, $review->provider);
                    }
                    $this->review_time($review, $disable_review_time);
                    ?>
                    <?php if ($stars_in_body) {
                        $this->stars($review->rating, $review->provider);
                    } ?>
                    <span class="trp-review-text"><?php if (isset($review->text)) { $this->trim_text($review->text, $text_size); } ?></span>
                </div>
            </div>
        </div>
        <?php
    }

    private function author_avatar($review, $short_last_name, $reviewer_avatar_size, $lazy_load_img, $img_width='56', $img_height='56') {
        switch ($review->provider) {
            case 'google':
                $regexp = '/googleusercontent\.com\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)\/photo\.jpg/';
                $matches = array();
                preg_match($regexp, $review->author_avatar, $matches, PREG_OFFSET_CAPTURE);
                if (count($matches) > 4 && $matches[3][0] == 'AAAAAAAAAAA') {
                    $review->author_avatar = str_replace('/photo.jpg', '/s128-c0x00000000-cc-rp-mo/photo.jpg', $review->author_avatar);
                }
                if (strlen($review->author_avatar) > 0) {
                    if (strpos($review->author_avatar, "s128") != false) {
                        $review->author_avatar = str_replace('s128', 's' . $reviewer_avatar_size, $review->author_avatar);
                    } elseif (strpos($review->author_avatar, "-mo") != false) {
                        $review->author_avatar = str_replace('-mo', '-mo-s' . $reviewer_avatar_size, $review->author_avatar);
                    } else {
                        $review->author_avatar = str_replace('-rp', '-rp-s' . $reviewer_avatar_size, $review->author_avatar);
                    }
                }
                $default_avatar = TRP_GOOGLE_AVATAR;
                break;
            case 'facebook':
                $default_avatar = TRP_FACEBOOK_AVATAR;
                break;
            case 'yelp':
                if (strlen($review->author_avatar) > 0) {
                    $avatar_size = '';
                    if ($reviewer_avatar_size <= 128) {
                        $avatar_size = 'ms';
                    } else {
                        $avatar_size = 'o';
                    }
                    $review->author_avatar = str_replace('ms.jpg', $avatar_size . '.jpg', $review->author_avatar);
                }
                $default_avatar = TRP_YELP_AVATAR;
                break;
        }
        $author_avatar = strlen($review->author_avatar) > 0 ? $review->author_avatar : $default_avatar;
        $author_name = $short_last_name ? $this->get_short_last_name($review->author_name) : $review->author_name;
        $this->image($author_avatar, $author_name, $lazy_load_img, $img_width, $img_height, $default_avatar);
    }

    private function author_name($review, $disable_user_link, $hide_name, $short_last_name, $open_link, $nofollow_link) {
        if ($hide_name) {
            return;
        }

        if ($this->_strlen($review->author_name) > 0) {
            $author_name = $short_last_name ? $this->get_short_last_name($review->author_name) : $review->author_name;
        } else {
            $author_name = __(ucfirst($provider) . ' User', 'trp');
        }

        if (strlen($review->author_url) > 0 && !$disable_user_link) {
            $this->anchor($review->author_url, 'trp-review-name trp-trim', $author_name, $open_link, $nofollow_link, '', $author_name);
        } else {

            echo '<div class="trp-review-name trp-trim" title="' . $author_name . '">' . $author_name . '</div>';
        }
    }

    private function review_time($review, $disable_review_time) {
        if (!$disable_review_time) {
            ?><div class="trp-review-time trp-trim" data-time="<?php echo $review->time; ?>"><?php echo gmdate("H:i d M y", $review->time); ?></div><?php
        }
    }

    private function stars($rating, $provider = '', $color = '#777') {
        ?><div class="trp-stars"><?php
        switch ($provider) {
            case 'google':
                $this->stars_simple($rating, '#e7711b');
                break;
            case 'facebook':
                $this->stars_simple($rating, '#3c5b9b');
                break;
            case 'yelp':
                $this->stars_yelp($rating);
                break;
             default:
                $this->stars_simple($rating, $color);
        }
        ?></div><?php
    }

    private function stars_simple($rating, $color) {
        foreach (array(1,2,3,4,5) as $val) {
            $score = $rating - $val;
            if ($score >= 0) {
                ?><svg viewBox="0 0 1792 1792" width="17" height="17"><use xlink:href="#star" fill="<?php echo $color; ?>"/></svg><?php
            } elseif ($score > -1 && $score < 0) {
                if ($score < -0.75) {
                    ?><svg viewBox="0 0 1792 1792" width="17" height="17"><use xlink:href="#star-o"/></svg><?php
                } elseif ($score > -0.25) {
                    ?><svg viewBox="0 0 1792 1792" width="17" height="17"><use xlink:href="#star" fill="<?php echo $color; ?>"/></svg><?php
                } else {
                    ?><svg viewBox="0 0 1792 1792" width="17" height="17"><use xlink:href="#star-half" fill="<?php echo $color; ?>"/></svg><?php
                }
            } else {
                ?><svg viewBox="0 0 1792 1792" width="17" height="17"><use xlink:href="#star-o"/></svg><?php
            }
        }
    }

    private function stars_yelp($rating) {
        $rating = round($rating * 2) / 2;
        ?><svg class="yrw-rating yrw-rating-<?php echo $rating * 10; ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 865 145" width="865" height="145"><path class="yrw-stars-1f" d="M110.6 0h-76.9c-18.6 0-33.7 15.1-33.7 33.7v76.9c0 18.6 15.1 33.7 33.7 33.7h76.9c18.6 0 33.7-15.1 33.7-33.7v-76.9c0-18.6-15.1-33.7-33.7-33.7z"/><path class="yrw-stars-0h" d="M33.3,0.3C14.7,0.3-0.4,15.4-0.4,34V111c0,18.6,15.1,33.7,33.7,33.7h38.3V0.3H33.3z"/><path class="yrw-stars-2f" d="M290.6 0h-76.9c-18.6 0-33.7 15.1-33.7 33.7v76.9c0 18.6 15.1 33.7 33.7 33.7h76.9c18.6 0 33.7-15.1 33.7-33.7v-76.9c0-18.6-15.1-33.7-33.7-33.7z"/><path class="yrw-stars-1h" d="M214,0.3c-18.6,0-33.7,15.1-33.7,33.7v77c0,18.6,15.1,33.7,33.7,33.7h38.3V0.3H214z"/><path class="yrw-stars-3f" d="M470.4 0h-76.9c-18.6 0-33.7 15.1-33.7 33.7v76.9c0 18.6 15.1 33.7 33.7 33.7h76.9c18.6 0 33.7-15.1 33.7-33.7v-76.9c.1-18.6-15.1-33.7-33.7-33.7z"/><path class="yrw-stars-2h" d="M393.9,0.6c-18.6,0-33.7,15.1-33.7,33.7v77c0,18.6,15.1,33.7,33.7,33.7h38.3V0.6H393.9z"/><path class="yrw-stars-4f" d="M650.6 0h-76.9c-18.6 0-33.7 15.1-33.7 33.7v76.9c0 18.6 15.1 33.7 33.7 33.7h76.9c18.6 0 33.7-15.1 33.7-33.7v-76.9c0-18.6-15.1-33.7-33.7-33.7z"/><path class="yrw-stars-3h" d="M573.9 0c-18.6 0-33.7 15.1-33.7 33.7v77c0 18.6 15.1 33.7 33.7 33.7h38.3v-144.4h-38.3z"/><path class="yrw-stars-5f" d="M830.6 0h-76.9c-18.6 0-33.7 15.1-33.7 33.7v76.9c0 18.6 15.1 33.7 33.7 33.7h76.9c18.6 0 33.7-15.1 33.7-33.7v-76.9c0-18.6-15.1-33.7-33.7-33.7z"/><path class="yrw-stars-4h" d="M753.8 0c-18.6 0-33.7 15.1-33.7 33.7v77c0 18.6 15.1 33.7 33.7 33.7h38.3v-144.4h-38.3z"/><path class="yrw-stars" fill="#FFF" stroke="#FFF" stroke-width="2" stroke-linejoin="round" d="M72 19.3l13.6 35.4 37.9 2-29.5 23.9 9.8 36.6-31.8-20.6-31.8 20.6 9.8-36.6-29.5-23.9 37.9-2zm180.2 0l13.6 35.4 37.8 2-29.4 23.9 9.8 36.6-31.8-20.6-31.9 20.6 9.8-36.6-29.4-23.9 37.8-2zm179.8 0l13.6 35.4 37.9 2-29.5 23.9 9.8 36.6-31.8-20.6-31.8 20.6 9.8-36.6-29.5-23.9 37.9-2zm180.2 0l13.6 35.4 37.8 2-29.4 23.9 9.8 36.6-31.8-20.6-31.9 20.6 9.8-36.6-29.4-23.9 37.8-2zm180 0l13.6 35.4 37.8 2-29.4 23.9 9.8 36.6-31.8-20.6-31.9 20.6 9.8-36.6-29.4-23.9 37.8-2z"/></svg><?php
    }

    private function social_logo($provider) {
        ?><span class="trp-social-logo trp-<?php echo $provider; ?>-logo"><?php
        switch ($provider) {
            case 'google':
                $this->google_logo();
                break;
            case 'facebook':
                $this->facebook_logo();
                break;
            case 'yelp':
                $this->yelp_logo2();
                break;
        }
        ?></span><?php
    }

    function google_logo() {
        ?><svg viewBox="0 0 512 512" width="44" height="44"><use xlink:href="#logo-g"/></svg><?php
    }

    function facebook_logo() {
        ?><svg viewBox="0 0 100 100" width="44" height="44"><use xlink:href="#logo-f"/></svg><?php
    }

    function yelp_logo() {
        ?><img src="<?php echo TRP_ASSETS_URL; ?>img/yelp-logo.png" alt="Yelp logo" width="60" height="31" title="Yelp logo"><?php
    }

    function yelp_logo2() {
        ?><svg viewBox="0 0 533.33 533.33" width="44" height="44"><use xlink:href="#logo-y"/></svg><?php
    }

    private function anchor($url, $class, $text, $open_link, $nofollow_link, $onclick = '', $title = '') {
        ?><a href="<?php echo $url; ?>" class="<?php echo $class; ?>" <?php if ($open_link) { ?>target="_blank" rel="noopener"<?php } ?> <?php if ($nofollow_link) { ?>rel="nofollow"<?php } ?> <?php if (strlen($onclick) > 0) { ?>onclick="<?php echo $onclick; ?>"<?php } ?> <?php if ($this->_strlen($title) > 0) { ?>title="<?php echo $title; ?>"<?php } ?>><?php echo $text; ?></a><?php
    }

    function image($src, $alt, $lazy, $width = '56', $height = '56', $def_ava = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', $atts = '') {
        ?><img <?php if ($lazy) { ?>src="<?php echo $def_ava; ?>" data-<?php } ?>src="<?php echo $src; ?>" class="trp-review-avatar<?php if ($lazy) { ?> trp-blazy<?php } ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" title="<?php echo $alt; ?>" onerror="if(this.src!='<?php echo $def_ava; ?>')this.src='<?php echo $def_ava; ?>';" <?php echo $atts; ?>><?php
    }

    private function js_loader($func, $data = '') {
        ?><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="" onload="(function(el, data) { var t = setInterval(function () { if (window.<?php echo $func; ?>){ <?php echo $func; ?>(el, data); clearInterval(t); } }, 200); })(this.parentNode<?php if (strlen($data) > 0) { ?>, <?php echo str_replace('"', '\'', $data); } ?>);this.setAttribute('data-exec','true');" data-exec="false" style="display:none"><?php
    }

    private function trim_text($text, $size) {
        if ($size > 0 && $this->_strlen($text) > $size) {
            $sub_text = $this->_substr($text, 0, $size);
            $idx = $this->_strrpos($sub_text, ' ') + 1;

            if ($idx < 1 || $size - $idx > ($size / 2)) {
                $idx = $size;
            }
            if ($idx > 0) {
                $visible_text = $this->_substr($text, 0, $idx - 1);
                $invisible_text = $this->_substr($text, $idx - 1, $this->_strlen($text));
            }
            echo $visible_text;
            if ($this->_strlen($invisible_text) > 0) {
                ?><span>... </span><span class="trp-more"><?php echo $invisible_text; ?></span><span class="trp-more-toggle"><?php echo __('read more', 'trp'); ?></span><?php
            }
        } else {
            echo $text;
        }
    }

    private function correct_url_proto($url){
        return substr($url, 0, 2) == '//' ? 'https:' . $url : $url;
    }

    private function get_short_last_name($author_name){
        $names = explode(" ", $author_name);
        if (count($names) > 1) {
            $last_index = count($names) - 1;
            $last_name = $names[$last_index];
            if ($this->_strlen($last_name) > 1) {
                $last_char = $this->_substr($last_name, 0, 1);
                $last_name = $this->_strtoupper($last_char) . ".";
                $names[$last_index] = $last_name;
                return implode(" ", $names);
            }
        }
        return $author_name;
    }

    private function _strlen($str) {
        return function_exists('mb_strlen') ? mb_strlen($str, 'UTF-8') : strlen($str);
    }

    private function _strrpos($haystack, $needle, $offset = 0) {
        return function_exists('mb_strrpos') ? mb_strrpos($haystack, $needle, $offset, 'UTF-8') : strrpos($haystack, $needle, $offset);
    }

    private function _substr($str, $start, $length = NULL) {
        return function_exists('mb_substr') ? mb_substr($str, $start, $length, 'UTF-8') : substr($str, $start, $length);
    }

    private function _strtoupper($str) {
        return function_exists('mb_strtoupper') ? mb_strtoupper($str, 'UTF-8') : strtoupper($str);
    }

}
