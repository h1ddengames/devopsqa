<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'corpopress_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','corpopress' ),
	'description'       => esc_html__( 'Archive section options.', 'corpopress' ),
	'panel'             => 'corpopress_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'corpopress_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'corpopress' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'corpopress' ),
	'section'           => 'corpopress_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'corpopress_is_latest_posts'
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'corpopress' ),
	'section'           => 'corpopress_archive_section',
	'on_off_label' 		=> corpopress_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'corpopress_theme_options[hide_author]', array(
	'default'           => $options['hide_author'],
	'sanitize_callback' => 'corpopress_sanitize_switch_control',
) );

$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'corpopress' ),
	'section'           => 'corpopress_archive_section',
	'on_off_label' 		=> corpopress_hide_options(),
) ) );

// Blog content type control and setting
$wp_customize->add_setting( 'corpopress_theme_options[archive_column]', array(
	'default'          	=> $options['archive_column'],
	'sanitize_callback' => 'corpopress_sanitize_select',
) );

$wp_customize->add_control( 'corpopress_theme_options[archive_column]', array(
	'label'             => esc_html__( 'Column Layout', 'corpopress' ),
	'section'           => 'corpopress_archive_section',
	'type'				=> 'select',
	'choices'			=> array( 
		'col-2' 	=> esc_html__( 'Two Column', 'corpopress' ),
		'col-3' 	=> esc_html__( 'Three Column', 'corpopress' ),
	),
) );