<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpopress_menu', array(
	'title'             => esc_html__('Header Menu','corpopress'),
	'description'       => esc_html__( 'Header Menu options.', 'corpopress' ),
	'panel'             => 'nav_menus',
) );

// search enable setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[nav_search_enable]', array(
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
	'default'           => $options['nav_search_enable'],
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[nav_search_enable]', array(
	'label'             => esc_html__( 'Enable search', 'corpopress' ),
	'section'           => 'corpopress_menu',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );