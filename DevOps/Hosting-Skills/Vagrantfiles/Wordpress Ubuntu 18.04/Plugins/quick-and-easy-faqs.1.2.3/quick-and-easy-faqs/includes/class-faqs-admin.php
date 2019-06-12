<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
if ( ! class_exists( 'Quick_And_Easy_FAQs_Admin' ) ) {

    class Quick_And_Easy_FAQs_Admin {

        /**
         * The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         */
        private $version;

        /**
         * The domain specified for this plugin.
         */
        private $domain;

        protected static $_instance;

        /**
         * Initialize the class and set its properties.
         */
        public function __construct() {

            $this->plugin_name = QE_FAQS_PLUGIN_NAME;
            $this->version = QE_FAQS_PLUGIN_VERSION;
            $this->domain = QE_FAQS_PLUGIN_NAME;
            $this->execute_admin_hooks();

        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function execute_admin_hooks() {
            register_activation_hook( __FILE__, array( $this, 'faqs_activation' ) ); 
            register_deactivation_hook( __FILE__, array( $this, 'faqs_deactivation' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
            add_action( 'plugins_loaded', array( $this, 'faqs_load_textdomain' ) );
        }

        /**
         * The code that runs during plugin activation.
         * This action is documented in includes/class-quick-and-easy-faqs-activator.php
         */
        public function faqs_activation() {
            
        }

        /**
         * The code that runs during plugin deactivation.
         * This action is documented in includes/class-quick-and-easy-faqs-deactivator.php
         */
        public function faqs_deactivation() {
            
        }

        /**
         * Load the plugin text domain for translation.
         */
        public function faqs_load_textdomain() {

            load_plugin_textdomain(
                $this->domain,
                false, 
                dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
            );

        }

        /**
         * Register the stylesheets for the admin area.
         */
        public function enqueue_admin_styles() {
            // Add the color picker css file
            wp_enqueue_style( 'wp-color-picker' );
            // plugin custom css file
            wp_enqueue_style( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/css/styles-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
        }

        /**
         * Register the JavaScript for the admin area.
         */
        public function enqueue_admin_scripts() {
            wp_enqueue_script( $this->plugin_name, dirname( plugin_dir_url( __FILE__ ) ) . '/js/admin-scripts.js', array( 'jquery' , 'wp-color-picker' ), $this->version, false );
        }

        /**
         * Check if Gutenberg is active.
         */
        public static function is_gutenberg_active() {
            // Gutenberg plugin is installed and activated.
            $gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

            // Block editor since 5.0.
            $block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

            if ( ! $gutenberg && ! $block_editor ) {
                return false;
            }

            if ( self::is_classic_editor_plugin_active() ) {
                $editor_option       = get_option( 'classic-editor-replace' );
                $block_editor_active = array( 'no-replace', 'block' );

                return in_array( $editor_option, $block_editor_active, true );
            }

            return true;
        }

        /**
         * Check if Classic Editor plugin is active.
         */
        public static function is_classic_editor_plugin_active() {
            if ( ! function_exists( 'is_plugin_active' ) ) {
                include_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
                return true;
            }

            return false;
        }
        
        /**
         * To log any thing for debugging purposes
         */
        public static function log( $message ) {
            if( WP_DEBUG === true ){
                if( is_array( $message ) || is_object( $message ) ){
                    error_log( print_r( $message, true ) );
                } else {
                    error_log( $message );
                }
            }
        }

    }
}

/**
 * Returns the main instance of Quick_And_Easy_FAQs_Admin to prevent the need to use globals.
 */
function init_FAQs_admin() {
	return Quick_And_Easy_FAQs_Admin::instance();
}

/**
 * Get it running
 */
init_FAQs_admin();