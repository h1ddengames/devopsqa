<?php
/**
 * Gutenberg Blocks for FAQs
 */
if ( ! class_exists( 'FAQs_Add_Gutenberg_Blocks' ) ) {

    class FAQs_Add_Gutenberg_Blocks {

        protected static $_instance;

        public function __construct() {
            if ( Quick_And_Easy_FAQs_Admin::is_gutenberg_active() ) {
                add_filter( 'block_categories', array( $this, 'add_faqs_block_category' ) );
                add_action( 'init', array( $this, 'add_all_faqs_block' ) );
            }
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Adding new block category for FAQs
         */
        public function add_faqs_block_category( $categories ) {

            $categories[] = array(
                'slug'  => 'quick-and-easy-faqs',
                'title' => __( 'Quick and Easy FAQs', 'quick-and-easy-faqs' ),
            );
            return $categories;

        }
        
        /**
         * Adding all the blocks for FAQs
         */
        public function add_all_faqs_block() {

            wp_register_script(
                'quick-and-easy-faqs-block',
                dirname( plugin_dir_url( __FILE__ ) ) . '/js/gutenberg-blocks-faqs.js',
                array( 'wp-blocks', 'wp-element' )
            );
        
            register_block_type( 'quick-and-easy-faqs/faqs-only',
                array(
                    'editor_script' => 'quick-and-easy-faqs-block',
                )
            ); 

            register_block_type( 'quick-and-easy-faqs/faqs-grouped',
                array(
                    'editor_script' => 'quick-and-easy-faqs-block',
                )
            );

            register_block_type( 'quick-and-easy-faqs/faqs-toggle',
                array(
                    'editor_script' => 'quick-and-easy-faqs-block',
                )
            );

            register_block_type( 'quick-and-easy-faqs/faqs-filterable-toggle',
                array(
                    'editor_script' => 'quick-and-easy-faqs-block',
                )
            );

        }

    }

}

/**
 * Returns the main instance of FAQs_Add_Gutenberg_Blocks to prevent the need to use globals.
 */
function init_FAQs_Add_Gutenberg_Blocks() { 
    return FAQs_Add_Gutenberg_Blocks::instance();
}

/**
 * Get it running
 */
init_FAQs_Add_Gutenberg_Blocks();