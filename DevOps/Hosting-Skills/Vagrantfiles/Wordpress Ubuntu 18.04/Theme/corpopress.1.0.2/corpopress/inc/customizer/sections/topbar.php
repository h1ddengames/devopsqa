<?php
/**
 * Topbar Section options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add Topbar section
$wp_customize->add_section( 'corpopress_topbar_section', array(
	'title'             => esc_html__( 'Header Meta','corpopress' ),
	'description'       => esc_html__( 'Header Meta options.', 'corpopress' ),
	'panel'             => 'corpopress_front_page_panel',
) );

// top bar menu visible
$wp_customize->add_setting( 'corpopress_theme_options[topbar_social_enable]',
	array(
		'default'       	=> $options['topbar_social_enable'],
		'sanitize_callback' => 'corpopress_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[topbar_social_enable]',
    array(
		'label'      		=> esc_html__( 'Display Social Menu', 'corpopress' ),
		'description'       => sprintf( '%1$s <a class="topbar-menu-trigger" href="#"> %2$s </a> %3$s', esc_html__( 'Note: To show topbar menu.', 'corpopress' ), esc_html__( 'Click Here', 'corpopress' ), esc_html__( 'to create menu', 'corpopress' ) ),
		'section'    		=> 'corpopress_topbar_section',
		'on_off_label' 		=> corpopress_switch_options(),
    )
) );

// topbar phone setting and control
$wp_customize->add_setting( 'corpopress_theme_options[topbar_phone]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['topbar_phone'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[topbar_phone]', array(
	'label'           	=> esc_html__( 'Phone No.', 'corpopress' ),
	'section'        	=> 'corpopress_topbar_section',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[topbar_phone]', array(
		'selector'            => '#masthead .site-branding span.phone a',
		'settings'            => 'corpopress_theme_options[topbar_phone]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_topbar_phone_partial',
    ) );
}