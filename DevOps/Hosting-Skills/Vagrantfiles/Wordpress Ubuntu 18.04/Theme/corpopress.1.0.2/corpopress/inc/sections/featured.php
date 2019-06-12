<?php
/**
 * Featured section
 *
 * This is the template for the content of featured section
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */
if ( ! function_exists( 'corpopress_add_featured_section' ) ) :
    /**
    * Add featured section
    *
    *@since Corpopress 1.0.0
    */
    function corpopress_add_featured_section() {
    	$options = corpopress_get_theme_options();
        // Check if featured is enabled on frontpage
        $featured_enable = apply_filters( 'corpopress_section_status', true, 'featured_section_enable' );

        if ( true !== $featured_enable ) {
            return false;
        }
        // Get featured section details
        $section_details = array();
        $section_details = apply_filters( 'corpopress_filter_featured_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render featured section now.
        corpopress_render_featured_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpopress_get_featured_section_details' ) ) :
    /**
    * featured section details.
    *
    * @since Corpopress 1.0.0
    * @param array $input featured section details.
    */
    function corpopress_get_featured_section_details( $input ) {
        $options = corpopress_get_theme_options();

        $content = array();
        $post_ids = array();

        for ( $i = 1; $i <= 4; $i++ ) {
            if ( ! empty( $options['featured_content_post_' . $i] ) )
                $post_ids[] = $options['featured_content_post_' . $i];
        }
        $args = array(
            'post_type'         => 'post',
            'post__in'          => ( array ) $post_ids,
            'posts_per_page'    => 4,
            'orderby'           => 'post__in',
            'ignore_sticky_posts'   => true,
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = corpopress_trim_content( 3 );
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : '';

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
// featured section content details.
add_filter( 'corpopress_filter_featured_section_details', 'corpopress_get_featured_section_details' );


if ( ! function_exists( 'corpopress_render_featured_section' ) ) :
  /**
   * Start featured section
   *
   * @return string featured content
   * @since Corpopress 1.0.0
   *
   */
   function corpopress_render_featured_section( $content_details = array() ) {
        $options = corpopress_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="slider-section" class="relative">
            <div id="featured-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": false, "centerMode": true, "arrows":true, "autoplay": true, "draggable": true, "fade": false }'>
                <?php foreach ( $content_details as $content ) : ?>
                    <article class="<?php echo ! empty( $content['image'] ) ? 'has' : 'no'; ?>-post-thumbnail">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url( $content['image'] ); ?>');">
                                <a href="<?php echo esc_url( $content['url'] ); ?>"></a>
                                <div class="overlay"></div>
                            </div>
                        <?php endif; ?>
                        <div class="wrapper">
                            <div class="entry-container">
                                <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>" tabindex="0"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                <span><?php echo esc_html( $content['excerpt'] ); ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div><!-- #featured-image -->
        </div><!-- .slider-section -->

    <?php }
endif;