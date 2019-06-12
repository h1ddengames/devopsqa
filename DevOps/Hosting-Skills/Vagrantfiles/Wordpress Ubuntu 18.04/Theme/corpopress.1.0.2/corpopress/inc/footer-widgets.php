<?php
/**
 * Class for footer widgets.
 *
 * @package Theme Palace
 * @subpackage Corpopress
 */
/**
 * Footer Widgets class.
 *
 * @since 1.0
 */

class Corpopress_Footer_Widgets{

	/**
	 * Number of maximum registered widgets.
	 *
	 * @since 1.0
	 *
	 * @access protected
	 * @var int
	 */
	protected $max_widgets = 0;

	/**
	 * Number of active widgets.
	 *
	 * @since 1.0
	 *
	 * @access protected
	 * @var int
	 */
	protected $active_widgets = 0;

	/**
	 * Prefix to apply hook.
	 *
	 * @since 1.0
	 *
	 * @access protected
	 * @var int
	 */
	protected $theme_prefix = 'corpopress';

	/**
	 * Construcor.
	 *
	 * @since 1.0
	 */
	function __construct() {

		$this->setup();
		$this->init();

	}

	/**
	 * Initial setup.
	 *
	 * @since 1.0
	 */
	function setup() {

		$support = get_theme_support( 'footer-widgets' );
		if ( empty( $support ) ) {
			return;
		}
		if ( absint( $support[0] ) < 1 ) {
			return;
		}
		$this->max_widgets = absint( $support[0] );
		$this->active_widgets = $this->get_number_of_active_widgets();

	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 */
	function init() {

		if ( $this->max_widgets < 1 ) {
			return;
		}

		// Register footer widgets.
		add_action( 'widgets_init', array( $this, 'footer_widgets_init' ), 22 );

		if ( $this->active_widgets > 0 ) {
			// Add footer widgets in front end.
			add_action( $this->theme_prefix . '_footer', array( $this, 'add_footer_widgets' ), 25 );
		}

	}

	/**
	 * Register footer widgets.
	 *
	 * @since 1.0
	 */
	function footer_widgets_init() {

		for ( $i = 1; $i <= $this->max_widgets; $i++ ) {
			register_sidebar( array(
				'name'          => sprintf( __( 'Footer Widget %d', 'corpopress' ), $i ),
				'id'            => sprintf( 'footer-%d', $i ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}

	}

	/**
	 * Returns number of active footer widgets.
	 *
	 * @since 1.0
	 *
	 * @return int Number of active widgets.
	 */
	private function get_number_of_active_widgets() {

		$count = 0;

		for ( $i = 1; $i <= $this->max_widgets; $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				$count++;
			}
		}

		return $count;

	}

	/**
	 * Add footer widgets content in front end.
	 *
	 * @since 1.0
	 */
	function add_footer_widgets() {

		$flag_apply_footer_widgets_content = apply_filters( $this->theme_prefix . '_filter_footer_widgets', true );
		if ( true !== $flag_apply_footer_widgets_content ) {
			return false;
		}

		$args = array(
		'container' => 'div',
		'before'    => '<div class="wrapper">',
		'after'     => '</div>',
		);
		$footer_widgets_content = $this->get_footer_widgets_content( $args );
		echo $footer_widgets_content;

	}

	/**
	 * Returns all active footer widgets number in array.
	 *
	 * @since 1.0
	 *
	 * @return array Active widgets
	 */
	function all_active_widgets() {

		$arr = array();

		for ( $i = 1; $i <= $this->max_widgets ; $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				$arr[] = $i;
			}
		}
		return $arr;

	}

	/**
	 * Returns footer widget contents.
	 *
	 * @since 1.0
	 *
	 * @param array $args Footer widget arguments.
	 */
	function get_footer_widgets_content( $args ) {

		$number = $this->active_widgets;
		$all_active_widgets = $this->all_active_widgets();

		// Default arguments.
		$args = wp_parse_args( (array) $args, array(
			'container'       => 'div',
			'container_class' => $this->custom_footer_widget_class( 'footer-widgets-area page-section' ),
			'container_style' => '',
			'container_id'    => '',
			'wrap_class'      => 'hentry',
			'before'          => '',
			'after'           => '',
		) );
		$args = apply_filters( $this->theme_prefix . '_filter_footer_widgets_args', $args );

		ob_start();
		$container_open = '';
		$container_close = '';

		if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
			$container_open = sprintf(
				'<%s %s %s %s>',
				$args['container'],
				( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"':'',
				( $args['container_id'] ) ? 'id="' . $args['container_id'] . '"':'',
				( $args['container_style'] ) ? 'style="' . esc_attr( $args['container_style'] ) . '"':''
			);
		}
		if ( ! empty( $args['container_class'] ) || ! empty( $args['container_id'] ) ) {
			$container_close = sprintf(
				'</%s>',
				$args['container']
			);
		}

		echo $container_open;

		echo $args['before'];

		for ( $i = 1; $i <= $number; $i++ ) {

			if ( isset( $all_active_widgets[ $i - 1 ] ) ) {
				$div_classes = $args['wrap_class'];
				$div_classes = trim( $div_classes );
				echo '<div class="' . esc_attr( $div_classes ) .  '">';
				$sidebar_name = 'footer-' . $all_active_widgets[ $i - 1 ];
				dynamic_sidebar( $sidebar_name );
				echo '</div><!-- .' . esc_attr( $args['wrap_class'] ) . ' -->';
			}

		} // End for loop.

		echo $args['after'];

		echo $container_close;

		$output = ob_get_contents();
		ob_end_clean();
		return $output;

	}

	/**
	 * Add custom class in widgets.
	 *
	 * @since 1.0
	 *
	 * @param string $input Class for footer widget column.
	 */
	function custom_footer_widget_class( $input ) {

		$footer_widgets_number = $this->active_widgets;

		$input .= ' col-' . $footer_widgets_number;

		return $input;

	}
}

// Initialize.
$corpopress_footer_widgets = new Corpopress_Footer_Widgets();
