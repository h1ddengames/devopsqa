<?php
/**
 * Blog section
 *
 * This is the template for the content of blog section
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */
if ( ! function_exists( 'corpopress_add_blog_section' ) ) :
    /**
    * Add blog section
    *
    *@since Corpopress 1.0.0
    */
    function corpopress_add_blog_section() {
    	$options = corpopress_get_theme_options();
        // Check if blog is enabled on frontpage
        $blog_enable = apply_filters( 'corpopress_section_status', true, 'blog_section_enable' );

        if ( true !== $blog_enable ) {
            return false;
        }
        // Get blog section details
        $section_details = array();
        $section_details = apply_filters( 'corpopress_filter_blog_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render blog section now.
        corpopress_render_blog_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpopress_get_blog_section_details' ) ) :
    /**
    * blog section details.
    *
    * @since Corpopress 1.0.0
    * @param array $input blog section details.
    */
    function corpopress_get_blog_section_details( $input ) {
        $options = corpopress_get_theme_options();

        // Content type.
        $blog_content_type  = $options['blog_content_type'];
        
        $content = array();
        switch ( $blog_content_type ) {
        	

            case 'category':
                $cat_id = ! empty( $options['blog_content_category'] ) ? $options['blog_content_category'] : '';
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'cat'               => absint( $cat_id ),
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            case 'recent':
                $cat_ids = ! empty( $options['blog_category_exclude'] ) ? $options['blog_category_exclude'] : array();
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => 3,
                    'category__not_in'  => ( array ) $cat_ids,
                    'ignore_sticky_posts'   => true,
                    );                    
            break;

            default:
            break;
        }


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = corpopress_trim_content( 20 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';
                $page_post['author']    = corpopress_blog_author();

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// blog section content details.
add_filter( 'corpopress_filter_blog_section_details', 'corpopress_get_blog_section_details' );


if ( ! function_exists( 'corpopress_render_blog_section' ) ) :
  /**
   * Start blog section
   *
   * @return string blog content
   * @since Corpopress 1.0.0
   *
   */
   function corpopress_render_blog_section( $content_details = array() ) {
        $options = corpopress_get_theme_options();
        $readmore = ! empty( $options['read_more_text'] ) ? $options['read_more_text'] : esc_html__( 'Read More', 'corpopress' );

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="blog" class="page-section col-3">
            <div class="wrapper">

                <?php if ( ! empty( $options['blog_title'] ) ) : ?>
                    <div class="section-header clear">
                        <h2 class="section-title"><?php echo esc_html( $options['blog_title'] ); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="section-content">
                    <?php foreach ( $content_details as $content ) : 
                    $class = has_post_thumbnail( $content['id'] ) ? '' : 'no-post-thumbnail'; ?>
                        <article class="hentry <?php echo esc_attr( $class ); ?>">
                            <div class="blog-wrapper">
                                <?php if ( $options['blog_author_enable'] ) : ?>
                                    <div class="header-meta">
                                        <?php echo wp_kses_post( $content['author'] ); ?>
                                    </div><!-- .header-meta -->
                                <?php endif; ?>

                                <div class="featured-image">
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <a href="<?php echo esc_url( $content['url'] ); ?>"><img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>"></a>
                                    <?php endif; ?>
                                    <div class="entry-meta">
                                        <?php corpopress_posted_on( $content['id'] ); ?> 
                                    </div><!-- .entry-meta -->
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    </header>
                                    <div class="entry-content">
                                        <p>
                                            <?php echo esc_html( $content['excerpt'] ); ?>
                                            <span>
                                                <a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $readmore ); ?></a>
                                            </span>
                                        </p>
                                    </div><!-- .entry-content -->
                                </div><!-- .entry-container -->
                            </div><!-- .blog-wrapper -->
                        </article><!-- .hentry -->
                    <?php endforeach; ?>
                </div><!-- .section-content -->
            </div><!-- .wrappper -->
        </div><!-- #blog -->

    <?php }
endif;