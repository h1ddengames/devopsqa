<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

/**
 * corpopress_footer_primary_content hook
 *
 * @hooked corpopress_add_contact_section -  10
 *
 */
do_action( 'corpopress_footer_primary_content' );

/**
 * corpopress_content_end_action hook
 *
 * @hooked corpopress_content_end -  10
 *
 */
do_action( 'corpopress_content_end_action' );

/**
 * corpopress_content_end_action hook
 *
 * @hooked corpopress_footer_start -  10
 * @hooked Corpopress_Footer_Widgets->add_footer_widgets -  20
 * @hooked corpopress_footer_site_info -  40
 * @hooked corpopress_footer_end -  100
 *
 */
do_action( 'corpopress_footer' );

/**
 * corpopress_page_end_action hook
 *
 * @hooked corpopress_page_end -  10
 *
 */
do_action( 'corpopress_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
