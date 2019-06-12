<?php
/**
 * Main theme functions.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'valmiki_get_setting' ) ) {
	/**
	 * A wrapper function to get our settings.
	 *
	 */
	function valmiki_get_setting( $setting ) {
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_defaults()
		);

		return $valmiki_settings[ $setting ];
	}
}

if ( ! function_exists( 'valmiki_get_layout' ) ) {
	/**
	 * Get the layout for the current page.
	 *
	 *
	 * @return string The sidebar layout location.
	 */
	function valmiki_get_layout() {
		// Get current post
		global $post;

		// Get Customizer options
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_defaults()
		);

		// Set up the layout variable for pages
		$layout = $valmiki_settings['layout_setting'];

		// Get the individual page/post sidebar metabox value
		$layout_meta = ( isset( $post ) ) ? get_post_meta( $post->ID, '_valmiki-sidebar-layout-meta', true ) : '';

		// Set up BuddyPress variable
		$buddypress = false;
		if ( function_exists( 'is_buddypress' ) ) {
			$buddypress = ( is_buddypress() ) ? true : false;
		}

		// If we're on the single post page
		// And if we're not on a BuddyPress page - fixes a bug where BP thinks is_single() is true
		if ( is_single() && ! $buddypress ) {
			$layout = null;
			$layout = $valmiki_settings['single_layout_setting'];
		}

		// If the metabox is set, use it instead of the global settings
		if ( '' !== $layout_meta && false !== $layout_meta ) {
			$layout = $layout_meta;
		}

		// If we're on the blog, archive, attachment etc..
		if ( is_home() || is_archive() || is_search() || is_tax() ) {
			$layout = null;
			$layout = $valmiki_settings['blog_layout_setting'];
		}

		// Finally, return the layout
		return apply_filters( 'valmiki_sidebar_layout', $layout );
	}
}

if ( ! function_exists( 'valmiki_get_footer_widgets' ) ) {
	/**
	 * Get the footer widgets for the current page
	 *
	 *
	 * @return int The number of footer widgets.
	 */
	function valmiki_get_footer_widgets() {
		// Get current post
		global $post;

		// Get Customizer options
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_defaults()
		);

		// Set up the footer widget variable
		$widgets = $valmiki_settings['footer_widget_setting'];

		// Get the individual footer widget metabox value
		$widgets_meta = ( isset( $post ) ) ? get_post_meta( $post->ID, '_valmiki-footer-widget-meta', true ) : '';

		// If we're not on a single page or post, the metabox hasn't been set
		if ( ! is_singular() ) {
			$widgets_meta = '';
		}

		// If we have a metabox option set, use it
		if ( '' !== $widgets_meta && false !== $widgets_meta ) {
			$widgets = $widgets_meta;
		}

		// Finally, return the layout
		return apply_filters( 'valmiki_footer_widgets', $widgets );
	}
}

if ( ! function_exists( 'valmiki_show_excerpt' ) ) {
	/**
	 * Figure out if we should show the blog excerpts or full posts
	 *
	 */
	function valmiki_show_excerpt() {
		// Get current post
		global $post;

		// Get Customizer settings
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_defaults()
		);

		// Check to see if the more tag is being used
		$more_tag = apply_filters( 'valmiki_more_tag', strpos( $post->post_content, '<!--more-->' ) );

		// Check the post format
		$format = ( false !== get_post_format() ) ? get_post_format() : 'standard';

		// Get the excerpt setting from the Customizer
		$show_excerpt = ( 'excerpt' == $valmiki_settings['post_content'] ) ? true : false;

		// If the more tag is found, show the full content
		$show_excerpt = ( $more_tag ) ? false : $show_excerpt;

		// If we're on a search results page, show the excerpt
		$show_excerpt = ( is_search() ) ? true : $show_excerpt;

		// Return our value
		return apply_filters( 'valmiki_show_excerpt', $show_excerpt );
	}
}

if ( ! function_exists( 'valmiki_show_title' ) ) {
	/**
	 * Check to see if we should show our page/post title or not.
	 *
	 *
	 * @return bool Whether to show the content title.
	 */
	function valmiki_show_title() {
		return apply_filters( 'valmiki_show_title', true );
	}
}

if ( ! function_exists( 'valmiki_padding_css' ) ) {
	/**
	 * Shorten our padding/margin values into shorthand form.
	 *
	 *
	 * @param int $top Top spacing.
	 * @param int $right Right spacing.
	 * @param int $bottom Bottom spacing.
	 * @param int $left Left spacing.
	 * @return string Element spacing values.
	 */
	function valmiki_padding_css( $top, $right, $bottom, $left ) {
		$padding_top = ( isset( $top ) && '' !== $top ) ? absint( $top ) . 'px ' : '0px ';
		$padding_right = ( isset( $right ) && '' !== $right ) ? absint( $right ) . 'px ' : '0px ';
		$padding_bottom = ( isset( $bottom ) && '' !== $bottom ) ? absint( $bottom ) . 'px ' : '0px ';
		$padding_left = ( isset( $left ) && '' !== $left ) ? absint( $left ) . 'px' : '0px';

		// If all of our values are the same, we can return one value only
		if ( ( absint( $padding_top ) === absint( $padding_right ) ) && ( absint( $padding_right ) === absint( $padding_bottom ) ) && ( absint( $padding_bottom ) === absint( $padding_left ) ) ) {
			return $padding_left;
		}

		return $padding_top . $padding_right . $padding_bottom . $padding_left;
	}
}

if ( ! function_exists( 'valmiki_get_link_url' ) ) {
	/**
	 * Return the post URL.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 *
	 * @see get_url_in_content()
	 * @return string The Link format URL.
	 */
	function valmiki_get_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

if ( ! function_exists( 'valmiki_get_navigation_location' ) ) {
	/**
	 * Get the location of the navigation and filter it.
	 *
	 *
	 * @return string The primary menu location.
	 */
	function valmiki_get_navigation_location() {
		return apply_filters( 'valmiki_navigation_location', valmiki_get_setting( 'nav_position_setting' ) );
	}
}
