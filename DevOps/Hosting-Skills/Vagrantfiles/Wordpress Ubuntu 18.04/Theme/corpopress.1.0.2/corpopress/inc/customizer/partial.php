<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Corpopress
* @since Corpopress 1.0.0
*/

if ( ! function_exists( 'corpopress_topbar_email_partial' ) ) :
    // topbar email
    function corpopress_topbar_email_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['topbar_email'] );
    }
endif;

if ( ! function_exists( 'corpopress_topbar_phone_partial' ) ) :
    // topbar phone
    function corpopress_topbar_phone_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['topbar_phone'] );
    }
endif;

if ( ! function_exists( 'corpopress_about_title_partial' ) ) :
    // about title
    function corpopress_about_title_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['about_title'] );
    }
endif;

if ( ! function_exists( 'corpopress_about_description_partial' ) ) :
    // about description
    function corpopress_about_description_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['about_description'] );
    }
endif;

if ( ! function_exists( 'corpopress_about_btn_title_partial' ) ) :
    // about btn title
    function corpopress_about_btn_title_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['about_btn_title'] );
    }
endif;

if ( ! function_exists( 'corpopress_service_title_partial' ) ) :
    // service title
    function corpopress_service_title_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['service_title'] );
    }
endif;

if ( ! function_exists( 'corpopress_blog_title_partial' ) ) :
    // blog title
    function corpopress_blog_title_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'corpopress_subscription_title_partial' ) ) :
    // subscription title
    function corpopress_subscription_title_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['subscription_title'] );
    }
endif;

if ( ! function_exists( 'corpopress_subscription_subtitle_partial' ) ) :
    // subscription subtitle
    function corpopress_subscription_subtitle_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['subscription_subtitle'] );
    }
endif;

if ( ! function_exists( 'corpopress_copyright_text_partial' ) ) :
    // copyright text
    function corpopress_copyright_text_partial() {
        $options = corpopress_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;
