<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpopress_layout', array(
	'title'               => esc_html__('Layout','corpopress'),
	'description'         => esc_html__( 'Layout section options.', 'corpopress' ),
	'panel'               => 'corpopress_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[site_layout]', array(
	'sanitize_callback'   => 'corpopress_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Corpopress_Custom_Radio_Image_Control ( $wp_customize, 'corpopress_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'corpopress' ),
	'section'             => 'corpopress_layout',
	'choices'			  => corpopress_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'corpopress_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Corpopress_Custom_Radio_Image_Control ( $wp_customize, 'corpopress_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'corpopress' ),
	'section'             => 'corpopress_layout',
	'choices'			  => corpopress_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'corpopress_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Corpopress_Custom_Radio_Image_Control ( $wp_customize, 'corpopress_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'corpopress' ),
	'section'             => 'corpopress_layout',
	'choices'			  => corpopress_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'corpopress_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Corpopress_Custom_Radio_Image_Control( $wp_customize, 'corpopress_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'corpopress' ),
	'section'             => 'corpopress_layout',
	'choices'			  => corpopress_sidebar_position(),
) ) );