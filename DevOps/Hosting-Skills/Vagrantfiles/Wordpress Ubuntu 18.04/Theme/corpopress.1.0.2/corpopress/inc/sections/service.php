<?php
/**
 * Service section
 *
 * This is the template for the content of service section
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */
if ( ! function_exists( 'corpopress_add_service_section' ) ) :
    /**
    * Add service section
    *
    *@since Corpopress 1.0.0
    */
    function corpopress_add_service_section() {
    	$options = corpopress_get_theme_options();
        // Check if service is enabled on frontpage
        $service_enable = apply_filters( 'corpopress_section_status', true, 'service_section_enable' );

        if ( true !== $service_enable ) {
            return false;
        }
        // Get service section details
        $section_details = array();
        $section_details = apply_filters( 'corpopress_filter_service_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render service section now.
        corpopress_render_service_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpopress_get_service_section_details' ) ) :
    /**
    * service section details.
    *
    * @since Corpopress 1.0.0
    * @param array $input service section details.
    */
    function corpopress_get_service_section_details( $input ) {
        $options = corpopress_get_theme_options();

        $content = array();
        $page_ids = array();
        $icons = array();

        for ( $i = 1; $i <= 4; $i++ ) {
            if ( ! empty( $options['service_content_page_' . $i] ) ) :
                $page_ids[] = $options['service_content_page_' . $i];
                $icons[] = ! empty( $options['service_content_icon_' . $i] ) ? $options['service_content_icon_' . $i] : 'fa-cogs';
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 4,
            'orderby'           => 'post__in',
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            $i = 0;
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['icon']      = ! empty( $icons[ $i ] ) ? $icons[ $i ] : 'fa-cogs';
                $page_post['excerpt']   = corpopress_trim_content( 13 );

                // Push to the main array.
                array_push( $content, $page_post );
                $i++;
            endwhile;
        endif;
        wp_reset_postdata();

            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// service section content details.
add_filter( 'corpopress_filter_service_section_details', 'corpopress_get_service_section_details' );


if ( ! function_exists( 'corpopress_render_service_section' ) ) :
  /**
   * Start service section
   *
   * @return string service content
   * @since Corpopress 1.0.0
   *
   */
   function corpopress_render_service_section( $content_details = array() ) {
        $options = corpopress_get_theme_options();
        $i = 1;        

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="services" class="page-section col-4">
            <div class="wrapper">
                <div class="section-wrapper align-center">
                    <?php if ( ! empty( $options['service_title'] ) ) : ?>
                        <div class="section-header">
                            <h2 class="section-title"><?php echo esc_html( $options['service_title'] ); ?></h2>
                        </div><!-- .section-header -->
                    <?php endif; ?>
                </div><!-- .section-wrapper -->

                <?php foreach ( $content_details as $content ) : ?>
                    <article class="hentry">
                        <div class="icon-container">
                            <a href="<?php echo esc_url( $content['url'] ) ?>">
                                <i class="fa <?php echo esc_attr( $content['icon'] ); ?>"></i>
                            </a>
                        </div><!-- .icon-container -->

                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                        </header><!-- .entry-header -->
                        <div class="entry-content">
                           <?php echo esc_html( $content['excerpt'] ); ?>
                        </div><!-- .entry-content -->
                    </article><!-- .article -->
                <?php endforeach; ?>

            </div><!-- .wrapper -->
        </div><!-- #services -->
        
    <?php }
endif;