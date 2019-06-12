<?php
/**
 * TinyMCE - Classic Editor Button for FAQs
 */
if ( ! class_exists( 'FAQs_Add_Classic_Editor_Button' ) ) {

    class FAQs_Add_Classic_Editor_Button {

        protected static $_instance;

        public function __construct() {
            add_filter('mce_external_plugins', array( $this, 'enqueue_plugin_scripts' ) );
            add_filter('mce_buttons', array( $this, 'register_buttons_editor' ) );
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Enqueue TinyMCE Plugin Script with its ID.
         */
        public function enqueue_plugin_scripts( $plugin_array ) {
            $plugin_array['faqs_button'] =  dirname( plugin_dir_url( __FILE__ ) ) . '/js/classic-editor-button.js';
            return $plugin_array;
        }
        
        /**
         * Register Button with its ID.
         */
        public function register_buttons_editor($buttons) {
            array_push($buttons, 'faqs');
            return $buttons;
        }

    }

}

/**
 * Returns the main instance of FAQs_Add_Classic_Editor_Button to prevent the need to use globals.
 */
function init_FAQs_Add_Classic_Editor_Button() { 
    return FAQs_Add_Classic_Editor_Button::instance();
}

/**
 * Get it running
 */
init_FAQs_Add_Classic_Editor_Button();