<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

$options = corpopress_get_theme_options();
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

    <div class="blog-wrapper">
        <?php if ( ! $options['hide_author'] ) : ?>
            <div class="header-meta">
                <?php echo corpopress_blog_author(); ?>
            </div><!-- .header-meta -->
        <?php endif; ?>

        <div class="featured-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                     <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ) ?>
                </a>
            <?php endif;

            if ( ! $options['hide_date'] ) : ?>
                <div class="entry-meta">
                    <?php corpopress_posted_on(); ?> 
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </div><!-- .featured-image -->

        <div class="entry-container">
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>
            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-content -->
        </div><!-- .entry-container -->
    </div><!-- .blog-wrapper -->

</article><!-- #post-## -->
