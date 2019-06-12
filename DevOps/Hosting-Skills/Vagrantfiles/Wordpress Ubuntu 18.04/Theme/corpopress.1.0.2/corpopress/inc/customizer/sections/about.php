<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add About section
$wp_customize->add_section( 'corpopress_about_section', array(
	'title'             => esc_html__( 'About Us','corpopress' ),
	'description'       => esc_html__( 'About Section options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// About content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[about_section_enable]', array(
	'default'			=> 	$options['about_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[about_section_enable]', array(
	'label'             => esc_html__( 'About Section Enable', 'corpopress' ),
	'section'           => 'corpopress_about_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// about pages drop down chooser control and setting
$wp_customize->add_setting( 'corpopress_theme_options[about_content_page]', array(
	'sanitize_callback' => 'corpopress_sanitize_page',
) );

$wp_customize->add_control( new Corpopress_Dropdown_Chooser( $wp_customize, 'corpopress_theme_options[about_content_page]', array(
	'label'             => esc_html__( 'Select Page', 'corpopress' ),
	'section'           => 'corpopress_about_section',
	'choices'			=> corpopress_page_choices(),
	'active_callback'	=> 'corpopress_is_about_section_enable',
) ) );

// about btn title setting and control
$wp_customize->add_setting( 'corpopress_theme_options[about_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['about_btn_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[about_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'corpopress' ),
	'section'        	=> 'corpopress_about_section',
	'active_callback' 	=> 'corpopress_is_about_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[about_btn_title]', array(
		'selector'            => '#about a.btn',
		'settings'            => 'corpopress_theme_options[about_btn_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_about_btn_title_partial',
    ) );
}
