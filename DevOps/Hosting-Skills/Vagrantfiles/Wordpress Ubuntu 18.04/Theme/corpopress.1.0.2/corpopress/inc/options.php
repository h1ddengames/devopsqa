<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function corpopress_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'corpopress' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function corpopress_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'corpopress' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'corpopress_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function corpopress_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'corpopress' ),
            'header-font-1'   => esc_html__( 'Rajdhani', 'corpopress' ),
            'header-font-2'   => esc_html__( 'Cherry Swash', 'corpopress' ),
            'header-font-3'   => esc_html__( 'Philosopher', 'corpopress' ),
            'header-font-4'   => esc_html__( 'Slabo 27px', 'corpopress' ),
            'header-font-5'   => esc_html__( 'Dosis', 'corpopress' ),
        );

        $output = apply_filters( 'corpopress_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;


if ( ! function_exists( 'corpopress_body_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function corpopress_body_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'corpopress' ),
            'body-font-1'     => esc_html__( 'News Cycle', 'corpopress' ),
            'body-font-2'     => esc_html__( 'Pontano Sans', 'corpopress' ),
            'body-font-3'     => esc_html__( 'Gudea', 'corpopress' ),
            'body-font-4'     => esc_html__( 'Quattrocento', 'corpopress' ),
            'body-font-5'     => esc_html__( 'Khand', 'corpopress' ),
        );

        $output = apply_filters( 'corpopress_body_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;


if ( ! function_exists( 'corpopress_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function corpopress_site_layout() {
        $corpopress_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'corpopress_site_layout', $corpopress_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'corpopress_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function corpopress_selected_sidebar() {
        $corpopress_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'corpopress' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'corpopress' ),
        );

        $output = apply_filters( 'corpopress_selected_sidebar', $corpopress_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'corpopress_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function corpopress_global_sidebar_position() {
        $corpopress_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'corpopress_global_sidebar_position', $corpopress_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'corpopress_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function corpopress_sidebar_position() {
        $corpopress_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'corpopress_sidebar_position', $corpopress_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'corpopress_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function corpopress_pagination_options() {
        $corpopress_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'corpopress' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'corpopress' ),
        );

        $output = apply_filters( 'corpopress_pagination_options', $corpopress_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'corpopress_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function corpopress_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'corpopress' ),
            'off'       => esc_html__( 'Disable', 'corpopress' )
        );
        return apply_filters( 'corpopress_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'corpopress_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function corpopress_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'corpopress' ),
            'off'       => esc_html__( 'No', 'corpopress' )
        );
        return apply_filters( 'corpopress_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'corpopress_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function corpopress_sortable_sections() {
        $sections = array(
            'slider'    => esc_html__( 'Main Slider', 'corpopress' ),
            'about'     => esc_html__( 'About Us', 'corpopress' ),
            'service'   => esc_html__( 'Services', 'corpopress' ),
            'featured'  => esc_html__( 'Featured', 'corpopress' ),
            'blog'      => esc_html__( 'Blog', 'corpopress' ),
            'subscription' => esc_html__( 'Subscription', 'corpopress' ),
        );
        return apply_filters( 'corpopress_sortable_sections', $sections );
    }
endif;