<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Post_Types {

    public function register() {
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types() {
        $this->register_feed_post_type();
    }

    public function register_feed_post_type() {
        $labels = array(
            'name'                  => _x('Reviews Feeds', 'Post Type General Name', 'trust-reviews'),
            'singular_name'         => _x('Reviews Feed', 'Post Type Singular Name', 'trust-reviews'),
            'menu_name'             => __('Reviews Feeds', 'trust-reviews'),
            'name_admin_bar'        => __('Reviews Feed', 'trust-reviews'),
            'archives'              => __('Reviews Feed Archives', 'trust-reviews'),
            'attributes'            => __('Reviews Feed Attributes', 'trust-reviews'),
            'parent_item_colon'     => __('Parent Reviews Feed:', 'trust-reviews'),
            'all_items'             => __('Reviews', 'trust-reviews'),
            'add_new_item'          => __('Add New Reviews Feed', 'trust-reviews'),
            'add_new'               => __('Add Reviews Feed', 'trust-reviews'),
            'new_item'              => __('New Reviews Feed', 'trust-reviews'),
            'edit_item'             => __('Edit Reviews Feed', 'trust-reviews'),
            'update_item'           => __('Update Reviews Feed', 'trust-reviews'),
            'view_item'             => __('View Reviews Feed', 'trust-reviews'),
            'view_items'            => __('View Reviews Feeds', 'trust-reviews'),
            'search_items'          => __('Search Reviews Feeds', 'trust-reviews'),
            'not_found'             => __('Not found', 'trust-reviews'),
            'not_found_in_trash'    => __('Not found in Trash', 'trust-reviews'),
            'featured_image'        => __('Featured Image', 'trust-reviews'),
            'set_featured_image'    => __('Set featured image', 'trust-reviews'),
            'remove_featured_image' => __('Remove featured image', 'trust-reviews'),
            'use_featured_image'    => __('Use as featured image', 'trust-reviews'),
            'insert_into_item'      => __('Insert into item', 'trust-reviews'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'trust-reviews'),
            'items_list'            => __('Reviews Feeds list', 'trust-reviews'),
            'items_list_navigation' => __('Reviews Feeds list navigation', 'trust-reviews'),
            'filter_items_list'     => __('Filter items list', 'trust-reviews'),
        );

        $args = array(
            'label'               => __('Reviews Feed', 'trust-reviews'),
            'labels'              => $labels,
            'supports'            => array('title'),
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => false,
            'show_in_rest'        => false,
            'show_ui'             => true,
            'show_in_menu'        => 'trp',
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capabilities'        => array('create_posts' => 'do_not_allow'),
            'map_meta_cap'        => true,
        );

        register_post_type('trp_feed', $args);
    }
}
