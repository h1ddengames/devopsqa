<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'corpopress_reset_section', array(
	'title'             => esc_html__('Reset all settings','corpopress'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'corpopress' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'corpopress_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'corpopress_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'corpopress' ),
	'section'           => 'corpopress_reset_section',
	'type'              => 'checkbox',
) );
