<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Service section
$wp_customize->add_section( 'corpopress_service_section', array(
	'title'             => esc_html__( 'Services','corpopress' ),
	'description'       => esc_html__( 'Services Section options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// Service content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[service_section_enable]', array(
	'default'			=> 	$options['service_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[service_section_enable]', array(
	'label'             => esc_html__( 'Service Section Enable', 'corpopress' ),
	'section'           => 'corpopress_service_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// service title setting and control
$wp_customize->add_setting( 'corpopress_theme_options[service_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['service_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[service_title]', array(
	'label'           	=> esc_html__( 'Title', 'corpopress' ),
	'section'        	=> 'corpopress_service_section',
	'active_callback' 	=> 'corpopress_is_service_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[service_title]', array(
		'selector'            => '#services .section-header h2.section-title',
		'settings'            => 'corpopress_theme_options[service_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_service_title_partial',
    ) );
}

for ( $i = 1; $i <= 4; $i++ ) :

	// service note control and setting
	$wp_customize->add_setting( 'corpopress_theme_options[service_content_icon_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Corpopress_Icon_Picker( $wp_customize, 'corpopress_theme_options[service_content_icon_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Icon %d', 'corpopress' ), $i ),
		'section'           => 'corpopress_service_section',
		'active_callback'	=> 'corpopress_is_service_section_enable',
	) ) );

	// service pages drop down chooser control and setting
	$wp_customize->add_setting( 'corpopress_theme_options[service_content_page_' . $i . ']', array(
		'sanitize_callback' => 'corpopress_sanitize_page',
	) );

	$wp_customize->add_control( new Corpopress_Dropdown_Chooser( $wp_customize, 'corpopress_theme_options[service_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'corpopress' ), $i ),
		'section'           => 'corpopress_service_section',
		'choices'			=> corpopress_page_choices(),
		'active_callback'	=> 'corpopress_is_service_section_enable',
	) ) );

	// service hr setting and control
	$wp_customize->add_setting( 'corpopress_theme_options[service_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new Corpopress_Customize_Horizontal_Line( $wp_customize, 'corpopress_theme_options[service_hr_'. $i .']',
		array(
			'section'         => 'corpopress_service_section',
			'active_callback' => 'corpopress_is_service_section_enable',
			'type'			  => 'hr'
	) ) );
endfor;
