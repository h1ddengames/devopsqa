<?php

/**
 * Custom Post Type & Taxonomy
 */
if ( ! class_exists( 'FAQs_Post_Type_And_Taxonomy' ) ) {
    
    class FAQs_Post_Type_And_Taxonomy {

        protected static $_instance;

        public function __construct() {
            add_action( 'init', array( $this, 'register_faqs_post_type' ) );
            add_action( 'init', array( $this, 'register_faqs_group_taxonomy' ) );
        }
    
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Register FAQs custom post type
         */
        public function register_faqs_post_type() {

            $labels = array(
                'name'                => _x( 'FAQs', 'Post Type General Name', 'quick-and-easy-faqs' ),
                'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'quick-and-easy-faqs' ),
                'menu_name'           => __( 'FAQs', 'quick-and-easy-faqs' ),
                'name_admin_bar'      => __( 'FAQ', 'quick-and-easy-faqs' ),
                'parent_item_colon'   => __( 'Parent FAQ:', 'quick-and-easy-faqs' ),
                'all_items'           => __( 'FAQs', 'quick-and-easy-faqs' ),
                'add_new_item'        => __( 'Add New FAQ', 'quick-and-easy-faqs' ),
                'add_new'             => __( 'Add New', 'quick-and-easy-faqs' ),
                'new_item'            => __( 'New FAQ', 'quick-and-easy-faqs' ),
                'edit_item'           => __( 'Edit FAQ', 'quick-and-easy-faqs' ),
                'update_item'         => __( 'Update FAQ', 'quick-and-easy-faqs' ),
                'view_item'           => __( 'View FAQ', 'quick-and-easy-faqs' ),
                'search_items'        => __( 'Search FAQ', 'quick-and-easy-faqs' ),
                'not_found'           => __( 'Not found', 'quick-and-easy-faqs' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'quick-and-easy-faqs' ),
            );

            $args = array(
                'label'               => __( 'faq', 'quick-and-easy-faqs' ),
                'description'         => __( 'Frequently Asked Questions', 'quick-and-easy-faqs' ),
                'labels'              => apply_filters( 'inspiry_faq_labels', $labels),
                'supports'            => apply_filters( 'inspiry_faq_supports', array( 'title', 'editor' ) ),
                'hierarchical'        => false,
                'public'              => true,
                'exclude_from_search' => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_position'       => 10,
                'menu_icon'           => 'dashicons-format-chat',
                'show_in_admin_bar'   => true,
                'show_in_nav_menus'   => true,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'post',
                'show_in_rest'        => true,
                'rest_base'           => apply_filters( 'inspiry_faq_rest_base', __( 'faqs', 'quick-and-easy-faqs' ) ),
            );

            register_post_type( 'faq', apply_filters( 'inspiry_register_faq_arguments', $args) );

        }

        /**
         * Register FAQ Group custom taxonomy
         */
        public function register_faqs_group_taxonomy() {

            $labels = array(
                'name'                       => _x( 'FAQ Groups', 'Taxonomy General Name', 'quick-and-easy-faqs' ),
                'singular_name'              => _x( 'FAQ Group', 'Taxonomy Singular Name', 'quick-and-easy-faqs' ),
                'menu_name'                  => __( 'Groups', 'quick-and-easy-faqs' ),
                'all_items'                  => __( 'All FAQ Groups', 'quick-and-easy-faqs' ),
                'parent_item'                => __( 'Parent FAQ Group', 'quick-and-easy-faqs' ),
                'parent_item_colon'          => __( 'Parent FAQ Group:', 'quick-and-easy-faqs' ),
                'new_item_name'              => __( 'New FAQ Group Name', 'quick-and-easy-faqs' ),
                'add_new_item'               => __( 'Add New FAQ Group', 'quick-and-easy-faqs' ),
                'edit_item'                  => __( 'Edit FAQ Group', 'quick-and-easy-faqs' ),
                'update_item'                => __( 'Update FAQ Group', 'quick-and-easy-faqs' ),
                'view_item'                  => __( 'View FAQ Group', 'quick-and-easy-faqs' ),
                'separate_items_with_commas' => __( 'Separate FAQ Groups with commas', 'quick-and-easy-faqs' ),
                'add_or_remove_items'        => __( 'Add or remove FAQ Groups', 'quick-and-easy-faqs' ),
                'choose_from_most_used'      => __( 'Choose from the most used', 'quick-and-easy-faqs' ),
                'popular_items'              => __( 'Popular FAQ Groups', 'quick-and-easy-faqs' ),
                'search_items'               => __( 'Search FAQ Groups', 'quick-and-easy-faqs' ),
                'not_found'                  => __( 'Not Found', 'quick-and-easy-faqs' ),
            );

            $args = array(
                'labels'              => apply_filters( 'inspiry_faq_group_labels', $labels ),
                'hierarchical'        => true,
                'public'              => true,
                'exclude_from_search' => false,
                'rewrite'             => false,
                'show_ui'             => true,
                'show_in_menu'        => 'edit.php?post_type=faq',
                'show_admin_column'   => true,
                'show_in_nav_menus'   => true,
                'show_tagcloud'       => false,
                'show_in_rest'        => true,
                'rest_base'           => apply_filters( 'inspiry_faq_group_rest_base', __( 'faq_groups', 'quick-and-easy-faqs' ) ),
            );

            register_taxonomy( 'faq-group', array( 'faq' ), apply_filters( 'inspiry_register_faq_group_arguments', $args ) );

        }

    }

}

/**
 * Returns the main instance of Quick_And_Easy_FAQs_Admin to prevent the need to use globals.
 */
function init_FAQs_Register_CPT() {
	return FAQs_Post_Type_And_Taxonomy::instance();
}

/**
 * Get it running
 */
init_FAQs_Register_CPT();