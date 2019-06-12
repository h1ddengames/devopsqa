<?php
/**
 * class-documentation-documents-widget.php
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
 * Documents widget.
 */
class Documentation_Documents_Widget extends WP_Widget {

	/**
	 * @var string cache id
	 */
	static $cache_id = 'documentation_documents_widget';

	/**
	 * @var string cache flag
	 */
	static $cache_flag = 'widget';

	static $defaults = array(
		'number'       => 10,
		'order'        => 'DESC',
		'orderby'      => 'post_date',
		'show_author'  => false,
		'show_date'    => false,
		'show_comment_count' => false,
		'category_id'        => null,
	);

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
		self::$orderby_options = array(
			'post_author'   => __( 'Author', 'documentation' ),
			'post_date'     => __( 'Date', 'documentation' ),
			'post_title'    => __( 'Title', 'documentation' ),
			'comment_count' => __( 'Comment Count', 'documentation' ),
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
		register_widget( 'Documentation_Documents_Widget' );
	}

	/**
	 * Creates a documents widget.
	 */
	public function __construct() {
		parent::__construct( false, $name = 'Documents' );
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
			if ( $widget['name'] == 'Documents' ) {
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

		// number
		$settings['number'] = '';
		$number = trim( $new_instance['number'] );
		if ( !empty( $number ) ) {
			$number = intval( $number );
			if ( $number > 0 ) {
				$settings['number'] = $number;
			}
		}

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

		// category_id
		$category_id = trim( $new_instance['category_id'] );
		if ( empty( $category_id ) ) {
			unset( $settings['category_id'] );
		} else if ( ("[current]" == $category_id ) || ("{current}" == $category_id ) )  {
			$settings['category_id'] = "{current}";
		} else if ( $category = get_term( $category_id, 'document_category' ) && !is_wp_error( $category ) ) { 
			$settings['category_id'] = $category_id;
		}

		// show ...
		$settings['show_author']        = !empty( $new_instance['show_author'] );
		$settings['show_date']          = !empty( $new_instance['show_date'] );
		$settings['show_comment_count'] = !empty( $new_instance['show_comment_count'] );

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
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		echo '<p>';
		echo sprintf( '<label title="%s">', sprintf( __( 'The widget title.', 'documentation' ) ) );
		echo __( 'Title', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</label>';
		echo '</p>';

		// number
		$number = !empty( $instance['number'] ) ? intval( $instance['number'] ) : '';
		echo '<p>';
		echo sprintf( '<label title="%s" >', __( "The number of documents to show.", 'documentation' ) );
		echo __( 'Number of documents', 'documentation' );
		echo '<input class="widefat" id="' . $this->get_field_id( 'number' ) . '" name="' . $this->get_field_name( 'number' ) . '" type="text" value="' . esc_attr( $number ) . '" placeholder="' . esc_attr( __( 'All', 'documentation') ) . '"/>';
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

		// category_id
		$category_id = '';
		if ( isset( $instance['category_id'] ) ) {
			if ( ( '[current]' == strtolower( $instance['category_id'] ) ) || ( '{current}' == strtolower( $instance['category_id'] ) ) ) {
				$category_id = '{current}';
			} else {
				$category_id = $instance['category_id'];
			}
		}
		echo '<p>';
		echo sprintf(
			'<label title="%s">',
			__( "Leave empty to show documents in all document categories. To show documents in a specific category, indicate the category ID. To show documents in the current document category, indicate: {current} (when not on a document page, documents for all categories are displayed).", 'documentation' )
		);
		echo __( 'Category ID', 'documentation' ); 
		echo '<input class="widefat" id="' . $this->get_field_id( 'category_id' ) . '" name="' . $this->get_field_name( 'category_id' ) . '" type="text" value="' . esc_attr( $category_id ) . '" />';
		echo '</label>';
		echo '<br/>';
		echo '<span class="description">' . __( "Empty, document category ID or {current}", 'documentation' ) . '</span>';
		if ( !empty( $category_id ) && ( $category = get_term( $category_id, 'document_category' ) ) && !is_wp_error( $category ) ) {
			echo '<br/>';
			echo '<span class="description"> ' . sprintf( __( "Category: <em>%s</em>", 'documentation' ) , $category->name ) . '</span>';
		}
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

		// show_comment_count
		$checked = ( ( ( !isset( $instance['show_comment_count'] ) && self::$defaults['show_comment_count'] ) || ( isset( $instance['show_comment_count'] ) && ( $instance['show_comment_count'] === true ) ) ) ? 'checked="checked"' : '' );
		echo '<p>';
		echo sprintf( '<label title="%s">', __( "Whether to show the comment count for each document.", 'documentation' ) ); 
		echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $this->get_field_name( 'show_comment_count' ) . '" />';
		echo __( 'Show number of replies', 'documentation' );
		echo '</label>';
		echo '</p>';
	}

	public static function render( $instance ) {

		unset( $instance['title'] ); // remove so that get_posts() used in our render() doesn't filter posts by title

		$args = array_merge( $instance, array( 'post_type' => 'document' ) );

		if ( !empty( $args['number'] ) ) {
			$args['numberposts'] = $args['number'];
			unset( $args['number'] );
		} else {
			$args['numberposts'] = -1; // all
		}

		$show_author = isset( $args['show_author'] ) && $args['show_author'];
		unset( $args['show_author'] );

		$show_date = isset( $args['show_date'] ) && $args['show_date'];
		unset( $args['show_date'] );

		$show_comment_count = isset( $args['show_comment_count'] ) && $args['show_comment_count'];
		unset( $args['show_comment_count'] );

		// dumb but post_title won't work
		if ( isset( $args['orderby'] ) && ( $args['orderby'] == 'post_title' ) ) {
			$args['orderby'] = 'title';
		}

		if ( !empty( $args['category_id'] ) ) {
			if ( ( $args['category_id'] == '[current]' ) || $args['category_id'] == '{current}' ) {
				$category_id = null;
				global $wp_query;
				if ( $o = $wp_query->get_queried_object() ) {
					if ( isset( $o->taxonomy ) && ( $o->taxonomy == 'document_category' ) ) {
						$category_id = $o->term_id;
					}
				}
			} else {
				$category_id = $args['category_id'];
			}
			if ( $category_id ) {
				$args['tax_query'] = array(
					array(
						'taxonomy'         => 'document_category',
						'field'            => 'id',
						'terms'            => $category_id,
						'include_children' => false
					)
				);
			}
			unset( $args['category_id'] );
		}

		$output = '';
		$documents = get_posts( $args ); 
		if ( count( $documents ) > 0 ) {
			$output .= '<ul>';
			foreach( $documents as $document ) {
				$author = '';
				if ( $show_author ) {
					$author = ' ' . sprintf( '<span class="author">by %s</span>', get_the_author_meta('display_name', $document->post_author ) );
					// get_author_posts_url( $document->post_author )
				}
				$date = '';
				if ( $show_date ) {
					$date = sprintf(
						', <span class="date">%s</span>',
						mysql2date( get_option('date_format'), $document->post_date )
					);
				}
				$comment_count = '';
				if ( $show_comment_count ) {
					$comment_count = ', ' . '<span class="comment_count">' . sprintf( _n( '1 reply', '%d replies', $document->comment_count ), $document->comment_count ) . '</span>';
				}
				$output .= sprintf( '<li><a href="%s">%s</a>%s%s%s</li>', get_permalink( $document->ID ), wp_strip_all_tags( $document->post_title ), $author, $date, $comment_count );
			}
			$output .= '</ul>';
		} else {
			$output .= __( 'There are no documents.', 'documentation' );
		}
		return $output;
	}
}

Documentation_Documents_Widget::init();
