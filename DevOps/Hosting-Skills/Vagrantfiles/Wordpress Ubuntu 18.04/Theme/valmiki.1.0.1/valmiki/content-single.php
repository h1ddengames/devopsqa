<?php
/**
 * The template for displaying single posts.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php valmiki_article_schema( 'CreativeWork' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * valmiki_before_content hook.
		 *
		 *
		 * @hooked valmiki_featured_page_header_inside_single - 10
		 */
		do_action( 'valmiki_before_content' );
		?>

		<header class="entry-header">
			<?php
			/**
			 * valmiki_before_entry_title hook.
			 *
			 */
			do_action( 'valmiki_before_entry_title' );

			if ( valmiki_show_title() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			}

			/**
			 * valmiki_after_entry_title hook.
			 *
			 *
			 * @hooked valmiki_post_meta - 10
			 */
			do_action( 'valmiki_after_entry_title' );
			?>
		</header><!-- .entry-header -->

		<?php
		/**
		 * valmiki_after_entry_header hook.
		 *
		 *
		 * @hooked valmiki_post_image - 10
		 */
		do_action( 'valmiki_after_entry_header' );
		?>

		<div class="entry-content" itemprop="text">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'valmiki' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<?php
		/**
		 * valmiki_after_entry_content hook.
		 *
		 *
		 * @hooked valmiki_footer_meta - 10
		 */
		do_action( 'valmiki_after_entry_content' );

		/**
		 * valmiki_after_content hook.
		 *
		 */
		do_action( 'valmiki_after_content' );
		?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->
