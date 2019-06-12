<?php
/**
 * class-documentation-document-children-widget.php
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
 * Document children widget.
 * 
 * Lists the children of the current or a chosen document.
 */
class Documentation_Document_Children_Widget extends WP_Widget {

	/**
	 * @var string cache id
	 */
	static $cache_id = 'documentation_document_children_widget';

	/**
	 * @var string cache flag
	 */
	static $cache_flag = 'widget';

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
			'exclude'            => '',
			'include'            => '',
			'sort_order'         => 'ASC',
			'sort_column'        => 'menu_order,post_title',
// 			'title_li'           => __( 'Documents', 'documentation' ),
			'show_author'        => false,
			'show_date'          => false
		);

		self::$orderby_options = array(
			'ID'            => __( 'ID', 'documentation' ),
			'menu_order'    => __( 'Order', 'documentation' ),
			'post_author'   => __( 'Author', 'documentation' ),
			'post_date'     => __( 'Date', 'documentation' ),
			'post_title'    => __( 'Title', 'documentation' )
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
		register_widget( 'Documentation_Document_Children_Widget' );
	}

	/**
	 * Creates a documents widget.
	 */
	public function __construct() {
		parent::__construct( false, $name = 'Document Children' );
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
			if ( $widget['name'] == 'Document Children' ) {
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
		
		// child of ...
		$child_of = $new_instance['child_of'];
		if ( empty( $child_of ) ) {
			unset( $settings['child_of'] );
		} else if ( ("[current]" == $child_of ) || ("{current}" == $child_of ) )  {
			$settings['child_of'] = "{current}";
		} else if ( $post = get_post( $child_of ) && ( $post !== null ) ) { 
			$settings['child_of'] = $child_of;
		}

		// depth
		$depth = intval( $new_instance['depth'] );
		if ( $depth > 0 ) {
			$settings['depth'] = $depth;
		}

		// exclude
		$exclude = array_map( 'trim', explode( ',', $new_instance['exclude'] ) );
		if ( count( $exclude ) > 0 ) {
			$settings['exclude'] = implode( ',', $exclude );
		} else {
			unset( $settings['exclude'] );
		}

		// include
		$include = array_map( 'trim', explode( ',', $new_instance['include'] ) );
		if ( count( $include ) > 0 ) {
			$settings['include'] = implode( ',', $include );
		} else {
			unset( $settings['include'] );
		}

		// sort_column
		$columns = array( 'trim', explode( ',', $new_instance['sort_column'] ) );
		$sort_column = array();
		foreach( $columns as $column ) {
			switch( $column ) {
				case 'post_title' :
				case 'menu_order' :
				case 'post_date' :
				case 'post_modified' :
				case 'ID' :
				case 'post_author' :
				case 'post_name' :
					$sort_column[] = $column;
					break;
			}
		}
		if ( count( $sort_column )  > 0 ) {
		$settings['sort_column'] = implode( ',', $sort_column );
		} else {
			unset( $settings['sort_column'] );
		}

		// sort order
		$sort_order = $new_instance['sort_order'];
		if ( key_exists( $sort_order, self::$order_options ) ) {
			$settings['sort_order'] = $sort_order;
		} else {
			unset( $settings['sort_order'] );
		}

		// show ...
		$settings['show_author']        = !empty( $new_instance['show_author'] );
		$settings['show_date']          = !empty( $new_instance['show_date'] );

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
			__( "Leave empty to show all documents. To show child documents for a specific document, indicate the document ID. To show child documents for the current document, indicate: {current}.", 'documentation' )
		);
		echo __( 'Children of ...', 'documentation' ); 
		echo '<input class="widefat" id="' . $this->get_field_id( 'child_of' ) . '" name="' . $this->get_field_name( 'child_of' ) . '" type="text" value="' . esc_attr( $child_of ) . '" />';
		echo '</label>';
		echo '<br/>';
		echo '<span class="description">' . __( "Empty, document ID or {current}", 'documentation' ) . '</span>';
		if ( !empty( $child_of ) && ( $post = get_post( $child_of ) ) && ( $post !== null ) ) {
			echo '<br/>';
			echo '<span class="description"> ' . sprintf( __( "Document: <em>%s</em>", 'documentation' ) , wp_strip_all_tags( $post->post_title ) ) . '</span>';
		}
		echo '</p>';
		
		// depth
		$depth = isset( $instance['depth'] ) ? intval( $instance['depth'] ) : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( "Show documents within the hierarchy to how many levels deep?", 'documentation' ) );
		echo __( 'Sublevel depth', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'depth' ) . '" name="' . $this->get_field_name( 'depth' ) . '" type="text" value="' . esc_attr( $depth ) . '" />';
		echo '</label>';
		echo '</p>';
		
		// orderby
// 		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
// 		echo '<p>';
// 		echo sprintf( '<label title="%s">', __( 'Sorting criteria.', 'documentation' ) );
// 		echo __( 'Order by ...', 'documentation' );
// 		echo '<select class="widefat" name="' . $this->get_field_name( 'orderby' ) . '">';
// 		foreach ( self::$orderby_options as $orderby_option_key => $orderby_option_name ) {
// 			$selected = ( $orderby_option_key == $orderby ? ' selected="selected" ' : "" );
// 			echo '<option ' . $selected . 'value="' . $orderby_option_key . '">' . $orderby_option_name . '</option>'; 
// 		}
// 		echo '</select>';
// 		echo '</label>';
// 		echo '</p>';
		
		$sort_columns = isset( $instance['sort_columns'] ) ? $instance['sort_columns'] : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( "Sorting criteria, one or more options separated by comma. Possible choices are post_title, menu_order, post_date, post_modified, ID, post_author and post_name.", 'documentation' ) );
		echo __( 'Order by ...', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'sort_column' ) . '" name="' . $this->get_field_name( 'sort_column' ) . '" type="text" value="' . esc_attr( $sort_column ) . '" />';
		echo '</label>';
		echo '</p>';

		// order
		$order = isset( $instance['sort_order'] ) ? $instance['sort_order'] : '';
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Sort order.", 'documentation' ) );
		echo __( 'Sort order', 'documentation' );
		echo '<select class="widefat" name="' . $this->get_field_name( 'sort_order' ) . '">';
		foreach ( self::$order_options as $order_option_key => $order_option_name ) {
			$selected = ( $order_option_key == $order ? ' selected="selected" ' : "" );
			echo '<option ' . $selected . 'value="' . $order_option_key . '">' . $order_option_name . '</option>'; 
		}
		echo '</select>';
		echo '</label>';
		echo '</p>';

		$include = isset( $instance['include'] ) ? $instance['include'] : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( "List of documents to include, indicate document IDs separated by comma.", 'documentation' ) );
		echo __( 'Include documents', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'include' ) . '" name="' . $this->get_field_name( 'include' ) . '" type="text" value="' . esc_attr( $include ) . '" />';
		echo '</label>';
		echo '</p>';

		$exclude = isset( $instance['exclude'] ) ? $instance['exclude'] : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( "List of documents to exclude, indicate document IDs separated by comma.", 'documentation' ) );
		echo __( 'Exclude documents', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'exclude' ) . '" name="' . $this->get_field_name( 'exclude' ) . '" type="text" value="' . esc_attr( $exclude ) . '" />';
		echo '</label>';
		echo '</p>';

		// show_author
		$checked = ( ( ( !isset( $instance['show_author'] ) && self::$defaults['show_author'] ) || ( isset( $instance['show_author'] ) && ( $instance['show_author'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to show the author of each document.", 'documentation' ) ); 
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'show_author' ) . '" />';
		echo __( 'Show author', 'documentation' );
		echo '</label>';
		echo '</p>';
		
		// show_date
		$checked = ( ( ( !isset( $instance['show_date'] ) && self::$defaults['show_date'] ) || ( isset( $instance['show_date'] ) && ( $instance['show_date'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to show the date of each document.", 'documentation' ) );
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'show_date' ) . '" />';
		echo __( 'Show date', 'documentation' );
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
		return Documentation_Renderer::list_children( $instance );
	}
}

Documentation_Document_Children_Widget::init();
