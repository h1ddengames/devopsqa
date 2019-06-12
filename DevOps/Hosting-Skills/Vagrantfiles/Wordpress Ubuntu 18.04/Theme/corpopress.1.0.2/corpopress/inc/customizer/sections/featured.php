<?php
/**
 * Featured Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Featured section
$wp_customize->add_section( 'corpopress_featured_section', array(
	'title'             => esc_html__( 'Featured','corpopress' ),
	'description'       => esc_html__( 'Featured Section options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// Featured content enable control and setting
$wp_customize->add_setting( 'corpopress_theme_options[featured_section_enable]', array(
	'default'			=> 	$options['featured_section_enable'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[featured_section_enable]', array(
	'label'             => esc_html__( 'Featured Section Enable', 'corpopress' ),
	'section'           => 'corpopress_featured_section',
	'on_off_label' 		=> corpopress_switch_options(),
) ) );

for ( $i = 1; $i <= 4; $i++ ) :
	// featured posts drop down chooser control and setting
	$wp_customize->add_setting( 'corpopress_theme_options[featured_content_post_' . $i . ']', array(
		'sanitize_callback' => 'corpopress_sanitize_page',
	) );

	$wp_customize->add_control( new Corpopress_Dropdown_Chooser( $wp_customize, 'corpopress_theme_options[featured_content_post_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Post %d', 'corpopress' ), $i ),
		'section'           => 'corpopress_featured_section',
		'choices'			=> corpopress_post_choices(),
		'active_callback'	=> 'corpopress_is_featured_section_enable',
	) ) );
endfor;
