<?php
/**
 * The template for displaying the header.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php valmiki_body_schema();?> <?php body_class(); ?>>
	<?php
	/**
	 * valmiki_before_header hook.
	 *
	 *
	 * @hooked valmiki_do_skip_to_content_link - 2
	 * @hooked valmiki_top_bar - 5
	 * @hooked valmiki_add_navigation_before_header - 5
	 */
	do_action( 'valmiki_before_header' );

	/**
	 * valmiki_header hook.
	 *
	 *
	 * @hooked valmiki_construct_header - 10
	 */
	do_action( 'valmiki_header' );

	/**
	 * valmiki_after_header hook.
	 *
	 *
	 * @hooked valmiki_featured_page_header - 10
	 */
	do_action( 'valmiki_after_header' );
	?>

	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">
			<?php
			/**
			 * valmiki_inside_container hook.
			 *
			 */
			do_action( 'valmiki_inside_container' );
