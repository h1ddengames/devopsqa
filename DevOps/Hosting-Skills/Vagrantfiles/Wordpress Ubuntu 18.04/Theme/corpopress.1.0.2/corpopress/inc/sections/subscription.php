<?php
/**
 * Subscription section
 *
 * This is the template for the content of subscription section
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */
if ( ! function_exists( 'corpopress_add_subscription_section' ) ) :
    /**
    * Add subscription section
    *
    *@since Corpopress 1.0.0
    */
    function corpopress_add_subscription_section() {
    	$options = corpopress_get_theme_options();
        // Check if subscription is enabled on frontpage
        $subscription_enable = apply_filters( 'corpopress_section_status', true, 'subscription_section_enable' );

        if ( true !== $subscription_enable ) {
            return false;
        }

        // Render subscription section now.
        corpopress_render_subscription_section();
    }
endif;

if ( ! function_exists( 'corpopress_render_subscription_section' ) ) :
  /**
   * Start subscription section
   *
   * @return string subscription content
   * @since Corpopress 1.0.0
   *
   */
   function corpopress_render_subscription_section() {
        if ( ! class_exists( 'Jetpack' ) ) {
            return;
        } elseif ( class_exists( 'Jetpack' ) ) {
            if ( ! Jetpack::is_module_active( 'subscriptions' ) )
                return;
        }

        $options = corpopress_get_theme_options();
        $btn_label = ! empty( $options['subscription_btn_title'] ) ? $options['subscription_btn_title'] : esc_html__( 'Subscribe Now', 'corpopress' );
        $background = ! empty( $options['subscription_image'] ) ? $options['subscription_image'] : get_template_directory_uri() . '/assets/uploads/subscribe.jpg';

        ?>
            <div id="subscribe" style="background-image: url('<?php echo esc_url( $background ); ?>');">
                <div class="wrapper">
                    <div class="subscribe-wrapper">
                        <?php if ( ! empty( $options['subscription_title'] ) && ! empty( $options['subscription_subtitle'] ) ) : ?>
                            <div class="section-header clear">
                                <?php if ( ! empty( $options['subscription_title'] ) ) : ?>
                                    <h2 class="section-title"><?php echo esc_html( $options['subscription_title'] ); ?></h2>
                                <?php endif; 

                                if ( ! empty( $options['subscription_subtitle'] ) ) : ?>
                                    <p><?php echo esc_html( $options['subscription_subtitle'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="section-content">
                            <?php  
                                $subscription_shortcode = '[jetpack_subscription_form title="" subscribe_text="" subscribe_button="' . esc_html( $btn_label ) . '" show_subscribers_total="0"]';
                                echo do_shortcode( wp_kses_post( $subscription_shortcode ) ); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
endif;
