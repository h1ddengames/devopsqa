<?php
/**
 *
 * @link       https://github.com/inspirythemes/quick-and-easy-faqs
 * @since      1.0.0
 *
 * @package    Quick_And_Easy_FAQs
 * @subpackage Quick_And_Easy_FAQs/public
 *
 * The public-facing functionality of the plugin.
 *
 * @author     Inspiry Themes <info@inspirythemes.com>
 */
class Quick_And_Easy_FAQs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Is shortcode being used or not
	 *
	 * @since    1.1.2
	 * @var bool
	 */
	private $shortcode_being_used;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->shortcode_being_used = false;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( $this->is_shortcode_being_used() ) {
			wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/css/font-awesome.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quick-and-easy-faqs-public.css', array(), $this->version, 'all' );

			// if rtl is enabled
			if ( is_rtl() ) {
				wp_enqueue_style( $this->plugin_name . '-rtl', plugin_dir_url( __FILE__ ) . 'css/quick-and-easy-faqs-public-rtl.css', array(
					$this->plugin_name,
					'font-awesome'
				), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( $this->is_shortcode_being_used() ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quick-and-easy-faqs-public.js', array( 'jquery' ), $this->version, false );
		}

	}

	/**
	 * @return bool
	 */
	private function is_shortcode_being_used() {

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
     * Generate custom css for FAQs based on settings
     */
    public function faqs_custom_styles () {

        $faqs_options = get_option( 'quick_and_easy_faqs_options' );

        if ( $faqs_options && $faqs_options['faqs_toggle_colors'] == 'custom' ) {

            $faqs_custom_css = array();

            // Toggle question color
            if ( ! empty ( $faqs_options['toggle_question_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-title',
                    'property'	=>	'color',
                    'value'		=> 	$faqs_options['toggle_question_color']
                );
            }

            // Toggle question color on mouse over
            if ( ! empty ( $faqs_options['toggle_question_hover_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-title:hover',
                    'property'	=>	'color',
                    'value'		=> 	$faqs_options['toggle_question_hover_color']
                );
            }

            // Toggle question background
            if ( ! empty ( $faqs_options['toggle_question_bg_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-title',
                    'property'	=>	'background-color',
                    'value'		=> 	$faqs_options['toggle_question_bg_color']
                );
            }

            // Toggle question background on mouse over
            if ( ! empty ( $faqs_options['toggle_question_hover_bg_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-title:hover',
                    'property'	=>	'background-color',
                    'value'		=> 	$faqs_options['toggle_question_hover_bg_color']
                );
            }

            // Toggle answer color
            if ( ! empty ( $faqs_options['toggle_answer_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-content',
                    'property'	=>	'color',
                    'value'		=> 	$faqs_options['toggle_answer_color']
                );
            }

            // Toggle answer background color
            if ( ! empty ( $faqs_options['toggle_answer_bg_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-content',
                    'property'	=>	'background-color',
                    'value'		=> 	$faqs_options['toggle_answer_bg_color']
                );
            }

            // Toggle border color
            if ( ! empty ( $faqs_options['toggle_border_color'] ) ) {
                $faqs_custom_css[] = array(
                    'elements'	=>	'.qe-faq-toggle .qe-toggle-content, .qe-faq-toggle .qe-toggle-title',
                    'property'	=>	'border-color',
                    'value'		=> 	$faqs_options['toggle_border_color']
                );
            }

            // Generate css
            if( 0 < count ( $faqs_custom_css ) ) {
                echo "<style type='text/css' id='faqs-custom-colors'>\n";
                foreach ( $faqs_custom_css as $css_unit ) {
                    if ( ! empty ( $css_unit[ 'value' ] ) ) {
                        echo $css_unit['elements']."{\n";
                        echo $css_unit['property'].":".$css_unit['value'].";\n";
                        echo "}\n";
                    }
                }
                echo '</style>';
            }

        }

        // FAQs custom CSS
        if ( $faqs_options ) {
            $faqs_custom_css = stripslashes( $faqs_options['faqs_custom_css'] );
            if( ! empty ( $faqs_custom_css ) ) {
                echo "\n<style type='text/css' id='faqs-custom-css'>\n";
                echo $faqs_custom_css . "\n";
                echo "</style>";
            }
        }

    }

    /**
     * Register FAQs shortcodes
     *
     * @since   1.0.0
     */
    public function register_faqs_shortcodes() {
        add_shortcode( 'faqs', array( $this, 'display_faqs_list') );
    }

    /**
     * Display faqs in a list
     *
     * @since   1.0.0
     * @param   array   $attributes     Array of attributes
     * @return  string  generated html by shortcode
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
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
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
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
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
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
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
     *
     * @since   1.0.0
     * @param   Array   $filter_array   Array of faq groups slugs
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
     *
     * @param $filter_array array
     *
     * @since   1.0.0
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
     *
     * @since   1.0.1
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
