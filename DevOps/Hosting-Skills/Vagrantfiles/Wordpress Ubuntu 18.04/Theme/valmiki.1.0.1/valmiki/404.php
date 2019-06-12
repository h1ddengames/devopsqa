<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php valmiki_content_class(); ?>>
		<main id="main" <?php valmiki_main_class(); ?>>
			<?php
			/**
			 * valmiki_before_main_content hook.
			 *
			 */
			do_action( 'valmiki_before_main_content' );
			?>

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
					<h1 class="entry-title" itemprop="headline"><?php echo apply_filters( 'valmiki_404_title', __( 'Oops! That page can&rsquo;t be found.', 'valmiki' ) ); // WPCS: XSS OK. ?></h1>
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
					echo '<p>' . apply_filters( 'valmiki_404_text', __( 'It looks like nothing was found at this location. Maybe try searching?', 'valmiki' ) ) . '</p>'; // WPCS: XSS OK.

					get_search_form();
					?>
				</div><!-- .entry-content -->

				<?php
				/**
				 * valmiki_after_content hook.
				 *
				 */
				do_action( 'valmiki_after_content' );
				?>

			</div><!-- .inside-article -->

			<?php
			/**
			 * valmiki_after_main_content hook.
			 *
			 */
			do_action( 'valmiki_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * valmiki_after_primary_content_area hook.
	 *
	 */
	 do_action( 'valmiki_after_primary_content_area' );

	 valmiki_construct_sidebars();

get_footer();
