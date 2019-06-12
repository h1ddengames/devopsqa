<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'corpopress_pagination', array(
	'title'               => esc_html__('Pagination','corpopress'),
	'description'         => esc_html__( 'Pagination section options.', 'corpopress' ),
	'panel'               => 'corpopress_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'corpopress' ),
	'section'             => 'corpopress_pagination',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'corpopress_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'corpopress_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'corpopress' ),
	'section'             => 'corpopress_pagination',
	'type'                => 'select',
	'choices'			  => corpopress_pagination_options(),
	'active_callback'	  => 'corpopress_is_pagination_enable',
) );
