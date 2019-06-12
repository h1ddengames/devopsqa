<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Corpopress
* @since Corpopress 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'corpopress_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'corpopress_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'corpopress' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'corpopress' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );