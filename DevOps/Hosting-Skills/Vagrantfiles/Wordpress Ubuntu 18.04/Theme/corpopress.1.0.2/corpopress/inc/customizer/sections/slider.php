<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'corpopress_slider_section', array(
	'title'             => esc_html__( 'Main Slider','corpopress' ),
	'description'       => esc_html__( 'Slider Section options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'corpopress' ),
	'section'           => 'corpopress_slider_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// Slider btn label setting and control
$wp_customize->add_setting( 'corpopress_theme_options[slider_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['slider_btn_label'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[slider_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Button Label', 'corpopress' ),
	'section'        	=> 'corpopress_slider_section',
	'active_callback' 	=> 'corpopress_is_slider_section_enable',
	'type'				=> 'text',
) );

for ( $i = 1; $i <= 5; $i++ ) :
	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'corpopress_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'corpopress_sanitize_page',
	) );

	$wp_customize->add_control( new Corpopress_Dropdown_Chooser( $wp_customize, 'corpopress_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'corpopress' ), $i ),
		'section'           => 'corpopress_slider_section',
		'choices'			=> corpopress_page_choices(),
		'active_callback'	=> 'corpopress_is_slider_section_enable',
	) ) );

endfor;

// Slider alt btn label setting and control
$wp_customize->add_setting( 'corpopress_theme_options[slider_alt_btn_label]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['slider_alt_btn_label'],
) );

$wp_customize->add_control( 'corpopress_theme_options[slider_alt_btn_label]', array(
	'label'           	=> esc_html__( 'Slider Alt Button Label', 'corpopress' ),
	'section'        	=> 'corpopress_slider_section',
	'active_callback' 	=> 'corpopress_is_slider_section_enable',
	'type'				=> 'text',
) );

// Slider alt btn url setting and control
$wp_customize->add_setting( 'corpopress_theme_options[slider_alt_btn_url]', array(
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'corpopress_theme_options[slider_alt_btn_url]', array(
	'label'           	=> esc_html__( 'Slider Alt Button Url', 'corpopress' ),
	'section'        	=> 'corpopress_slider_section',
	'active_callback' 	=> 'corpopress_is_slider_section_enable',
	'type'				=> 'url',
) );