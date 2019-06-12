<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'corpopress_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'corpopress' ),
		'priority'   			=> 900,
		'panel'      			=> 'corpopress_theme_options_panel',
	)
);

// footer text
$wp_customize->add_setting( 'corpopress_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'corpopress_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'corpopress_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'corpopress' ),
		'section'    			=> 'corpopress_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'corpopress_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright span',
		'settings'            => 'corpopress_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'corpopress_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'corpopress_theme_options[scroll_top_visible]',
	array(
		'default'       	=> $options['scroll_top_visible'],
		'sanitize_callback' => 'corpopress_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Corpopress_Switch_Control( $wp_customize, 'corpopress_theme_options[scroll_top_visible]',
    array(
		'label'      		=> esc_html__( 'Display Scroll Top Button', 'corpopress' ),
		'section'    		=> 'corpopress_section_footer',
		'on_off_label' 		=> corpopress_switch_options(),
    )
) );