<?php
/**
 * class-documentation-post-type.php
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
 * Documentation post type.
 */
class Documentation_Post_Type {

	const THE_CONTENT_FILTER_PRIORITY = 0;

	/**
	 * Sets up the init hook.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		//add_action( 'save_post', array( __CLASS__, 'save_post' ), 10, 2 );
		add_filter( 'comments_open', array( __CLASS__, 'comments_open' ), 10, 2 );
		//add_action( 'comment_form_comments_closed', array( __CLASS__, 'comment_form_comments_closed' ) );
		add_filter( 'the_content', array( __CLASS__, 'the_content' ), apply_filters( 'documentation_the_content_filter_priority', self::THE_CONTENT_FILTER_PRIORITY ) );
		add_filter( 'post_updated_messages', array( __CLASS__, 'post_updated_messages' ) );
		add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'use_block_editor_for_post_type' ), 10, 2 );
	}

	/**
	 * Invoke registration.
	 */
	public static function wp_init() {
		self::post_type();
	}

	/**
	 * Determines whether the block editor is used for our post type.
	 *
	 * @param boolean $use
	 * @param string $post_type
	 *
	 * @return boolean
	 */
	public static function use_block_editor_for_post_type( $use, $post_type ) {
		$options = Documentation::get_options();
		$document_use_block_editor = isset( $options['document_use_block_editor'] ) ? $options['document_use_block_editor'] : true;
		return $document_use_block_editor;
	}

	/**
	 * Register the documentation post type.
	 */
	public static function post_type() {

		$options = Documentation::get_options();
		$document_comments_open = isset( $options['document_comments_open'] ) ? $options['document_comments_open'] : true;
		$document_slug = isset( $options['document_slug'] ) ? $options['document_slug'] : '';

		$supports = array(
			'author',
			'editor',
			'page-attributes',
			'revisions',
			'title',
			'thumbnail'
		);

		if ( $document_comments_open ) {
			$supports[] = 'comments';
		}

		register_post_type(
			'document',
			array(
				'labels' => array(
					'name'               => __( 'Documents', 'documentation' ),
					'singular_name'      => __( 'Document', 'documentation' ),
					'all_items'          => __( 'All Documents', 'documentation' ),
					'add_new'            => __( 'New Document', 'documentation' ),
					'add_new_item'       => __( 'Add New Document', 'documentation' ),
					'archives'           => __( 'Document Archives', 'documentation' ),
					'edit'               => __( 'Edit', 'documentation' ),
					'edit_item'          => __( 'Edit Document', 'documentation' ),
					'filter_items_list'  => __( 'Filter documents list', 'documentation' ),
					'new_item'           => __( 'New Document', 'documentation' ),
					'not_found'          => __( 'No Documents found', 'documentation' ),
					'not_found_in_trash' => __( 'No Documents found in trash', 'documentation' ),
					'parent'             => __( 'Parent Document', 'documentation' ),
					'search_items'       => __( 'Search Documents', 'documentation' ),
					'view'               => __( 'View Document', 'documentation' ),
					'view_item'          => __( 'View Document', 'documentation' ),
					'view_items'         => __( 'View Documents', 'documentation' ),
				),
// 				'capability_type'     => 'document', // @todo if used we need to assign them appropriately so at least admins have them, or use roles/groups; add-ons menu capability must be adjusted if changed
				'description'         => __( 'Document', 'documentation' ),
				'exclude_from_search' => false, // this option is unreliable, see http://core.trac.wordpress.org/ticket/17592
				'has_archive'         => true,
				'hierarchical'        => true,
				'map_meta_cap'        => true,
// 				'menu_position'       => 10,
				'menu_icon'           => DOCUMENTATION_PLUGIN_URL . '/images/documentation.png',
				'public'              => true,
				'publicly_queryable'  => true,
				'query_var'           => true,
				'rewrite'             => empty( $document_slug ) ? true : array( 'slug' => $document_slug ),
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'show_ui'             => true,
				'supports'            => $supports,
				'taxonomies' => array( 'document_category', 'document_tag' )
			)
		);
	}

	/**
	 * Hooked on the post_updated_messages filter to customize messages for our document post type.
	 * @param array $messages
	 */
	public static function post_updated_messages( $messages ) {
		global $post, $post_ID;

		$permalink = get_permalink( $post_ID );
		if ( ! $permalink ) {
			$permalink = '';
		}
		$preview_url = get_preview_post_link( $post );
		/* translators: Publish box date format, see https://secure.php.net/date */
		$scheduled_date = date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) );

		$preview_post_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview document', 'documentation' )
		);
		$scheduled_post_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $permalink ),
			__( 'Preview document', 'documentation' )
		);
		$view_post_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( $permalink ),
			__( 'View document', 'documentation' )
		);

		$messages['document'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Document updated.', 'documentation' ) . $view_post_link_html,
			2 => __( 'Custom field updated.', 'documentation' ),
			3 => __( 'Custom field deleted.', 'documentation' ),
			4 => __( 'Document updated.', 'documentation' ),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __( 'Document restored to revision from %s.', 'documentation' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __( 'Document published.', 'documentation' ) . $view_post_link_html,
			7 => __( 'Document saved.', 'documentation' ),
			8 => __( 'Document submitted.', 'documentation' ) . $preview_post_link_html,
			9 => sprintf( __( 'Document scheduled for: %s.', 'documentation' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_post_link_html,
			10 => __( 'Document draft updated.', 'documentation' ) . $preview_post_link_html,
		);
		return $messages;
	}

	/**
	 * Returns true if the current or the indicated post is a document.
	 * @return boolean
	 */
	public static function is_document( $post = null ) {
		global $wp_query;
		$result = false;
		if ( $post === null ) {
			$queried_object = $wp_query->get_queried_object();
			if ( $queried_object instanceof WP_Post ) {
				if ( $queried_object->post_type == 'document' ) {
					$result = true;
				}
			}
		} else {
			$result = 'document' == get_post_type( $post );
		}
		return $result;
	}

	/**
	 * Process data for post being saved.
	 * Currently not used.
	 * @param int $post_id
	 * @param object $post
	 */
	public static function save_post( $post_id = null, $post = null) {
		if ( ! ( ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) ) ) {
			if ( $post->post_type == 'topic' ) {

// 				$foo = isset( $_POST['foo'] ) ? check_foo( $_POST['foo'] : null;
// 				update_post_meta( $post_id, '_foo', $foo );

			}
		}
	}

	/**
	 * Determine whether comments are open.
	 * 
	 * @param boolean $open
	 * @param int $post_id
	 * @return boolean
	 */
	public static function comments_open( $open, $post_id ) {
		if ( self::is_document( $post_id ) ) {
			$options = Documentation::get_options();
			$open = $open && ( isset( $options['document_comments_open'] ) ? $options['document_comments_open'] : true );
		}
		return $open;
	}

	/**
	 * Triggered when comments are closed.
	 * Currently not used.
	 */
	public static function comment_form_comments_closed() {
	}

	/**
	 * Replacements to allow showing shortcodes within [[]] even though the
	 * shortcode does not exist.
	 * "[[" is replaced by "&#91;" and "]]" is replaced by "&#93;".
	 *
	 * @param string $content
	 * @return string
	 */
	public static function the_content( $content ) {
		if ( $post_type = get_post_type() ) {
			if ( $post_type == 'document' ) {
				if ( apply_filters( 'documentation_filter_the_content', true ) ) {
					// WordPress' content_save_pre and excerpt_save_pre filters already apply wp_filter_post_kses().
					// We only do our replacements to avoid the doubles appearing in documents.
					$content = str_replace( '[[', '&#91;', $content );
					$content = str_replace( ']]', '&#93;', $content );
				}
			}
		}
		return $content;
	}
}
Documentation_Post_Type::init();
