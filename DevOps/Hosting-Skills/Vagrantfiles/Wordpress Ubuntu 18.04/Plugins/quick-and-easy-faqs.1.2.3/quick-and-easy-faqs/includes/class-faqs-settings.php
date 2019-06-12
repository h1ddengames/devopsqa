<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
if ( ! class_exists( 'Add_FAQs_Settings' ) ) {

    class Add_FAQs_Settings {

        protected static $_instance;

        /**
         * FAQs options
         */
        public $options;

        public function __construct() {

            add_action( 'admin_menu', array( $this, 'add_faqs_options_page' ) );
            add_action( 'admin_init', array( $this, 'initialize_faqs_options' ) );

            add_filter( 'plugin_action_links_' . QE_FAQS_PLUGIN_BASENAME, array( $this, 'faqs_action_links' ) );

            $this->options = get_option( 'quick_and_easy_faqs_options' );

        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Add plugin settings page
         */
        public function add_faqs_options_page(){

            /**
             * Add FAQs settings page
             */
            add_submenu_page(
                'edit.php?post_type=faq',
                __( 'Quick & Easy Settings', 'quick-and-easy-faqs' ),
                __( 'Settings', 'quick-and-easy-faqs' ),
                'manage_options',
                'quick_and_easy_faqs',
                array( $this, 'display_faqs_options_page')
            );

        }

        /**
         * Display FAQs settings page
         */
        public function display_faqs_options_page() {

            ?>
            <!-- Create a header in the default WordPress 'wrap' container -->
            <div class="wrap">

                <h2><?php _e( 'Quick and Easy FAQs Settings', 'quick-and-easy-faqs' ); ?></h2>

                <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
                <?php settings_errors(); ?>

                <!-- Create the form that will be used to render our options -->
                <form method="post" action="options.php">
                    <?php settings_fields( 'quick_and_easy_faqs_options' ); ?>
                    <?php do_settings_sections( 'quick_and_easy_faqs_options' ); ?>
                    <?php submit_button(); ?>
                </form>

            </div><!-- /.wrap -->
            <?php
        }

        /**
         * Initialize FAQs settings page
         */
        public function initialize_faqs_options(){

            // create plugin options if not exist
            if( false == $this->options ) {
                add_option( 'quick_and_easy_faqs_options' );
            }

            /**
             * Section
             */
            add_settings_section(
                'faqs_toggles_style',                                                       // ID used to identify this section and with which to register options
                __( 'FAQs Toggle Styles', 'quick-and-easy-faqs'),                           // Title to be displayed on the administration page
                array( $this, 'faqs_toggles_style_description'),                            // Callback used to render the description of the section
                'quick_and_easy_faqs_options'                                               // Page on which to add this section of options
            );

            add_settings_section(
                'faqs_common_style',
                __( 'FAQs Common Styles', 'quick-and-easy-faqs'),
                array( $this, 'faqs_common_style_description'),
                'quick_and_easy_faqs_options'
            );

            /**
             * Fields
             */
            add_settings_field(
                'faqs_toggle_colors',
                __( 'FAQs toggle colors', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_select_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'faqs_toggle_colors',
                    'default' => 'default',
                    'description' => __( 'Choose custom colors to apply colors provided in options below.', 'quick-and-easy-faqs' ),
                    'options' => array(
                        'default' => __( 'Default Colors', 'quick-and-easy-faqs' ),
                        'custom' => __( 'Custom Colors', 'quick-and-easy-faqs' ),
                    )
                )
            );
            add_settings_field(
                'toggle_question_color',
                __( 'Question text color', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_question_color',
                    'default' => '#333333',
                )
            );
            add_settings_field(
                'toggle_question_hover_color',
                __( 'Question text color on mouse over', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_question_hover_color',
                    'default' => '#333333',
                )
            );
            add_settings_field(
                'toggle_question_bg_color',
                __( 'Question background color', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_question_bg_color',
                    'default' => '#fafafa',
                )
            );
            add_settings_field(
                'toggle_question_hover_bg_color',
                __( 'Question background color on mouse over', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_question_hover_bg_color',
                    'default' => '#eaeaea',
                )
            );
            add_settings_field(
                'toggle_answer_color',
                __( 'Answer text color', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_answer_color',
                    'default' => '#333333',
                )
            );
            add_settings_field(
                'toggle_answer_bg_color',
                __( 'Answer background color', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_color_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_toggles_style',
                array(
                    'id' => 'toggle_answer_bg_color',
                    'default' => '#ffffff',
                )
            );
            add_settings_field(
                'toggle_border_color',                                                      // ID used to identify the field throughout the theme
                __( 'Toggle Border color', 'quick-and-easy-faqs' ),                         // The label to the left of the option interface element
                array( $this, 'faqs_color_option_field' ),                                  // The name of the function responsible for rendering the option interface
                'quick_and_easy_faqs_options',                                              // The page on which this option will be displayed
                'faqs_toggles_style',                                                       // The name of the section to which this field belongs
                array(                                                                      // The array of arguments to pass to the callback. In this case, just a description.
                    'id' => 'toggle_border_color',
                    'default' => '#dddddd',
                )
            );
            add_settings_field(
                'faqs_custom_css',
                __( 'Custom CSS', 'quick-and-easy-faqs' ),
                array( $this, 'faqs_textarea_option_field' ),
                'quick_and_easy_faqs_options',
                'faqs_common_style',
                array(
                    'id' => 'faqs_custom_css',
                )
            );

            /**
             * Register Settings
             */
            register_setting( 'quick_and_easy_faqs_options', 'quick_and_easy_faqs_options' );
        }

        /**
         * FAQs toggle styles section description
         */
        public function faqs_toggles_style_description() {
            echo '<p>'. __( 'These settings only applies to FAQs with toggle style. As FAQs with list style use colors inherited from currently active theme.', 'quick-and-easy-faqs' ) . '</p>';
        }

        /**
         * FAQs common styles section description
         */
        public function faqs_common_style_description() {
            //echo '<p>'.__( '', 'quick-and-easy-faqs' ).'</p>';
            echo '<p></p>';
        }

        /**
         * Re-usable color options field for FAQs settings
         */
        public function faqs_color_option_field( $args ) {
            $field_id = $args['id'];
            if( $field_id ) {
                $val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : $args['default'];
                $default_color = $args['default'];
                echo '<input type="text" name="quick_and_easy_faqs_options['.$field_id.']" value="' . $val . '" class="color-picker" data-default-color="' . $default_color . '">';
            } else {
                _e( 'Field id is missing!', 'quick-and-easy-faqs' );
            }
        }

        /**
         * Re-usable textarea options field for FAQs settings
         */
        public function faqs_textarea_option_field( $args ) {
            $field_id = $args['id'];
            if( $field_id ) {
                $val = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : '';
                echo '<textarea cols="60" rows="8" name="quick_and_easy_faqs_options[' . $field_id . ']" class="faqs-custom-css">' . $val . '</textarea>';
            } else {
                _e( 'Field id is missing!', 'quick-and-easy-faqs' );
            }
        }

        /**
         * Re-usable select options field for FAQs settings
         */
        public function faqs_select_option_field( $args ) {
            $field_id = $args['id'];
            if( $field_id ) {
                $existing_value = ( isset( $this->options[ $field_id ] ) ) ? $this->options[ $field_id ] : '';
                ?>
                <select name="<?php echo 'quick_and_easy_faqs_options[' . $field_id . ']'; ?>" class="faqs-select">
                    <?php foreach( $args['options'] as $key => $value ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $existing_value, $key ); ?>><?php echo $value; ?></option>
                    <?php } ?>
                </select>
                <br/>
                <label><?php echo $args['description']; ?></label>
                <?php
            } else {
                _e( 'Field id is missing!', 'quick-and-easy-faqs' );
            }
        }

        /**
         * Add plugin action links
         */
        public function faqs_action_links( $links ) {
            $links[] = '<a href="'. get_admin_url( null, 'edit.php?post_type=faq&page=quick_and_easy_faqs' ) .'">' . __( 'Settings', 'quick-and-easy-faqs' ) . '</a>';
            return $links;
        }

    }

}

/**
 * Returns the main instance of Quick_And_Easy_FAQs_Admin to prevent the need to use globals.
 */
function init_Add_FAQs_Settings() {
	return Add_FAQs_Settings::instance();
}

/**
 * Get it running
 */
init_Add_FAQs_Settings();