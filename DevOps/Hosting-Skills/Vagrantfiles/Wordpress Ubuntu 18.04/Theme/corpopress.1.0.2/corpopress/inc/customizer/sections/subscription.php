<?php
/**
 * Subscription Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Subscription section
$wp_customize->add_section( 'corpopress_subscription_section', array(
	'title'             => esc_html__( 'Subscription','corpopress' ),
	'description'       => esc_html__( 'Note: To activate this section you need to install Jetpack Plugin and activate subscription module.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// Subscription content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[subscription_section_enable]', array(
	'default'			=> 	$options['subscription_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[subscription_section_enable]', array(
	'label'             => esc_html__( 'Subscription Section Enable', 'corpopress' ),
	'section'           => 'corpopress_subscription_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

// subscription title setting and control
$wp_customize->add_setting( 'corpopress_theme_options[subscription_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['subscription_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[subscription_title]', array(
	'label'           	=> esc_html__( 'Title', 'corpopress' ),
	'section'        	=> 'corpopress_subscription_section',
	'active_callback' 	=> 'corpopress_is_subscription_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[subscription_title]', array(
		'selector'            => '#subscribe .section-header h2.section-title',
		'settings'            => 'corpopress_theme_options[subscription_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_subscription_title_partial',
    ) );
}

// subscription description setting and control
$wp_customize->add_setting( 'corpopress_theme_options[subscription_subtitle]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['subscription_subtitle'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[subscription_subtitle]', array(
	'label'           	=> esc_html__( 'Sub Title', 'corpopress' ),
	'section'        	=> 'corpopress_subscription_section',
	'active_callback' 	=> 'corpopress_is_subscription_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[subscription_subtitle]', array(
		'selector'            => '#subscribe .section-header p',
		'settings'            => 'corpopress_theme_options[subscription_subtitle]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_subscription_subtitle_partial',
    ) );
}

// subscription image setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[subscription_image]', array(
	'sanitize_callback' => 'corpopress_sanitize_image',
	'default'			=> $options['subscription_image'],
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'corpopress_theme_options[subscription_image]',
		array(
		'label'       		=> esc_html__( 'Image', 'corpopress' ),
		'description' 		=> sprintf( esc_html__( 'Recommended size: %1$dpx x %2$dpx ', 'corpopress' ), 1280, 854 ),
		'section'     		=> 'corpopress_subscription_section',
		'active_callback'	=> 'corpopress_is_subscription_section_enable',
) ) );

// subscription btn title setting and control
$wp_customize->add_setting( 'corpopress_theme_options[subscription_btn_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['subscription_btn_title'],
) );

$wp_customize->add_control( 'corpopress_theme_options[subscription_btn_title]', array(
	'label'           	=> esc_html__( 'Button Label', 'corpopress' ),
	'section'        	=> 'corpopress_subscription_section',
	'active_callback' 	=> 'corpopress_is_subscription_section_enable',
	'type'				=> 'text',
) );

