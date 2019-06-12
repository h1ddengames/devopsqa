<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'corpopress_blog_section', array(
	'title'             => esc_html__( 'Blog','corpopress' ),
	'description'       => esc_html__( 'Blog Section options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'corpopress' ),
	'section'           => 'corpopress_blog_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'corpopress_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'corpopress' ),
	'section'        	=> 'corpopress_blog_section',
	'active_callback' 	=> 'corpopress_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[blog_title]', array(
		'selector'            => '#latest-posts .section-header h2.section-title',
		'settings'            => 'corpopress_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_blog_title_partial',
    ) );
}


// Blog content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[blog_author_enable]', array(
	'default'			=> 	$options['blog_author_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[blog_author_enable]', array(
	'label'             => esc_html__( 'Enable Author', 'corpopress' ),
	'section'           => 'corpopress_blog_section',
	'on_off_label' 		=> corpopress_switch_options(),
	'active_callback' 	=> 'corpopress_is_blog_section_enable',
) ) );

// Blog content type control and setting
$wp_customize->add_setting( 'corpopress_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'corpopress_sanitize_select',
) );

$wp_customize->add_control( 'corpopress_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'corpopress' ),
	'section'           => 'corpopress_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'corpopress_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'corpopress' ),
		'recent' 	=> esc_html__( 'Recent', 'corpopress' ),
	),
) );


// Add dropdown category setting and control.
$wp_customize->add_setting(  'corpopress_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'corpopress_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Corpopress_Dropdown_Taxonomies_Control( $wp_customize,'corpopress_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'corpopress' ),
	'description'      	=> esc_html__( 'Note: Latest selected no of posts will be shown from selected category', 'corpopress' ),
	'section'           => 'corpopress_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'corpopress_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'corpopress_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Corpopress_Dropdown_Category_Control( $wp_customize,'corpopress_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'corpopress' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press Shift key select multilple categories.', 'corpopress' ),
	'section'           => 'corpopress_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'corpopress_is_blog_section_content_recent_enable'
) ) );
