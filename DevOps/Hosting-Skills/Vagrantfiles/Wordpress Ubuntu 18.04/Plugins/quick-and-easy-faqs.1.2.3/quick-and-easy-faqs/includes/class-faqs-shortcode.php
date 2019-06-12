<?php
/**
 * The public-facing functionality of the plugin.
 */
if ( ! class_exists( 'FAQs_Shortcode' ) ) {

    class FAQs_Shortcode {
                
        /**
         * Is shortcode being used or not
         */
        private $shortcode_being_used;

        /**
         * The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         */
        private $version;
        
        protected static $_instance;

        public function __construct() {
            $this->plugin_name = QE_FAQS_PLUGIN_NAME;
            $this->version = QE_FAQS_PLUGIN_VERSION;
            $this->shortcode_being_used = false;

            add_action( 'init', array( $this, 'register_faqs_shortcodes' ) );

            if ( class_exists( 'Vc_Manager' ) ) {
                add_action( 'vc_before_init', array( $this, 'integrate_shortcode_with_vc' ) );
            }
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
                
        /**
         * @return bool
         */
        public function is_shortcode_being_used() {

            if ( $this->shortcode_being_used ) {
                return true;
            } else {
                global $post;
                if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'faqs' ) ) {
                    $this->shortcode_being_used = true;
                    return true;
                }
                return false;
            }
        }

        /**
         * Register FAQs shortcodes
         */
        public function register_faqs_shortcodes() {
            add_shortcode( 'faqs', array( $this, 'display_faqs_list') );
        }

        /**
         * Display faqs in a list
         */
        public function display_faqs_list( $attributes ) {

            extract( shortcode_atts( array(
                'style' => 'list',
                'grouped' => 'no',
                'filter' => null,
            ), $attributes ) );

            $filter_array = array();

            // faq groups filter
            if ( ! empty ( $filter ) ) {
                $filter_array = explode( ',', $filter );
            }

            ob_start();

            if ( $style == 'toggle' ) {
                if ( $grouped == 'yes' ) {
                    $this->toggles_grouped_faqs( $filter_array );
                } else {
                    $this->toggles_for_all_faqs( $filter_array );
                }
            } else if ( $style == 'filterable-toggle' ) {
                $this->filterable_toggles_faqs( $filter_array );
            } else {
                if ( $grouped == 'yes' ) {
                    $this->list_grouped_faqs( $filter_array );
                } else {
                    $this->list_all_faqs( $filter_array );
                }
            }

            return ob_get_clean();

        }

        /**
         * Display FAQs in list style
         */
        private function list_all_faqs( $filter_array ) {

            $faqs_query_args = array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
            );

            if ( ! empty ( $filter_array ) ) {
                $faqs_query_args['tax_query'] = array(
                    array (
                        'taxonomy' => 'faq-group',
                        'field'    => 'slug',
                        'terms'    => $filter_array,
                    ),
                );
            }

            $faqs_query = new WP_Query( $faqs_query_args );

            // FAQs index
            if ( $faqs_query->have_posts() ) :
                echo '<div id="qe-faqs-index" class="qe-faqs-index">';
                    echo '<ol class="qe-faqs-index-list">';
                        while ( $faqs_query->have_posts() ) :
                            $faqs_query->the_post();
                            ?><li><a href="#qe-faq-<?php the_ID(); ?>"><?php the_title(); ?></a></li><?php
                        endwhile;
                    echo '</ol>';
                echo '</div>';
            endif;

            // rewind faqs loop
            $faqs_query->rewind_posts();

            // FAQs Contents
            if ( $faqs_query->have_posts() ) :
                while ( $faqs_query->have_posts() ) :
                    $faqs_query->the_post();
                    ?>
                    <div id="qe-faq-<?php the_ID(); ?>" class="qe-faq-content">
                        <h4 class="qe-faq-question-title"><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
                        <?php the_content(); ?>
                        <a class="qe-faq-top" href="#qe-faqs-index"><i class="fa fa-angle-up"></i> <?php _e( 'Back to Index', 'quick-and-easy-faqs'); ?></a>
                    </div>
                <?php
                endwhile;
            endif;

            // All the custom loops ends here so reset the query
            wp_reset_query();

        }

        /**
         * Display FAQs in list style
         */
        private function list_grouped_faqs( $filter_array ) {

            $faq_groups = get_terms( array( 'taxonomy' => 'faq-group' ) );


            if ( ! empty( $faq_groups ) && ! is_wp_error( $faq_groups ) ) {

                $faqs_queries_array = array();
                $query_index =  0;

                /**
                 * Create Index
                 */
                echo '<div id="qe-faqs-index" class="qe-faqs-index">';

                foreach ( $faq_groups as $faq_group ) {

                    // display all if filter array is empty OR display only specified groups if filter array contains group slugs
                    if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

                        $faqs_queries_array[ $query_index ] = new WP_Query( array(
                                'post_type' => 'faq',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array (
                                        'taxonomy' => 'faq-group',
                                        'field'    => 'slug',
                                        'terms'    => $faq_group->slug,
                                    )
                                ),
                            )
                        );

                        // FAQs index
                        if ( $faqs_queries_array[ $query_index ]->have_posts() ) :
                            echo '<h4 class="qe-faqs-group-title">' . $faq_group->name . '</h4>';
                            echo '<ol class="qe-faqs-group-index qe-faqs-index-list">';
                            while ( $faqs_queries_array[ $query_index ]->have_posts() ) :
                                $faqs_queries_array[ $query_index ]->the_post();
                                ?><li><a href="#qe-faq-<?php the_ID(); ?>"><?php the_title(); ?></a></li><?php
                            endwhile;
                            echo '</ol>';
                        endif;

                        $query_index++;

                    }

                }

                echo '</div>';


                /**
                 * Create Contents
                 */
                foreach ( $faqs_queries_array as $faqs_query ) {
                    $faqs_query->rewind_posts();
                    if ( $faqs_query->have_posts() ) :
                        while ( $faqs_query->have_posts() ) :
                            $faqs_query->the_post();
                            ?>
                            <div id="qe-faq-<?php the_ID(); ?>" class="qe-faq-content">
                                <h4 class="qe-faq-question-title"><i class="fa fa-question-circle"></i> <?php the_title(); ?></h4>
                                <?php the_content(); ?>
                                <a class="qe-faq-top" href="#qe-faqs-index"><i class="fa fa-angle-up"></i> <?php _e( 'Back to Index', 'quick-and-easy-faqs'); ?></a>
                            </div>
                        <?php
                        endwhile;
                    endif;
                }

                // All the custom loops ends here so reset the query
                wp_reset_query();

            }

        }

        /**
         * Display FAQs in toggle style
         */
        private function toggles_for_all_faqs( $filter_array ) {


            $faqs_query_args = array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
            );

            if ( ! empty ( $filter_array ) ) {
                $faqs_query_args['tax_query'] = array(
                    array (
                        'taxonomy' => 'faq-group',
                        'field'    => 'slug',
                        'terms'    => $filter_array,
                    ),
                );
            }

            $faqs_query = new WP_Query( $faqs_query_args );

            // FAQs Toggles
            if ( $faqs_query->have_posts() ) :
                while ( $faqs_query->have_posts() ) :
                    $faqs_query->the_post();
                    ?>
                    <div class="nojs qe-faq-toggle active">
                        <div class="qe-toggle-title">
                            <strong><i class="fa fa-minus-circle"></i> <?php the_title(); ?></strong>
                        </div>
                        <div class="qe-toggle-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php
                endwhile;
            endif;

            // All the custom loops ends here so reset the query
            wp_reset_query();

        }

        /**
         * Display toggle styles FAQs in groups
         */
        private function toggles_grouped_faqs( $filter_array ) {

            $faq_groups = get_terms( 'faq-group' );

            if ( ! empty( $faq_groups ) && ! is_wp_error( $faq_groups ) ) {

                foreach ( $faq_groups as $faq_group ) {

                    // display all if filter array is empty OR display only specified groups if filter array contains group slugs
                    if ( empty( $filter_array ) || in_array ( $faq_group->slug , $filter_array ) ) {

                        $faqs_query = new WP_Query( array(
                                'post_type' => 'faq',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array (
                                        'taxonomy' => 'faq-group',
                                        'field'    => 'slug',
                                        'terms'    => $faq_group->slug,
                                    )
                                ),
                            )
                        );

                        // FAQs Toggles
                        if ( $faqs_query->have_posts() ) :
                            echo '<h4 class="qe-faqs-toggles-group-title">' . $faq_group->name . '</h4>';
                            echo '<div class="qe-faqs-toggles-group">';
                            while ( $faqs_query->have_posts() ) :
                                $faqs_query->the_post();
                                ?>
                                <div class="nojs qe-faq-toggle active">
                                    <div class="qe-toggle-title">
                                        <strong><i class="fa fa-minus-circle"></i> <?php the_title(); ?></strong>
                                    </div>
                                    <div class="qe-toggle-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            echo '</div>';
                        endif;

                    }

                }

                // All the custom loops ends here so reset the query
                wp_reset_query();

            }

        }

        /**
         * Display sortable FAQs in toggle style
         */
        private function filterable_toggles_faqs( $filter_array = null ) {
            ?>
            <ul class="qe-faqs-filters-container">
                <li class="active"><a class="qe-faqs-filter" href="#*" data-filter="*"><?php _e( 'All', 'quick-and-easy-faqs') ?></a></li><?php
                $faq_groups = get_terms( 'faq-group' );
                if ( ! empty( $faq_groups ) && ! is_wp_error( $faq_groups ) ) {
                    foreach ( $faq_groups as $faq_group ) {
                        if( empty( $filter_array ) ) {
                            echo '<li><a class="qe-faqs-filter" href="#' . $faq_group->slug . '" data-filter="' . '.' . $faq_group->slug . '">' . $faq_group->name . '</a></li>';
                        } elseif ( is_array( $filter_array ) && in_array( $faq_group->slug, $filter_array ) ) {
                            echo '<li><a class="qe-faqs-filter" href="#' . $faq_group->slug . '" data-filter="' . '.' . $faq_group->slug . '">' . $faq_group->name . '</a></li>';
                        }
                    }
                }
                ?>
            </ul>
            <?php
            $faqs_query_args = array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
            );

            if ( ! empty( $filter_array ) && is_array( $filter_array ) ) {
                $faqs_query_args[ 'tax_query' ] = array(
                    array(
                        'taxonomy' => 'faq-group',
                        'field'    => 'slug',
                        'terms'    => $filter_array
                    ),
                );
            }

            $faqs_query = new WP_Query( $faqs_query_args );

            // FAQs Toggles
            if ( $faqs_query->have_posts() ) :

                echo '<div class="qe-faqs-filterable">';

                while ( $faqs_query->have_posts() ) :
                    $faqs_query->the_post();

                    // faq group terms slug needed to be used as classes in html for filterable functionality
                    $faq_group_terms = get_the_terms( get_the_ID(), 'faq-group' );
                    $faq_group_terms_slugs = '';
                    if ( ! empty ( $faq_group_terms ) ) {
                        foreach ( $faq_group_terms as $term ) {
                            $faq_group_terms_slugs .= ' ';
                            $faq_group_terms_slugs .= $term->slug;
                        }
                    }

                    ?>
                    <div class="nojs qe-faq-toggle active <?php echo $faq_group_terms_slugs; ?>">
                        <div class="qe-toggle-title">
                            <strong><i class="fa fa-minus-circle"></i> <?php the_title(); ?></strong>
                        </div>
                        <div class="qe-toggle-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php

                endwhile;

                echo '</div>';

            endif;


            // All the custom loops ends here so reset the query
            wp_reset_query();

        }

        /**
         * Integrate shortcode with Visual Composer
         */
        public function integrate_shortcode_with_vc() {

            vc_map( array(
                "name" => __( "Quick and Easy FAQs", "quick-and-easy-faqs" ),
                "description" => __( "Quick and Easy FAQs Plugin", "quick-and-easy-faqs" ),
                "base" => "faqs",
                "category" => __( "Content", "quick-and-easy-faqs" ),
                "params" => array (
                    array(
                        "type" => "dropdown",
                        "heading" => __( "Display Style", "quick-and-easy-faqs" ),
                        "param_name" => "style",
                        "value" => array(
                            'Simple List' => 'list',
                            'Toggle' => 'toggle',
                            'Filterable Toggle' => 'filterable-toggle',
                        ),
                        'admin_label' => true,
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __( "Display FAQs in Groups", "quick-and-easy-faqs" ),
                        "param_name" => "grouped",
                        "value" => array(
                            __('Yes','framework') => 'yes',
                            __('No','framework') => 'no',
                        ),
                        'admin_label' => true,
                    ),
                )
            ) );

        }

    }

}


/**
 * Returns the main instance of Quick_And_Easy_FAQs_Admin to prevent the need to use globals.
 */
function init_FAQs_Shortcode() {
	return FAQs_Shortcode::instance();
}

/**
 * Get it running
 */
init_FAQs_Shortcode();