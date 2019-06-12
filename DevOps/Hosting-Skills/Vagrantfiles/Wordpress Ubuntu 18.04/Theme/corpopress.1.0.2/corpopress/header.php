<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Corpopress
	 * @since Corpopress 1.0.0
	 */

	/**
	 * corpopress_doctype hook
	 *
	 * @hooked corpopress_doctype -  10
	 *
	 */
	do_action( 'corpopress_doctype' );

?>
<head>
<?php
	/**
	 * corpopress_before_wp_head hook
	 *
	 * @hooked corpopress_head -  10
	 *
	 */
	do_action( 'corpopress_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php
	/**
	 * corpopress_page_start_action hook
	 *
	 * @hooked corpopress_page_start -  10
	 *
	 */
	do_action( 'corpopress_page_start_action' ); 

	/**
	 * corpopress_header_action hook
	 *
	 * @hooked corpopress_header_start -  10
	 * @hooked corpopress_site_branding -  20
	 * @hooked corpopress_site_navigation -  30
	 * @hooked corpopress_header_end -  50
	 *
	 */
	do_action( 'corpopress_header_action' );

	/**
	 * corpopress_content_start_action hook
	 *
	 * @hooked corpopress_content_start -  10
	 *
	 */
	do_action( 'corpopress_content_start_action' );

	/**
	 * corpopress_header_image_action hook
	 *
	 * @hooked corpopress_header_image -  10
	 *
	 */
	do_action( 'corpopress_header_image_action' );

    if ( corpopress_is_frontpage() ) {

    	$sections = corpopress_sortable_sections();
    	$i = 1;
		foreach ( $sections as $section => $value ) {
			add_action( 'corpopress_primary_content', 'corpopress_add_'. $section .'_section', $i . 0 );
			$i++;
		}
		do_action( 'corpopress_primary_content' );
	}