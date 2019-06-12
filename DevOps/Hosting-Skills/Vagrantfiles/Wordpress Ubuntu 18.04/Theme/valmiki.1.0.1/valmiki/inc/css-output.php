<?php
/**
 * Output all of our dynamic CSS.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'valmiki_base_css' ) ) {
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer.
	 *
	 */
	function valmiki_base_css() {
		// Get our settings
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_defaults()
		);
		$body_background = '#' . get_background_color();

		// Initiate our class
		$css = new valmiki_css;
		
		// Body
		$css->set_selector( 'body' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'text_color' ] ) );
		
		// Inside padding
		$valmiki_spacing_settings = wp_parse_args(
			get_option( 'valmiki_spacing_settings', array() ),
			valmiki_spacing_get_defaults()
		);
		if ( ( $valmiki_spacing_settings[ 'side_top' ] != 0 ) || ( $valmiki_spacing_settings[ 'side_right' ] != 0 ) || ( $valmiki_spacing_settings[ 'side_bottom' ] != 0 ) || ( $valmiki_spacing_settings[ 'side_left' ] != 0 ) ) {
		$css->set_selector( '.valmiki-side-padding-inside' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'side_inside_color' ] ) );
		
		$css->set_selector( '.valmiki-side-left-cover,.valmiki-side-right-cover' );
		$css->add_property( 'background-color', esc_attr( $body_background ) );
		
		if ( get_background_image() ) {
			$css->set_selector( '.valmiki-side-padding-inside' );
			$css->add_property( 'background-image', 'url("' . esc_url( get_background_image() ) . '")' );
			$css->add_property( 'background-repeat', esc_attr( get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) ) ) );
			$css->add_property( 'background-position', esc_attr( get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) ) ) . ' ' . esc_attr( get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) ) ) );
			$css->add_property( 'background-size', esc_attr( get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) ) ) );
			$css->add_property( 'background-attachment', esc_attr( get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) ) ) );
		}
		}

		// Links
		$css->set_selector( 'a, a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'link_color' ] ) );
		$css->add_property( 'text-decoration', 'none' ); // Temporary until people can get their browser caches cleared

		// Visited links
		$css->set_selector( 'a:visited' )->add_property( 'color', esc_attr( $valmiki_settings[ 'link_color_visited' ] ) );

		// Hover/focused links
		$css->set_selector( 'a:hover, a:focus, a:active' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'link_color_hover' ] ) );
		$css->add_property( 'text-decoration', 'none' ); // Temporary until people can get their browser caches cleared

		// Container width
		$css->set_selector( 'body .grid-container' )->add_property( 'max-width', absint( $valmiki_settings['container_width'] ), false, 'px' );

		// Allow us to hook CSS into our output
		do_action( 'valmiki_base_css', $css );

		return apply_filters( 'valmiki_base_css_output', $css->css_output() );
	}
}

if ( ! function_exists( 'valmiki_advanced_css' ) ) {
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer.
	 *
	 */
	function valmiki_advanced_css() {
		// Get our settings
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_color_defaults()
		);

		// Initiate our CSS class
		$css = new valmiki_css;

		// Top bar
		$css->set_selector( '.top-bar' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'top_bar_background_color' ] ) );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'top_bar_text_color' ] ) );

		// Top bar link
		$css->set_selector( '.top-bar a,.top-bar a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'top_bar_link_color' ] ) );

		// Top bar link hover
		$css->set_selector( '.top-bar a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'top_bar_link_color_hover' ] ) );

		// Header
		$css->set_selector( '.site-header, .transparent-header.nav-below-header .site-header' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'header_background_color' ] ) );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'header_text_color' ] ) );

		// Header link
		$css->set_selector( '.site-header a,.site-header a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'header_link_color' ] ) );

		// Header link hover
		$css->set_selector( '.site-header a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'header_link_hover_color' ] ) );

		// Site title
		$css->set_selector( '.main-title a,.main-title a:hover,.main-title a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'site_title_color' ] ) );

		// Site description
		$css->set_selector( '.site-description' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'site_tagline_color' ] ) );

		// Navigation background
		$css->set_selector( '.main-navigation,.main-navigation ul ul,.transparent-header .main-navigation.is_stuck' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_color' ] ) );
		// Navigation text
		$css->set_selector( '.main-navigation .main-nav ul li a,.menu-toggle' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_color' ] ) );

		// Navigation background/text on hover
		$css->set_selector( '.main-navigation .main-nav ul li:hover > a,.main-navigation .main-nav ul li:focus > a, .main-navigation .main-nav ul li.sfHover > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_hover_color' ] ) );

		// Mobile button text
		$css->set_selector( 'button.menu-toggle:hover,button.menu-toggle:focus,.main-navigation .mobile-bar-items a,.main-navigation .mobile-bar-items a:hover,.main-navigation .mobile-bar-items a:focus' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_color' ] ) );

		// Navigation background/text current
		$css->set_selector( '.main-navigation .main-nav ul li[class*="current-menu-"] > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_current_color' ] ) );

		// Navigation background text current text hover
		$css->set_selector( '.main-navigation .main-nav ul li[class*="current-menu-"] > a:hover,.main-navigation .main-nav ul li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_current_color' ] ) );

		// Navigation search input
		$css->set_selector( '.inside-navigation .search-form input[type="search"],.inside-navigation .search-form input[type="search"]:active' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_background_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_hover_color' ] ) );

		// Navigation search input on focus
		$css->set_selector( '.inside-navigation .search-form input[type="search"]:focus' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'navigation_text_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'navigation_background_hover_color' ] ) );

		// Sub-navigation background
		$css->set_selector( '.main-navigation ul ul' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'subnavigation_background_color' ] ) );

		// Sub-navigation text
		$css->set_selector( '.main-navigation .main-nav ul ul li a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'subnavigation_text_color' ] ) );

		// Sub-Navigation background/text on hover
		$css->set_selector( '.main-navigation .main-nav ul ul li:hover > a,.main-navigation .main-nav ul ul li:focus > a,.main-navigation .main-nav ul ul li.sfHover > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'subnavigation_text_hover_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'subnavigation_background_hover_color' ] ) );

		// Sub-Navigation background / text current
		$css->set_selector( '.main-navigation .main-nav ul ul li[class*="current-menu-"] > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'subnavigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'subnavigation_background_current_color' ] ) );

		// Sub-Navigation current background / text current
		$css->set_selector( '.main-navigation .main-nav ul ul li[class*="current-menu-"] > a:hover,.main-navigation .main-nav ul ul li[class*="current-menu-"].sfHover > a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'subnavigation_text_current_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'subnavigation_background_current_color' ] ) );

		// Content
		$css->set_selector( '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .one-container .container, .separate-containers .paging-navigation, .inside-page-header' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'content_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'content_background_color' ] ) );

		// Content links
		$css->set_selector( '.inside-article a,.inside-article a:visited,.paging-navigation a,.paging-navigation a:visited,.comments-area a,.comments-area a:visited,.page-header a,.page-header a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'content_link_color' ] ) );

		// Content links on hover
		$css->set_selector( '.inside-article a:hover,.paging-navigation a:hover,.comments-area a:hover,.page-header a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'content_link_hover_color' ] ) );

		// Entry header
		$css->set_selector( '.entry-header h1,.page-header h1' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'content_title_color' ] ) );

		// Blog Header BG
		$css->set_selector( '.page-header-blog,.page-header-blog-corner' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'blog_header_bg_color' ] ) );

		// Blog Header Title
		$css->set_selector( '.page-header-blog-content h2' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_header_title_color' ] ) );
		
		$css->set_selector( '.page-header-blog-content h2 strong' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'blog_header_title_color' ] ) );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_header_button' ] ) );

		// Blog Header Text
		$css->set_selector( '.page-header-blog-content p' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_header_text_color' ] ) );

		// Blog Header Button
		$css->set_selector( '.page-header-blog-content .button' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_header_button' ] ) );

		// Blog Header Button BG
		$css->set_selector( '.page-header-blog-content .button' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'blog_header_button_bg' ] ) );

		// Blog Header Button Hover
		$css->set_selector( '.page-header-blog-content .button:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_header_button_hover' ] ) );

		// Blog Header Button Hover BG
		$css->set_selector( '.page-header-blog-content .button:hover' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'blog_header_button_hover_bg' ] ) );

		// Blog post title
		$css->set_selector( '.entry-title a,.entry-title a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_post_title_color' ] ) );

		// Blog post title on hover
		$css->set_selector( '.entry-title a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'blog_post_title_hover_color' ] ) );

		// Entry meta text
		$css->set_selector( '.entry-meta' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'entry_meta_text_color' ] ) );

		// Entry meta links
		$css->set_selector( '.entry-meta a,.entry-meta a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'entry_meta_link_color' ] ) );

		// Entry meta links on hover
		$css->set_selector( '.entry-meta a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'entry_meta_link_color_hover' ] ) );

		// H1 color
		$css->set_selector( 'h1' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h1_color' ] ) );

		// H2 color
		$css->set_selector( 'h2' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h2_color' ] ) );

		// H3 color
		$css->set_selector( 'h3' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h3_color' ] ) );

		// H4 color
		$css->set_selector( 'h4' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h4_color' ] ) );

		// H5 color
		$css->set_selector( 'h5' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h5_color' ] ) );

		// H6 color
		$css->set_selector( 'h6' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'h6_color' ] ) );

		// Sidebar widget
		$css->set_selector( '.sidebar .widget' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'sidebar_widget_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'sidebar_widget_background_color' ] ) );

		// Sidebar widget links
		$css->set_selector( '.sidebar .widget a,.sidebar .widget a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'sidebar_widget_link_color' ] ) );

		// Sidebar widget links on hover
		$css->set_selector( '.sidebar .widget a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'sidebar_widget_link_hover_color' ] ) );

		// Sidebar widget title
		$css->set_selector( '.sidebar .widget .widget-title' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'sidebar_widget_title_color' ] ) );

		// Footer widget
		$css->set_selector( '.footer-widgets' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_widget_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'footer_widget_background_color' ] ) );
		
		$css->set_selector( '.footer-widgets h1,.footer-widgets h2,.footer-widgets h3' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_widget_text_color' ] ) );

		// Footer widget links
		$css->set_selector( '.footer-widgets a,.footer-widgets a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_widget_link_color' ] ) );

		// Footer widget links on hover
		$css->set_selector( '.footer-widgets a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_widget_link_hover_color' ] ) );

		// Footer widget title
		$css->set_selector( '.footer-widgets .widget-title' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_widget_title_color' ] ) );

		// Footer
		$css->set_selector( '.site-info' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'footer_background_color' ] ) );

		// Footer links
		$css->set_selector( '.site-info a,.site-info a:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_link_color' ] ) );

		// Footer links on hover
		$css->set_selector( '.site-info a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'footer_link_hover_color' ] ) );

		// Form input
		$css->set_selector( 'input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="tel"],input[type="number"],textarea,select' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'form_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'form_background_color' ] ) );
		$css->add_property( 'border-color', esc_attr( $valmiki_settings[ 'form_border_color' ] ) );

		// Form input on focus
		$css->set_selector( 'input[type="text"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="password"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="number"]:focus,textarea:focus,select:focus' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'form_text_color_focus' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'form_background_color_focus' ] ) );
		$css->add_property( 'border-color', esc_attr( $valmiki_settings[ 'form_border_color_focus' ] ) );

		// Form button
		$css->set_selector( 'button,html input[type="button"],input[type="reset"],input[type="submit"],a.button,a.button:visited' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'form_button_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'form_button_background_color' ] ) );

		// Form button on hover
		$css->set_selector( 'button:hover,html input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,a.button:hover,button:focus,html input[type="button"]:focus,input[type="reset"]:focus,input[type="submit"]:focus,a.button:focus' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'form_button_text_color_hover' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'form_button_background_color_hover' ] ) );

		// Back to top button
		$css->set_selector( '.valmiki-back-to-top,.valmiki-back-to-top:visited' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings['back_to_top_background_color'] ) );
		$css->add_property( 'color', esc_attr( $valmiki_settings['back_to_top_text_color'] ) );

		$css->set_selector( '.valmiki-back-to-top:hover,.valmiki-back-to-top:focus' );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings['back_to_top_background_color_hover'] ) );
		$css->add_property( 'color', esc_attr( $valmiki_settings['back_to_top_text_color_hover'] ) );
		
		// Fixed Side Content

		$css->set_selector( '.valmiki-side-left-content .valmiki-side-left-socials ul,.valmiki-side-left-content .valmiki-side-left-text' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'fixed_side_content_text_color' ] ) );
		$css->add_property( 'background-color', esc_attr( $valmiki_settings[ 'fixed_side_content_background_color' ] ) );

		$css->set_selector( '.valmiki-side-left-content a' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'fixed_side_content_link_color' ] ) );

		$css->set_selector( '.valmiki-side-left-content a:hover' );
		$css->add_property( 'color', esc_attr( $valmiki_settings[ 'fixed_side_content_link_hover_color' ] ) );

		// Allow us to hook CSS into our output
		do_action( 'valmiki_colors_css', $css );

		// Return our dynamic CSS
		return apply_filters( 'valmiki_colors_css_output', $css->css_output() );
	}
}

if ( ! function_exists( 'valmiki_font_css' ) ) {
	/**
	 * Generate the CSS in the <head> section using the Theme Customizer.
	 *
	 */
	function valmiki_font_css() {

		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_default_fonts()
		);

		$og_defaults = valmiki_get_default_fonts( false );

		$css = new valmiki_css;

		// Get our sub-navigation font size
		$subnav_font_size = $valmiki_settings['navigation_font_size'] >= 17 ? $valmiki_settings['navigation_font_size'] - 3 : $valmiki_settings['navigation_font_size'] - 1;

		// Create all of our font family entries
		$body_family = valmiki_get_font_family_css( 'font_body', 'valmiki_settings', valmiki_get_default_fonts() );
		$top_bar_family = valmiki_get_font_family_css( 'font_top_bar', 'valmiki_settings', valmiki_get_default_fonts() );
		$site_title_family = valmiki_get_font_family_css( 'font_site_title', 'valmiki_settings', valmiki_get_default_fonts() );
		$site_tagline_family = valmiki_get_font_family_css( 'font_site_tagline', 'valmiki_settings', valmiki_get_default_fonts() );
		$blog_header_title_family = valmiki_get_font_family_css( 'font_blog_header_title', 'valmiki_settings', valmiki_get_default_fonts() );
		$blog_header_text_family = valmiki_get_font_family_css( 'font_blog_header_text', 'valmiki_settings', valmiki_get_default_fonts() );
		$navigation_family = valmiki_get_font_family_css( 'font_navigation', 'valmiki_settings', valmiki_get_default_fonts() );
		$widget_family = valmiki_get_font_family_css( 'font_widget_title', 'valmiki_settings', valmiki_get_default_fonts() );
		$h1_family = valmiki_get_font_family_css( 'font_heading_1', 'valmiki_settings', valmiki_get_default_fonts() );
		$h2_family = valmiki_get_font_family_css( 'font_heading_2', 'valmiki_settings', valmiki_get_default_fonts() );
		$h3_family = valmiki_get_font_family_css( 'font_heading_3', 'valmiki_settings', valmiki_get_default_fonts() );
		$h4_family = valmiki_get_font_family_css( 'font_heading_4', 'valmiki_settings', valmiki_get_default_fonts() );
		$h5_family = valmiki_get_font_family_css( 'font_heading_5', 'valmiki_settings', valmiki_get_default_fonts() );
		$h6_family = valmiki_get_font_family_css( 'font_heading_6', 'valmiki_settings', valmiki_get_default_fonts() );
		$footer_family = valmiki_get_font_family_css( 'font_footer', 'valmiki_settings', valmiki_get_default_fonts() );
		$fixed_side_family = valmiki_get_font_family_css( 'font_fixed_side', 'valmiki_settings', valmiki_get_default_fonts() );
		$buttons_family = valmiki_get_font_family_css( 'font_buttons', 'valmiki_settings', valmiki_get_default_fonts() );

		// Body
		$css->set_selector( 'body, button, input, select, textarea' );
		$css->add_property( 'font-family', $body_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'body_font_weight' ] ), $og_defaults[ 'body_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'body_font_transform' ] ), $og_defaults[ 'body_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'body_font_size' ] ), $og_defaults[ 'body_font_size' ], 'px' );

		// Line hieght
		$css->set_selector( 'body' );
		$css->add_property( 'line-height', floatval( $valmiki_settings['body_line_height'] ), $og_defaults['body_line_height'] );

		// Paragraph margin
		$css->set_selector( 'p' );
		$css->add_property( 'margin-bottom', floatval( $valmiki_settings['paragraph_margin'] ), $og_defaults['paragraph_margin'], 'em' );

		// Top bar
		$css->set_selector( '.top-bar' );
		$css->add_property( 'font-family', $top_bar_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'top_bar_font_weight' ] ), $og_defaults[ 'top_bar_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'top_bar_font_transform' ] ), $og_defaults[ 'top_bar_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'top_bar_font_size' ] ), absint( $og_defaults[ 'top_bar_font_size' ] ), 'px' );

		// Site title
		$css->set_selector( '.main-title' );
		$css->add_property( 'font-family', $site_title_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'site_title_font_weight' ] ), $og_defaults[ 'site_title_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'site_title_font_transform' ] ), $og_defaults[ 'site_title_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'site_title_font_size' ] ), $og_defaults[ 'site_title_font_size' ], 'px' );

		// Site description
		$css->set_selector( '.site-description' );
		$css->add_property( 'font-family', $site_tagline_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'site_tagline_font_weight' ] ), $og_defaults[ 'site_tagline_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'site_tagline_font_transform' ] ), $og_defaults[ 'site_tagline_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'site_tagline_font_size' ] ), $og_defaults[ 'site_tagline_font_size' ], 'px' );

		// Blog Header Title
		$css->set_selector( '.page-header-blog-content h2' );
		$css->add_property( 'font-family', $blog_header_title_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'blog_header_title_font_weight' ] ), $og_defaults[ 'blog_header_title_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'blog_header_title_font_transform' ] ), $og_defaults[ 'blog_header_title_font_transform' ] );

		// Blog Header Text
		$css->set_selector( '.page-header-blog-content p' );
		$css->add_property( 'font-family', $blog_header_text_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'blog_header_text_font_weight' ] ), $og_defaults[ 'blog_header_text_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'blog_header_text_font_transform' ] ), $og_defaults[ 'blog_header_text_font_transform' ] );

		// Navigation
		$css->set_selector( '.main-navigation a, .menu-toggle' );
		$css->add_property( 'font-family', $navigation_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'navigation_font_weight' ] ), $og_defaults[ 'navigation_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'navigation_font_transform' ] ), $og_defaults[ 'navigation_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'navigation_font_size' ] ), $og_defaults[ 'navigation_font_size' ], 'px' );

		// Sub-navigation font size
		$css->set_selector( '.main-navigation .main-nav ul ul li a' );
		$css->add_property( 'font-size', absint( $subnav_font_size ), false, 'px' );

		// Widget title
		$css->set_selector( '.widget-title' );
		$css->add_property( 'font-family', $widget_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'widget_title_font_weight' ] ), $og_defaults[ 'widget_title_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'widget_title_font_transform' ] ), $og_defaults[ 'widget_title_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'widget_title_font_size' ] ), $og_defaults[ 'widget_title_font_size' ], 'px' );
		$css->add_property( 'margin-bottom', absint( $valmiki_settings['widget_title_separator'] ), absint( $og_defaults['widget_title_separator'] ), 'px' );

		// Widget font size
		$css->set_selector( '.sidebar .widget, .footer-widgets .widget' );
		$css->add_property( 'font-size', absint( $valmiki_settings['widget_content_font_size'] ), $og_defaults['widget_content_font_size'], 'px' );

		// Form button
		$css->set_selector( 'button:not(.menu-toggle),html input[type="button"],input[type="reset"],input[type="submit"],.button,.button:visited' );
		$css->add_property( 'font-family', $buttons_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'buttons_font_weight' ] ), $og_defaults[ 'buttons_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'buttons_font_transform' ] ), $og_defaults[ 'buttons_font_transform' ] );

		if ( '' !== $valmiki_settings[ 'buttons_font_size' ] ) {
			$css->add_property( 'font-size', absint( $valmiki_settings[ 'buttons_font_size' ] ), $og_defaults[ 'buttons_font_size' ], 'px' );
		}

		// H1
		$css->set_selector( 'h1' );
		$css->add_property( 'font-family', $h1_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_1_weight' ] ), $og_defaults[ 'heading_1_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_1_transform' ] ), $og_defaults[ 'heading_1_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_1_font_size' ] ), $og_defaults[ 'heading_1_font_size' ], 'px' );
		$css->add_property( 'line-height', floatval( $valmiki_settings['heading_1_line_height'] ), $og_defaults['heading_1_line_height'], 'em' );

		// H2
		$css->set_selector( 'h2' );
		$css->add_property( 'font-family', $h2_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_2_weight' ] ), $og_defaults[ 'heading_2_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_2_transform' ] ), $og_defaults[ 'heading_2_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_2_font_size' ] ), $og_defaults[ 'heading_2_font_size' ], 'px' );
		$css->add_property( 'line-height', floatval( $valmiki_settings['heading_2_line_height'] ), $og_defaults['heading_2_line_height'], 'em' );

		// H3
		$css->set_selector( 'h3' );
		$css->add_property( 'font-family', $h3_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_3_weight' ] ), $og_defaults[ 'heading_3_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_3_transform' ] ), $og_defaults[ 'heading_3_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_3_font_size' ] ), $og_defaults[ 'heading_3_font_size' ], 'px' );
		$css->add_property( 'line-height', floatval( $valmiki_settings['heading_3_line_height'] ), $og_defaults['heading_3_line_height'], 'em' );

		// H4
		$css->set_selector( 'h4' );
		$css->add_property( 'font-family', $h4_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_4_weight' ] ), $og_defaults[ 'heading_4_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_4_transform' ] ), $og_defaults[ 'heading_4_transform' ] );

		if ( '' !== $valmiki_settings[ 'heading_4_font_size' ] ) {
			$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_4_font_size' ] ), $og_defaults[ 'heading_4_font_size' ], 'px' );
		}

		if ( '' !== $valmiki_settings[ 'heading_4_line_height' ] ) {
			$css->add_property( 'line-height', floatval( $valmiki_settings['heading_4_line_height'] ), $og_defaults['heading_4_line_height'], 'em' );
		}

		// H5
		$css->set_selector( 'h5' );
		$css->add_property( 'font-family', $h5_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_5_weight' ] ), $og_defaults[ 'heading_5_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_5_transform' ] ), $og_defaults[ 'heading_5_transform' ] );

		if ( '' !== $valmiki_settings[ 'heading_5_font_size' ] ) {
			$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_5_font_size' ] ), $og_defaults[ 'heading_5_font_size' ], 'px' );
		}

		if ( '' !== $valmiki_settings['heading_5_line_height'] ) {
			$css->add_property( 'line-height', floatval( $valmiki_settings['heading_5_line_height'] ), $og_defaults['heading_5_line_height'], 'em' );
		}

		// H6
		$css->set_selector( 'h6' );
		$css->add_property( 'font-family', $h6_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'heading_6_weight' ] ), $og_defaults[ 'heading_6_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'heading_6_transform' ] ), $og_defaults[ 'heading_6_transform' ] );

		if ( '' !== $valmiki_settings[ 'heading_6_font_size' ] ) {
			$css->add_property( 'font-size', absint( $valmiki_settings[ 'heading_6_font_size' ] ), $og_defaults[ 'heading_6_font_size' ], 'px' );
		}

		if ( '' !== $valmiki_settings['heading_6_line_height'] ) {
			$css->add_property( 'line-height', floatval( $valmiki_settings['heading_6_line_height'] ), $og_defaults['heading_6_line_height'], 'em' );
		}

		// Footer
		$css->set_selector( '.site-info' );
		$css->add_property( 'font-family', $footer_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'footer_weight' ] ), $og_defaults[ 'footer_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'footer_transform' ] ), $og_defaults[ 'footer_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings['footer_font_size'] ), $og_defaults['footer_font_size'], 'px' );

		// Fixed Side Content
		$css->set_selector( '.valmiki-side-left-content' );
		$css->add_property( 'font-family', $fixed_side_family );
		$css->add_property( 'font-weight', esc_attr( $valmiki_settings[ 'fixed_side_font_weight' ] ), $og_defaults[ 'fixed_side_font_weight' ] );
		$css->add_property( 'text-transform', esc_attr( $valmiki_settings[ 'fixed_side_font_transform' ] ), $og_defaults[ 'fixed_side_font_transform' ] );
		$css->add_property( 'font-size', absint( $valmiki_settings['fixed_side_font_size'] ), $og_defaults['fixed_side_font_size'], 'px' );

		// Mobile
		$css->start_media_query( apply_filters( 'valmiki_mobile_media_query', '(max-width:768px)' ) );
			// Site title
			$mobile_site_title = ( isset( $valmiki_settings[ 'mobile_site_title_font_size' ] ) ) ? $valmiki_settings[ 'mobile_site_title_font_size' ] : '30';
			$css->set_selector( '.main-title' );
			$css->add_property( 'font-size', absint( $mobile_site_title ), false, 'px' );

			// H1
			$mobile_h1 = ( isset( $valmiki_settings[ 'mobile_heading_1_font_size' ] ) ) ? $valmiki_settings[ 'mobile_heading_1_font_size' ] : '30';
			$css->set_selector( 'h1' );
			$css->add_property( 'font-size', absint( $mobile_h1 ), false, 'px' );

			// H2
			$mobile_h2 = ( isset( $valmiki_settings[ 'mobile_heading_2_font_size' ] ) ) ? $valmiki_settings[ 'mobile_heading_2_font_size' ] : '25';
			$css->set_selector( 'h2' );
			$css->add_property( 'font-size', absint( $mobile_h2 ), false, 'px' );
		$css->stop_media_query();

		// Allow us to hook CSS into our output
		do_action( 'valmiki_typography_css', $css );

		return apply_filters( 'valmiki_typography_css_output', $css->css_output() );
	}
}

if ( ! function_exists( 'valmiki_spacing_css' ) ) {
	/**
	 * Write our dynamic CSS.
	 *
	 */
	function valmiki_spacing_css() {
		$spacing_settings = wp_parse_args(
			get_option( 'valmiki_spacing_settings', array() ),
			valmiki_spacing_get_defaults()
		);

		$og_defaults = valmiki_spacing_get_defaults( false );
		$sidebar_layout = valmiki_get_layout();
		$side_width_correction = 'calc(100% - ' . $spacing_settings['side_left'] . 'px - ' . $spacing_settings['side_right'] . 'px) !important';

		$css = new valmiki_css;

		// Top bar padding
		$css->set_selector( '.inside-top-bar' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'top_bar_top' ], $spacing_settings[ 'top_bar_right' ], $spacing_settings[ 'top_bar_bottom' ], $spacing_settings[ 'top_bar_left' ] ), valmiki_padding_css( $og_defaults[ 'top_bar_top' ], $og_defaults[ 'top_bar_right' ], $og_defaults[ 'top_bar_bottom' ], $og_defaults[ 'top_bar_left' ] ) );

		// Header padding
		$css->set_selector( '.inside-header' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'header_top' ], $spacing_settings[ 'header_right' ], $spacing_settings[ 'header_bottom' ], $spacing_settings[ 'header_left' ] ), valmiki_padding_css( $og_defaults[ 'header_top' ], $og_defaults[ 'header_right' ], $og_defaults[ 'header_bottom' ], $og_defaults[ 'header_left' ] ) );
		
		$css->start_media_query( apply_filters( 'valmiki_mobile_media_query', '(min-width:768px)' ) );
		$css->set_selector( '.transparent-header .site-header' );
		$css->add_property( 'width', esc_attr( $side_width_correction ) );
		$css->stop_media_query();

		// Content padding
		$css->set_selector( '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content, .inside-page-header' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'content_top' ], $spacing_settings[ 'content_right' ], $spacing_settings[ 'content_bottom' ], $spacing_settings[ 'content_left' ] ), valmiki_padding_css( $og_defaults[ 'content_top' ], $og_defaults[ 'content_right' ], $og_defaults[ 'content_bottom' ], $og_defaults[ 'content_left' ] ) );

		// Mobile Content padding
		$css->start_media_query( apply_filters( 'valmiki_mobile_media_query', '(max-width:768px)' ) );
			$css->set_selector( '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content, .inside-page-header' );
			$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'mobile_content_top' ], $spacing_settings[ 'mobile_content_right' ], $spacing_settings[ 'mobile_content_bottom' ], $spacing_settings[ 'mobile_content_left' ] ) );
		$css->stop_media_query();

		// Fixed Side Content
		$css->set_selector( '.valmiki-side-left-content' );
		$css->add_property( 'margin', valmiki_padding_css( $spacing_settings[ 'fixed_side_margin_top' ], $spacing_settings[ 'fixed_side_margin_right' ], $spacing_settings[ 'fixed_side_margin_bottom' ], $spacing_settings[ 'fixed_side_margin_left' ] ), valmiki_padding_css( $og_defaults[ 'fixed_side_margin_top' ], $og_defaults[ 'fixed_side_margin_right' ], $og_defaults[ 'fixed_side_margin_bottom' ], $og_defaults[ 'fixed_side_margin_left' ] ) );
		
		$css->set_selector( '.valmiki-side-left-content .valmiki-side-left-socials ul' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'fixed_side_top' ], $spacing_settings[ 'fixed_side_right' ], $spacing_settings[ 'fixed_side_bottom' ], $spacing_settings[ 'fixed_side_left' ] ), valmiki_padding_css( $og_defaults[ 'fixed_side_top' ], $og_defaults[ 'fixed_side_right' ], $og_defaults[ 'fixed_side_bottom' ], $og_defaults[ 'fixed_side_left' ] ) );
		
		$css->set_selector( '.valmiki-side-left-content .valmiki-side-left-text' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'fixed_side_left' ], $spacing_settings[ 'fixed_side_top' ], $spacing_settings[ 'fixed_side_right' ], $spacing_settings[ 'fixed_side_bottom' ]  ), valmiki_padding_css( $og_defaults[ 'fixed_side_left' ], $og_defaults[ 'fixed_side_top' ], $og_defaults[ 'fixed_side_right' ], $og_defaults[ 'fixed_side_bottom' ] ) );
		$css->add_property( 'margin-top', '-' . absint( $spacing_settings['fixed_side_top'] ), '-' . absint( $og_defaults['fixed_side_top'] ), 'px' );

		// Side padding
		$css->set_selector( 'body' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'side_top' ], $spacing_settings[ 'side_right' ], $spacing_settings[ 'side_bottom' ], $spacing_settings[ 'side_left' ] ), valmiki_padding_css( $og_defaults[ 'side_top' ], $og_defaults[ 'side_right' ], $og_defaults[ 'side_bottom' ], $og_defaults[ 'side_left' ] ) );
		
		$css->set_selector( '.nav-float-right .is_stuck.main-navigation' );
		$css->add_property( 'margin-left', absint( $spacing_settings['side_left'] ), absint( $og_defaults['side_left'] ), 'px' );
		$css->add_property( 'margin-right', absint( $spacing_settings['side_right'] ), absint( $og_defaults['side_right'] ), 'px' );
		$css->add_property( 'width', esc_attr( $side_width_correction ) );
		
		$css->set_selector( '.valmiki-side-left-cover' );
		$css->add_property( 'width', absint( $spacing_settings['side_left'] ), absint( $og_defaults['side_left'] ), 'px' );
		
		$css->set_selector( '.valmiki-side-right-cover' );
		$css->add_property( 'width', absint( $spacing_settings['side_right'] ), absint( $og_defaults['side_right'] ), 'px' );

		// Sticky menu item padding
		$css->set_selector( '.fluid-header.sticky-enabled .main-navigation.is_stuck .inside-navigation' );
		$css->add_property( 'padding-left', absint( $spacing_settings['side_left'] ), absint( $og_defaults['side_left'] ), 'px !important' );

		// Mobile Side padding
		$css->start_media_query( apply_filters( 'valmiki_mobile_media_query', '(max-width:768px)' ) );
			$css->set_selector( 'body' );
			$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'mobile_side_top' ], $spacing_settings[ 'mobile_side_right' ], $spacing_settings[ 'mobile_side_bottom' ], $spacing_settings[ 'mobile_side_left' ] ) );
		
			$css->set_selector( '.valmiki-side-left-cover' );
			$css->add_property( 'width', absint( $spacing_settings['mobile_side_left'] ), absint( $og_defaults['mobile_side_left'] ), 'px' );
			$css->set_selector( '#mobile-header>.inside-navigation' );
			$css->add_property( 'padding-left', absint( $spacing_settings['mobile_side_left'] ), absint( $og_defaults['mobile_side_left'] ), 'px' );
			
			$css->set_selector( '.valmiki-side-right-cover' );
			$css->add_property( 'width', absint( $spacing_settings['mobile_side_right'] ), absint( $og_defaults['mobile_side_right'] ), 'px' );
			$css->set_selector( '#mobile-header>.inside-navigation' );
			$css->add_property( 'padding-right', absint( $spacing_settings['mobile_side_right'] ), absint( $og_defaults['mobile_side_right'] ), 'px' );
		$css->stop_media_query();

		// One container
		$css->set_selector( '.one-container.right-sidebar .site-main,.one-container.both-right .site-main' );
		$css->add_property( 'margin-right', absint( $spacing_settings['content_right'] ), absint( $og_defaults['content_right'] ), 'px' );

		$css->set_selector( '.one-container.left-sidebar .site-main,.one-container.both-left .site-main' );
		$css->add_property( 'margin-left', absint( $spacing_settings['content_left'] ), absint( $og_defaults['content_left'] ), 'px' );

		$css->set_selector( '.one-container.both-sidebars .site-main' );
		$css->add_property( 'margin', valmiki_padding_css( '0', $spacing_settings[ 'content_right' ], '0', $spacing_settings[ 'content_left' ] ), valmiki_padding_css( '0', $og_defaults[ 'content_right' ], '0', $og_defaults[ 'content_left' ] ) );

		// Separate containers
		// Container bottom margins
		$css->set_selector( '.separate-containers .widget, .separate-containers .site-main > *, .separate-containers .page-header, .widget-area .main-navigation' );
		$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );

		// Right sidebar
		$css->set_selector( '.right-sidebar.separate-containers .site-main' );
		$css->add_property( 'margin', valmiki_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ), valmiki_padding_css( $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], '0' ) );

		// Left sidebar
		$css->set_selector( '.left-sidebar.separate-containers .site-main' );
		$css->add_property( 'margin', valmiki_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ), valmiki_padding_css( $og_defaults[ 'separator' ], '0', $og_defaults[ 'separator' ], $og_defaults[ 'separator' ] ) );

		// Both sidebars
		$css->set_selector( '.both-sidebars.separate-containers .site-main' );
		$css->add_property( 'margin', absint( $spacing_settings['separator'] ), absint( $og_defaults['separator'] ), 'px' );

		// Both right sidebar content separating space
		$css->set_selector( '.both-right.separate-containers .site-main' );
		$css->add_property( 'margin', valmiki_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ), valmiki_padding_css( $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], '0' ) );

		// Both right sidebar - left sidebar separating space
		$css->set_selector( '.both-right.separate-containers .inside-left-sidebar' );
		$css->add_property( 'margin-right', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );

		// Both right sidebar - right sidebar separating space
		$css->set_selector( '.both-right.separate-containers .inside-right-sidebar' );
		$css->add_property( 'margin-left', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );

		// Both left sidebar content separating space
		$css->set_selector( '.both-left.separate-containers .site-main' );
		$css->add_property( 'margin', valmiki_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ), valmiki_padding_css( $og_defaults[ 'separator' ], '0', $og_defaults[ 'separator' ], $og_defaults[ 'separator' ] ) );

		// Both left sidebar - left sidebar separating space
		$css->set_selector( '.both-left.separate-containers .inside-left-sidebar' );
		$css->add_property( 'margin-right', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );

		// Both left sidebar - right sidebar separating space
		$css->set_selector( '.both-left.separate-containers .inside-right-sidebar' );
		$css->add_property( 'margin-left', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );

		// Site main separators
		$css->set_selector( '.separate-containers .site-main' );
		$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );

		// Page header top margin
		$css->set_selector( '.separate-containers .page-header-image, .separate-containers .page-header-contained, .separate-containers .page-header-image-single, .separate-containers .page-header-content-single' );
		$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );

		// Sidebar separator
		$css->set_selector( '.separate-containers .inside-right-sidebar, .separate-containers .inside-left-sidebar' );
		$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );

		// Navigation spacing
		// Menu item size
		$css->set_selector( '.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .mobile-bar-items a' );
		$css->add_property( 'padding-left', absint( $spacing_settings['menu_item'] ), absint( $og_defaults['menu_item'] ), 'px' );
		$css->add_property( 'padding-right', absint( $spacing_settings['menu_item'] ), absint( $og_defaults['menu_item'] ), 'px' );
		$css->add_property( 'line-height', absint( $spacing_settings['menu_item_height'] ), absint( $og_defaults['menu_item_height'] ), 'px' );

		// Sub-menu item size
		$css->set_selector( '.main-navigation .main-nav ul ul li a' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ], $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ] ), valmiki_padding_css( $og_defaults[ 'sub_menu_item_height' ], $og_defaults[ 'menu_item' ], $og_defaults[ 'sub_menu_item_height' ], $og_defaults[ 'menu_item' ] ) );

		// Sub-menu positioning
		$css->set_selector( '.main-navigation ul ul' );
		$css->add_property( 'top', 'auto' ); // Added for compatibility purposes on 22/12/2016

		// Navigation search
		$css->set_selector( '.inside-navigation .search-form, .inside-navigation .search-form input' );
		$css->add_property( 'height', '100%' ); // Added to give browser caches a chance to clear

		// Dropdown arrow spacing
		$css->set_selector( '.rtl .menu-item-has-children .dropdown-menu-toggle' );
		$css->add_property( 'padding-left', absint( $spacing_settings[ 'menu_item' ] ), false, 'px' );

		$css->set_selector( '.menu-item-has-children .dropdown-menu-toggle' );
		$css->add_property( 'padding-right', absint( $spacing_settings[ 'menu_item' ] ), absint( $og_defaults[ 'menu_item' ] ), 'px' );

		// Sub-menu dropdown arrow spacing
		$css->set_selector( '.menu-item-has-children ul .dropdown-menu-toggle' );
		$css->add_property( 'padding-top', absint( $spacing_settings[ 'sub_menu_item_height' ] ), absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );
		$css->add_property( 'padding-bottom', absint( $spacing_settings[ 'sub_menu_item_height' ] ), absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );
		$css->add_property( 'margin-top', '-' . absint( $spacing_settings[ 'sub_menu_item_height' ] ), '-' . absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );

		// RTL menu item padding
		$css->set_selector( '.rtl .main-navigation .main-nav ul li.menu-item-has-children > a' );
		$css->add_property( 'padding-right', absint( $spacing_settings[ 'menu_item' ] ), false, 'px' );

		// Sidebar widget padding
		$css->set_selector( '.widget-area .widget' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'widget_top' ], $spacing_settings[ 'widget_right' ], $spacing_settings[ 'widget_bottom' ], $spacing_settings[ 'widget_left' ] ), valmiki_padding_css( $og_defaults[ 'widget_top' ], $og_defaults[ 'widget_right' ], $og_defaults[ 'widget_bottom' ], $og_defaults[ 'widget_left' ] ) );

		// Footer widget padding
		$css->set_selector( '.footer-widgets' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'footer_widget_container_top' ], $spacing_settings[ 'footer_widget_container_right' ], $spacing_settings[ 'footer_widget_container_bottom' ], $spacing_settings[ 'footer_widget_container_left' ] ), valmiki_padding_css( $og_defaults[ 'footer_widget_container_top' ], $og_defaults[ 'footer_widget_container_right' ], $og_defaults[ 'footer_widget_container_bottom' ], $og_defaults[ 'footer_widget_container_left' ] ) );

		// Footer widget separator
		$css->set_selector( '.site-footer .footer-widgets-container .inner-padding' );
		$css->add_property( 'padding', valmiki_padding_css( '0', '0', '0', $spacing_settings[ 'footer_widget_separator' ] ), valmiki_padding_css( '0', '0', '0', $og_defaults[ 'footer_widget_separator' ] ) );

		$css->set_selector( '.site-footer .footer-widgets-container .inside-footer-widgets' );
		$css->add_property( 'margin-left', '-' . absint( $spacing_settings[ 'footer_widget_separator' ] ), '-' . absint( $og_defaults[ 'footer_widget_separator' ] ), 'px' );

		// Footer padding
		$css->set_selector( '.site-info' );
		$css->add_property( 'padding', valmiki_padding_css( $spacing_settings[ 'footer_top' ], $spacing_settings[ 'footer_right' ], $spacing_settings[ 'footer_bottom' ], $spacing_settings[ 'footer_left' ] ), valmiki_padding_css( $og_defaults[ 'footer_top' ], $og_defaults[ 'footer_right' ], $og_defaults[ 'footer_bottom' ], $og_defaults[ 'footer_left' ] ) );

		$output = '';
		// Get color settings
		$valmiki_settings = wp_parse_args(
			get_option( 'valmiki_settings', array() ),
			valmiki_get_color_defaults()
		);

		// Find out if the content background color and sidebar widget background color is the same
		$sidebar = strtoupper( $valmiki_settings['sidebar_widget_background_color'] );
		$content = strtoupper( $valmiki_settings['content_background_color'] );
		$colors_match = ( ( $sidebar == $content ) || '' == $sidebar ) ? true : false;

		// If they're all 40 (default), remove the padding when one container is set
		// This way, the user can still adjust the padding and it will work (unless they want 40px padding)
		// We'll also remove the padding if there's no color difference between the widgets and content background color
		if ( ( '40' == $spacing_settings[ 'widget_top' ] && '40' == $spacing_settings[ 'widget_right' ] && '40' == $spacing_settings[ 'widget_bottom' ] && '40' == $spacing_settings[ 'widget_left' ] ) && $colors_match ) {
			$output .= '.one-container .sidebar .widget{padding:0px;}';
		}

		// Allow us to hook CSS into our output
		do_action( 'valmiki_spacing_css', $css );

		return apply_filters( 'valmiki_spacing_css_output', $css->css_output() . $output );
	}
}

/**
 * Generates any CSS that can't be cached (can change from page to page).
 *
 */
function valmiki_no_cache_dynamic_css() {
	// Initiate our class.
	$css = new valmiki_css;

	// Content margin if there's no title.
	if ( ! valmiki_show_title() ) {
		$css->set_selector( '.page .entry-content' )->add_property( 'margin-top', '0px' );

		if ( is_single() ) {
			if ( ! apply_filters( 'valmiki_post_author', true ) && ! apply_filters( 'valmiki_post_date', true ) ) {
				$css->set_selector( '.single .entry-content' )->add_property( 'margin-top', '0px' );
			}
		}
	}

	return $css->css_output();
}

add_action( 'wp_enqueue_scripts', 'valmiki_enqueue_dynamic_css', 50 );
/**
 * Enqueue our dynamic CSS.
 *
 */
function valmiki_enqueue_dynamic_css() {
	$css = valmiki_base_css() . valmiki_font_css() . valmiki_advanced_css() . valmiki_spacing_css() . valmiki_no_cache_dynamic_css();

	wp_add_inline_style( 'valmiki-style', $css );
}