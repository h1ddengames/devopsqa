<?php
/**
 * class-documentation-document-hierarchy-widget.php
 *
 * Copyright (c) 2013 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package documentation
 * @since documentation 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Document hierarchy widget.
 * 
 * Lists the hierarchy of the current or a chosen document.
 */
class Documentation_Document_Hierarchy_Widget extends WP_Widget {

	/**
	 * @var string cache id
	 */
	static $cache_id = 'documentation_document_hierarchy_widget';

	/**
	 * @var string cache flag
	 */
	static $cache_flag = 'widget';

	static $defaults = null;

	/**
	 * Initialize.
	 */
	static function init() {

		self::$defaults = array(
			'root_depth'               => 1,
			'supernode_height'         => 1,
			'supernode_subnode_depth'  => 1,
			'subnode_depth'            => 1,
			// @todo maybe later
// 			'sort_order'         => 'ASC',
// 			'sort_column'        => 'menu_order,post_title',
// 			'show_author'        => false,
// 			'show_date'          => false
		);

		// @todo
// 		if ( !has_action( 'wp_print_styles', array( __CLASS__, '_wp_print_styles' ) ) ) {
// 			add_action( 'wp_print_styles', array( __CLASS__, '_wp_print_styles' ) );
// 		}

		// @todo we don't need these unless the comment counts are displayed
// 		if ( !has_action( 'comment_post', array( __CLASS__, 'cache_delete' ) ) ) {
// 			add_action( 'comment_post', array(__CLASS__, 'cache_delete' ) );
// 		}
// 		if ( !has_action( 'transition_comment_status', array( __CLASS__, 'cache_delete' ) ) ) {
// 			add_action( 'transition_comment_status', array( __CLASS__, 'cache_delete' ) );
// 		}

		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );
	}

	/**
	 * Registers the widget.
	 */
	static function widgets_init() {
		register_widget( 'Documentation_Document_Hierarchy_Widget' );
	}

	/**
	 * Creates a documents widget.
	 */
	public function __construct() {
		parent::__construct( false, $name = 'Document Hierarchy' );
	}

	/**
	 * Clears cached widget.
	 */
	static function cache_delete() {
		wp_cache_delete( self::$cache_id, self::$cache_flag );
	}

	/**
	 * Enqueue styles if at least one widget is used.
	 */
	static function _wp_print_styles() {
		global $wp_registered_widgets;
		foreach ( $wp_registered_widgets as $widget ) {
			if ( $widget['name'] == 'Document Hierarchy' ) {
				wp_enqueue_style( 'documents-widget', DOCUMENTATION_PLUGIN_URL . 'css/documents-widget.css', array(), DOCUMENTATION_CORE_VERSION );
				break;
			}
		}
	}

	/**
	 * Widget output
	 * 
	 * @see WP_Widget::widget()
	 * @link http://codex.wordpress.org/Class_Reference/WP_Object_Cache
	 */
	function widget( $args, $instance ) {
		$cache = wp_cache_get( self::$cache_id, self::$cache_flag );
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		$widget_id = $args['widget_id'];

		// output
		$output = '';
		$output .= $before_widget;
		if ( !empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}
		$output .= self::render( $instance );
		$output .= $after_widget;
		echo $output;

		$cache[$args['widget_id']] = $output;
		wp_cache_set( self::$cache_id, $cache, self::$cache_flag );
	}

	/**
	 * Save widget options
	 * 
	 * @see WP_Widget::update()
	 */
	function update( $new_instance, $old_instance ) {

		global $wpdb;

		$settings = $old_instance;

		// title
		$settings['title'] = strip_tags( $new_instance['title'] );

		$root_depth = intval( $new_instance['root_depth'] );
		if ( $root_depth >= 0 ) {
			$settings['root_depth'] = $root_depth;
		}

		$supernode_height = intval( $new_instance['supernode_height'] );
		if ( $supernode_height >= 0 ) {
			$settings['supernode_height'] = $supernode_height;
		}

		$supernode_subnode_depth = intval( $new_instance['supernode_subnode_depth'] );
		if ( $supernode_subnode_depth >= 0 ) {
			$settings['supernode_subnode_depth'] = $supernode_subnode_depth;
		}

		$subnode_depth = intval( $new_instance['subnode_depth'] );
		if ( $subnode_depth >= 0 ) {
			$settings['subnode_depth'] = $subnode_depth;
		}

		$this->cache_delete();

		return $settings;
	}

	/**
	 * Output admin widget options form
	 * 
	 * @see WP_Widget::form()
	 */
	function form( $instance ) {

		// title
		$title = isset( $instance['title'] ) ? $instance['title'] : "";
		echo '<p>';
		echo sprintf( '<label title="%s">', sprintf( __( 'The widget title.', 'documentation' ) ) );
		echo __( 'Title', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</label>';
		echo '</p>';

		$root_depth = isset( $instance['root_depth'] ) ? intval( $instance['root_depth'] ) : self::$defaults['root_depth'];
		echo '<p>';
		printf(
			'<label title="%s" >',
			__( "Show documents within the hierarchy from root documents (those without parents) to how many levels deep?", 'documentation' )
		);
		echo __( 'Root depth', 'documentation' );
		printf(
			'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
			esc_attr( $this->get_field_id( 'root_depth' ) ),
			esc_attr( $this->get_field_name( 'root_depth' ) ),
			esc_attr( $root_depth )
		);
		echo '</label>';
		echo '</p>';

		$supernode_height = isset( $instance['supernode_height'] ) ? intval( $instance['supernode_height'] ) : self::$defaults['supernode_height'];
		echo '<p>';
		printf(
			'<label title="%s" >',
			__( "Show parent documents above the current one up to how many levels?", 'documentation' )
		);
		echo __( 'Documents above', 'documentation' );
		printf(
			'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
			esc_attr( $this->get_field_id( 'supernode_height' ) ),
			esc_attr( $this->get_field_name( 'supernode_height' ) ),
			esc_attr( $supernode_height )
		);
		echo '</label>';
		echo '</p>';

		$supernode_subnode_depth = isset( $instance['supernode_subnode_depth'] ) ? intval( $instance['supernode_subnode_depth'] ) : self::$defaults['supernode_subnode_depth'];
		echo '<p>';
		printf(
			'<label title="%s" >',
			__( "Show child documents of parent documents above the current one up to how many levels deep?", 'documentation' )
		);
		echo __( 'Children of documents above', 'documentation' );
		printf(
			'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
			esc_attr( $this->get_field_id( 'supernode_subnode_depth' ) ),
			esc_attr( $this->get_field_name( 'supernode_subnode_depth' ) ),
			esc_attr( $supernode_subnode_depth )
		);
		echo '</label>';
		echo '</p>';

		$subnode_depth = isset( $instance['subnode_depth'] ) ? intval( $instance['subnode_depth'] ) : self::$defaults['subnode_depth'];
		echo '<p>';
		printf(
			'<label title="%s" >',
			__( "Show child documents of the current one up to how many levels deep?", 'documentation' )
		);
		echo __( 'Documents below', 'documentation' );
		printf(
			'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
			esc_attr( $this->get_field_id( 'subnode_depth' ) ),
			esc_attr( $this->get_field_name( 'subnode_depth' ) ),
			esc_attr( $subnode_depth )
		);
		echo '</label>';
		echo '</p>';
	}

	/**
	 * Render the widget.
	 * @param array $instance
	 * @return string
	 */
	public static function render( $instance ) {
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-renderer.php';
		unset( $instance['title'] );
		return Documentation_Renderer::document_hierarchy( $instance );
	}
}

Documentation_Document_Hierarchy_Widget::init();
