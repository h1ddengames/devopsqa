<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

$wp_customize->add_section( 'corpopress_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','corpopress' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'corpopress' ),
	'panel'             => 'corpopress_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'corpopress' ),
	'section'          	=> 'corpopress_breadcrumb',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'corpopress_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'corpopress' ),
	'active_callback' 	=> 'corpopress_is_breadcrumb_enable',
	'section'          	=> 'corpopress_breadcrumb',
) );
