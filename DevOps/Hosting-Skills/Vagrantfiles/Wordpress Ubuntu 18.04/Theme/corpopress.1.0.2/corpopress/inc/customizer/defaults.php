<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 * @return array An array of default values
 */

function corpopress_get_default_theme_options() {
	$corpopress_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',
		
		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'wide',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'nav_search_enable'				=> true,

		// excerpt options
		'long_excerpt_length'           => 25,
		'read_more_text'           		=> esc_html__( '( Read More )', 'corpopress' ),
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s. ', '1: Year, 2: Site Title with home URL', 'corpopress' ), '[the-year]', '[site-link]' ) . esc_html__( 'All Rights Reserved', 'corpopress' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'corpopress' ),
		'hide_date' 					=> false,
		'hide_author'					=> false,
		'archive_column'				=> 'col-2',

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// topbar
		'topbar_social_enable'			=> false,
		'topbar_phone'					=> esc_html__( '+0 00 000000000', 'corpopress' ),

		// Slider
		'slider_section_enable'			=> true,
		'slider_btn_label'				=> esc_html__( 'Learn More', 'corpopress' ),
		'slider_alt_btn_label'			=> esc_html__( 'Contact Us', 'corpopress' ),

		// About
		'about_section_enable'			=> true,
		'about_btn_title'				=> esc_html__( 'Learn More', 'corpopress' ),

		// service
		'service_section_enable'		=> true,
		'service_title'					=> esc_html__( 'We Offer Our Best For Your Success', 'corpopress' ),

		// Featured
		'featured_section_enable'		=> true,

		// blog
		'blog_section_enable'			=> true,
		'blog_author_enable'			=> true,
		'blog_content_type'				=> 'recent',
		'blog_count'					=> 3,
		'blog_column'					=> 'col-3',
		'blog_title'					=> esc_html__( 'Here&#39;s a good news, check our blog and more', 'corpopress' ),

		// Subscription
		'subscription_section_enable'	=> false,
		'subscription_title'			=> esc_html__( 'Don&#39;t miss any updates', 'corpopress' ),
		'subscription_subtitle'			=> esc_html__( 'Subscribe in seconds. No requirements. Cancel anytime.', 'corpopress' ),
		'subscription_btn_title'		=> esc_html__( 'Subscribe Now', 'corpopress' ),
		'subscription_image'			=> get_template_directory_uri() . '/assets/uploads/subscribe.jpg',

	);

	$output = apply_filters( 'corpopress_default_theme_options', $corpopress_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}