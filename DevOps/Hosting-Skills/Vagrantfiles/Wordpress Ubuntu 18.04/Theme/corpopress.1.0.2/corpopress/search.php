<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

get_header(); 
$options = corpopress_get_theme_options();
$column = ! empty( $options['archive_column'] ) ? $options['archive_column'] : 'col-3';
?>

<div id="inner-content-wrapper" class="wrapper page-section no-padding-bottom">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="blog-posts-wrapper <?php echo esc_attr( $column ); ?> clear">
				<?php
				if ( have_posts() ) : ?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>
			<?php  
			/**
			* Hook - corpopress_action_pagination.
			*
			* @hooked corpopress_pagination 
			*/
			do_action( 'corpopress_action_pagination' ); 
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php  
	if ( corpopress_is_sidebar_enable() ) {
		get_sidebar();
	}
	?>
</div><!-- .wrapper -->

<?php
get_footer();
