<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

if ( ! function_exists( 'corpopress_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Corpopress 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function corpopress_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'corpopress_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'corpopress_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Corpopress 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function corpopress_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'corpopress_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if slider section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if about section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_about_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[about_section_enable]' )->value() );
}

/**
 * Check if service section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_service_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[service_section_enable]' )->value() );
}

/**
 * Check if featured section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_featured_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[featured_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is post.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_blog_section_content_post_enable( $control ) {
	$content_type = $control->manager->get_setting( 'corpopress_theme_options[blog_content_type]' )->value();
	return corpopress_is_blog_section_enable( $control ) && ( 'post' == $content_type );
}

/**
 * Check if blog section content type is page.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_blog_section_content_page_enable( $control ) {
	$content_type = $control->manager->get_setting( 'corpopress_theme_options[blog_content_type]' )->value();
	return corpopress_is_blog_section_enable( $control ) && ( 'page' == $content_type );
}

/**
 * Check if blog section content type is category.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'corpopress_theme_options[blog_content_type]' )->value();
	return corpopress_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'corpopress_theme_options[blog_content_type]' )->value();
	return corpopress_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}

/**
 * Check if subscription section is enabled.
 *
 * @since Corpopress 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function corpopress_is_subscription_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpopress_theme_options[subscription_section_enable]' )->value() );
}