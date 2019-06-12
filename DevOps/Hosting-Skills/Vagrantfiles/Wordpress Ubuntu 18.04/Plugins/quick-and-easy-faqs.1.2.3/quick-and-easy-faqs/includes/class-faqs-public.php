<?php
/**
 * The public-facing functionality of the plugin.
 */
if ( ! class_exists( 'Quick_And_Easy_FAQs_Public' ) ) {

    class Quick_And_Easy_FAQs_Public {

        /**
         * The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         */
        private $version;
        
        protected static $_instance;

        /**
         * Initialize the class and set its properties.
         */
        public function __construct() {
            $this->plugin_name = QE_FAQS_PLUGIN_NAME;
            $this->version = QE_FAQS_PLUGIN_VERSION;
            $this->execute_public_hooks();
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function execute_public_hooks() {

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
            add_action( 'wp_head', array( $this, 'add_public_custom_styles' ) );

        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         */
        public function enqueue_public_styles() {

            if ( FAQs_Shortcode::instance()->is_shortcode_being_used() ) {
                wp_enqueue_style( 'font-awesome', dirname( plugin_dir_url( __FILE__ ) ) . '/css/font-awesome.min.css', array(), $this->version, 'all' );
                wp_enqueue_style( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/css/styles-public.css', array(), $this->version, 'all' );

                // if rtl is enabled
                if ( is_rtl() ) {
                    wp_enqueue_style( $this->plugin_name . '-rtl', dirname( plugin_dir_url( __FILE__ ) ) . '/css/styles-public-rtl.css', array(
                        $this->plugin_name,
                        'font-awesome'
                    ), $this->version, 'all' );
                }
            }

        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         */
        public function enqueue_public_scripts() {

            if ( FAQs_Shortcode::instance()->is_shortcode_being_used() ) {
                wp_enqueue_script( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/js/public-scripts.js', array( 'jquery' ), $this->version, false );
            }

        }

        /**
         * Generate custom css for FAQs based on settings
         */
        public function add_public_custom_styles() {

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

    }

}

/**
 * Returns the main instance of Quick_And_Easy_FAQs_Public to prevent the need to use globals.
 */
function init_FAQs_Public() {
	return Quick_And_Easy_FAQs_Public::instance();
}

/**
 * Get it running
 */
init_FAQs_Public();