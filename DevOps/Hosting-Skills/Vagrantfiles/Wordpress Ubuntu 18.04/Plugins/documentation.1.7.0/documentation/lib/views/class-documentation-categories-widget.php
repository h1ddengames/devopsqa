<?php
/**
 * class-documentation-categories-widget.php
 *
 * Copyright (c) 2013 - 2017 "kento" Karim Rahimpur www.itthinx.com
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
 * @since documentation 1.5.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Document categories widget.
 *
 * Renders a list of links to the document categories.
 */
class Documentation_Categories_Widget extends WP_Widget {

	/**
	 * @var string cache id
	 */
	static $cache_id = 'documentation_categories_widget';

	/**
	 * @var string cache flag
	 */
	static $cache_flag = 'widget';

	/**
	 * Default values.
	 * @var array
	 */
	static $defaults = null;

	/**
	 * Sort criteria and labels.
	 * @var array
	 */
	static $orderby_options;

	/**
	 * Sort direction and labels.
	 * @var array
	 */
	static $order_options;

	/**
	 * Initialize.
	 */
	static function init() {

		self::$defaults = array(
			'child_of'           => 0,
			'depth'              => 0,
			'hide_empty'         => true,
			'hierarchical'       => true,
			'order'              => 'ASC',
			'orderby'            => 'name',
			'show_count'         => false
		);

		self::$orderby_options = array(
			'id'          => __( 'ID', 'documentation' ),
			'name'        => __( 'Name', 'documentation' ),
			'slug'        => __( 'Slug', 'documentation' ),
			'description' => __( 'Description', 'documentation' )
		);

		self::$order_options = array(
			'ASC'  => __( 'Ascending', 'documentation' ),
			'DESC' => __( 'Descending', 'documentation' )
		);

// 		if ( !has_action( 'wp_print_styles', array( __CLASS__, '_wp_print_styles' ) ) ) {
// 			add_action( 'wp_print_styles', array( __CLASS__, '_wp_print_styles' ) );
// 		}
		if ( !has_action( 'comment_post', array( __CLASS__, 'cache_delete' ) ) ) {
			add_action( 'comment_post', array(__CLASS__, 'cache_delete' ) );
		}
		if ( !has_action( 'transition_comment_status', array( __CLASS__, 'cache_delete' ) ) ) {
			add_action( 'transition_comment_status', array( __CLASS__, 'cache_delete' ) );
		}
		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );
	}

	/**
	 * Registers the widget.
	 */
	static function widgets_init() {
		register_widget( 'Documentation_Categories_Widget' );
	}

	/**
	 * Creates a documents widget.
	 */
	public function __construct() {
		parent::__construct( false, $name = 'Document Categories' );
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
			if ( $widget['name'] == 'Document Categories' ) {
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
	 * Look for a term by id, slug or name.
	 * @param string $key
	 * @return WP_Term or false
	 */
	private static function get_term( $key ) {
		if ( !( $term = get_term_by( 'id', $key, 'document_category' ) ) ) {
			if ( !( $term = get_term_by( 'slug', $key, 'document_category' ) ) ) {
				$term = get_term_by( 'name', $key, 'document_category' );
			}
		}
		return $term;
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

		// child_of
		$child_of = $new_instance['child_of'];
		if ( empty( $child_of ) ) {
			unset( $settings['child_of'] );
		} else if ( ("[current]" == $child_of ) || ("{current}" == $child_of ) )  {
			$settings['child_of'] = "{current}";
		} else {
			$term = get_term_by( 'id', $new_instance['child_of'], 'document_category' );
			if ( $term ) {
				$settings['child_of'] = $term->term_id;
			} else {
				$term = get_term_by( 'slug', $new_instance['child_of'], 'document_category' );
				if ( $term ) {
					$settings['child_of'] = $term->slug;
				} else {
					$term = get_term_by( 'name', $new_instance['child_of'], 'document_category' );
					if ( $term ) {
						$settings['child_of'] = $term->name;
					}
				}
			}
			if ( !$term ) {
				unset( $settings['child_of'] );
			}
		}

		// depth
		$depth = intval( $new_instance['depth'] );
		if ( $depth > 0 ) {
			$settings['depth'] = $depth;
		}

		// hide_empty
		$settings['hide_empty']   = !empty( $new_instance['hide_empty'] );

		// hierarchical
		$settings['hierarchical'] = !empty( $new_instance['hierarchical'] );

		// orderby
		$orderby = trim( $new_instance['orderby'] );
		if ( key_exists( $orderby, self::$orderby_options ) ) {
			$settings['orderby'] = $orderby;
		} else {
			unset( $settings['orderby'] );
		}

		// order
		$order = trim( $new_instance['order'] );
		if ( key_exists( $order, self::$order_options ) ) {
			$settings['order'] = $order;
		} else {
			unset( $settings['order'] );
		}

		// show_count
		$settings['show_count']   = !empty( $new_instance['show_count'] );

		$this->cache_delete();

		return $settings;
	}

	/**
	 * Output admin widget options form
	 * 
	 * @see WP_Widget::form()
	 */
	function form( $instance ) {

		extract( self::$defaults );

		// title
		$title = isset( $instance['title'] ) ? $instance['title'] : "";
		echo '<p>';
		echo sprintf( '<label title="%s">', sprintf( __( 'The widget title.', 'documentation' ) ) );
		echo __( 'Title', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</label>';
		echo '</p>';

		// child of
		$child_of = '';
		if ( isset( $instance['child_of'] ) ) {
			if ( ( '[current]' == strtolower( $instance['child_of'] ) ) || ( '{current}' == strtolower( $instance['child_of'] ) ) ) {
				$child_of = '{current}';
			} else {
				$child_of = $instance['child_of'];
			}
		}
		echo '<p>';
		echo sprintf(
			'<label title="%s">',
			__( "Leave empty to show all categories. To show children of a specific category, indicate the category name, slug or ID. To show those of the current category, indicate: {current}.", 'documentation' )
		);
		echo __( 'Children of &hellip;', 'documentation' ); 
		echo '<input class="widefat" id="' . $this->get_field_id( 'child_of' ) . '" name="' . $this->get_field_name( 'child_of' ) . '" type="text" value="' . esc_attr( $child_of ) . '" />';
		echo '</label>';
		echo '<br/>';
		echo '<span class="description">' . __( "Empty, category ID, slug, name or {current}", 'documentation' ) . '</span>';
		if ( !empty( $child_of ) && ( $term = self::get_term( $child_of ) ) ) {
			if ( !empty( $term->name ) ) {
				echo '<br/>';
				echo '<span class="description"> ' . sprintf( __( "Document Category: <em>%s</em>", 'documentation' ) , wp_strip_all_tags( $term->name ) ) . '</span>';
			}
		}
		echo '</p>';

		// depth
		$depth = isset( $instance['depth'] ) ? intval( $instance['depth'] ) : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( 'Levels to include from document category, 0 includes all, hierarchical must be enabled.', 'documentation' ) );
		echo __( 'Depth', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'depth' ) . '" name="' . $this->get_field_name( 'depth' ) . '" type="text" value="' . esc_attr( $depth ) . '" />';
		echo '</label>';
		echo '</p>';

		// hide_empty
		$checked = ( ( ( !isset( $instance['hide_empty'] ) && self::$defaults['hide_empty'] ) || ( isset( $instance['hide_empty'] ) && ( $instance['hide_empty'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to hide empty categories.", 'documentation' ) );
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'hide_empty' ) . '" />';
		echo __( 'Hide empty categories', 'documentation' );
		echo '</label>';
		echo '</p>';

		// hierarchical
		$checked = ( ( ( !isset( $instance['hierarchical'] ) && self::$defaults['hierarchical'] ) || ( isset( $instance['hierarchical'] ) && ( $instance['hierarchical'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to show a hierarchical list or tree, will be flat if disabled.", 'documentation' ) );
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'hierarchical' ) . '" />';
		echo __( 'Hierarchical', 'documentation' );
		echo '</label>';
		echo '</p>';

		// orderby
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : $orderby;
		echo '<p>';
		echo sprintf( '<label title="%s">', __( 'Sorting criteria.', 'documentation' ) );
		echo __( 'Order by ...', 'documentation' );
		echo '<select class="widefat" name="' . $this->get_field_name( 'orderby' ) . '">';
		foreach ( self::$orderby_options as $orderby_option_key => $orderby_option_name ) {
			$selected = ( $orderby_option_key == $orderby ? ' selected="selected" ' : "" );
			echo '<option ' . $selected . 'value="' . $orderby_option_key . '">' . $orderby_option_name . '</option>';
		}
		echo '</select>';
		echo '</label>';
		echo '</p>';

		// order
		$order = isset( $instance['order'] ) ? $instance['order'] : $order;
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Sort order.", 'documentation' ) );
		echo __( 'Sort order', 'documentation' );
		echo '<select class="widefat" name="' . $this->get_field_name( 'order' ) . '">';
		foreach ( self::$order_options as $order_option_key => $order_option_name ) {
			$selected = ( $order_option_key == $order ? ' selected="selected" ' : "" );
			echo '<option ' . $selected . 'value="' . $order_option_key . '">' . $order_option_name . '</option>';
		}
		echo '</select>';
		echo '</label>';
		echo '</p>';

		// show_count
		$checked = ( ( ( !isset( $instance['show_count'] ) && self::$defaults['show_count'] ) || ( isset( $instance['show_count'] ) && ( $instance['show_count'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to show the number of documents in each category.", 'documentation' ) );
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'show_count' ) . '" />';
		echo __( 'Show count', 'documentation' );
		echo '</label>';
		echo '</p>';

	}

	/**
	 * Render the widget.
	 * @param array $instance
	 */
	public static function render( $instance ) {
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-renderer.php';
		unset( $instance['title'] );
		return Documentation_Shortcodes::documentation_categories( $instance );
	}
}

Documentation_Categories_Widget::init();
