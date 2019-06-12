<?php
/**
 * class-documentation-shortcodes.php
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
 * Shortcode initialization.
 */
class Documentation_Shortcodes {

	/**
	 * Registers shortcode handlers.
	 */
	public static function init() {
		add_shortcode( 'documentation_documents', array( __CLASS__, 'documentation_documents' ) );
		add_shortcode( 'documentation_list_children', array( __CLASS__, 'documentation_list_children' ) );
		add_shortcode( 'documentation_hierarchy', array( __CLASS__, 'documentation_hierarchy' ) );
		add_shortcode( 'documentation_categories', array( __CLASS__, 'documentation_categories' ) );
	}

	/**
	 * 
	 * @param array $atts
	 * @param string $content
	 */
	public static function documentation_documents( $atts, $content = null ) {
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-renderer.php';
		return Documentation_Renderer::documents( $atts );
	}

	/**
	 * List children shortcode.
	 * 
	 * @param array $atts
	 * @param string $content (not used)
	 * @return string
	 */
	public static function documentation_list_children( $atts, $content = null ) {
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-renderer.php';
		return Documentation_Renderer::list_children( $atts );
	}

	/**
	 * Shortcode handler that produces a documentation hierarchy.
	 * 
	 * The following options are accepted through $atts:
	 * 
	 * - root_depth : number of levels to include from the root level, defaults to 1 including all documents at root level (without parents); set to 0 to hide all documents at root level except the parent of the current document
	 * - supernode_height : number of levels to include above the current document, defaults to 1
	 * - supernode_subnode_depth : number of levels to include below each supernode, defaults to 1
	 * - subnode_depth : number of levels to include below the current document, defaults to 1
	 * 
	 * @see Documentation_Renderer::document_hierarchy()
	 * 
	 * @param array $atts
	 * @param string $content (not used)
	 * @return string
	 */
	public static function documentation_hierarchy( $atts, $content = null ) {
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-renderer.php';
		return Documentation_Renderer::document_hierarchy( $atts );
	}

	/**
	 * Renders document categories.
	 * 
	 * Accepted attributes are:
	 * - child_of to indicate a category id and show its children, default is empty
	 * - depth indentation category depth, default is 0 for all, only used when hierarchical
	 * - hide_empty to hide empty categories, default is true
	 * - hierarchical to indent descendants, default is true
	 * - order ASC or DESC
	 * - orderby to order by name, slug, id or description; default is 'name'
	 * - show_count to show the number of entries per category
	 * 
	 * @param array $atts
	 * @param string $content (not used)
	 */
	public static function documentation_categories( $atts, $content = null ) {
		$defaults = array(
			'child_of'     => '',
			'depth'        => 0,
			'hide_empty'   => true,
			'hierarchical' => true,
			'order'        => 'ASC',
			'orderby'      => 'name',
			'show_count'   => false,
		);
		$atts = shortcode_atts( $defaults, $atts );
		$atts['echo'] = false;
		$atts['taxonomy'] = 'document_category';
		$atts['title_li'] = ''; // disable the list title
		$atts['child_of'] = trim( $atts['child_of'] );
		if ( $atts['child_of'] == '{current}' ) {
			$atts['child_of'] = '';
			if ( $queried_object = get_queried_object() ) {
				if ( isset( $queried_object->term_id ) ) {
					$atts['child_of'] = intval( $queried_object->term_id );
				}
			}
		} else {
			$key = $atts['child_of'];
			if ( !( $term = get_term_by( 'id', $key, 'document_category' ) ) ) {
				if ( !( $term = get_term_by( 'slug', $key, 'document_category' ) ) ) {
					$term = get_term_by( 'name', $key, 'document_category' );
				}
			}
			if ( $term ) {
				$atts['child_of'] = $term->term_id;
			}
		}
		$atts['depth'] = trim( $atts['depth'] );
		if ( !empty( $atts['depth'] ) ) {
			$atts['depth'] = intval( $atts['depth'] );
		}
		// evaluate booleans
		foreach( array( 'hide_empty', 'hierarchical', 'show_count' ) as $key ) {
			if ( !is_bool( $atts[$key] ) ) {
				$atts[$key] = trim( $atts[$key] );
				switch( strtolower( $atts[$key] ) ) {
					case 'false' :
					case 'no' :
					case '' :
						$atts[$key] = false;
						break;
					case 'true' :
					case 'yes' :
						$atts[$key] = true;
						break;
					default :
						$atts[$key] = $defaults[$key];
				}
			}
		}
		// orderby
		$atts['orderby'] = trim( $atts['orderby'] );
		switch( $atts['orderby'] ) {
			case 'name' :
			case 'slug' :
			case 'id' :
			case 'description' :
				break;
			default :
				$atts['orderby'] = 'name';
		}
		// order
		$atts['order'] = trim( strtoupper( $atts['order'] ) );
		switch( $atts['order'] ) {
			case 'ASC' :
			case 'DESC' :
				break;
			default :
				$atts['order'] = 'ASC';
		}
		return wp_list_categories( $atts );
	}
}
Documentation_Shortcodes::init();
