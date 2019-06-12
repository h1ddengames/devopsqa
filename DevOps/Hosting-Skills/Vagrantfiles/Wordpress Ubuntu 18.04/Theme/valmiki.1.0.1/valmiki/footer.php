<?php
/**
 * The template for displaying the footer.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php
/**
 * valmiki_before_footer hook.
 *
 */
do_action( 'valmiki_before_footer' );
?>

<div <?php valmiki_footer_class(); ?>>
	<?php
	/**
	 * valmiki_before_footer_content hook.
	 *
	 */
	do_action( 'valmiki_before_footer_content' );

	/**
	 * valmiki_footer hook.
	 *
	 *
	 * @hooked valmiki_construct_footer_widgets - 5
	 * @hooked valmiki_construct_footer - 10
	 */
	do_action( 'valmiki_footer' );

	/**
	 * valmiki_after_footer_content hook.
	 *
	 */
	do_action( 'valmiki_after_footer_content' );
	?>
</div><!-- .site-footer -->

<?php
/**
 * valmiki_after_footer hook.
 *
 */
do_action( 'valmiki_after_footer' );

wp_footer();
?>

</body>
</html>
