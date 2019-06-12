<?php
/**
 * class-documentation-renderer.php
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
class Documentation_Renderer {

	/**
	 * Nothing really.
	 */
	public static function init() {
	}

	public static function documents( $atts = array() ) {

		if ( !is_array( $atts ) ) {
			$atts = array();
		}

		$atts = shortcode_atts(
			array(
				'category_id' => null,
				'number'             => -1, // unlimited
				'order'              => 'ASC',
				'orderby'            => 'title',
				'show_author'        => 'no',
				'show_comment_count' => 'no',
				'show_date'          => 'no'
			),
			$atts
		);
		
		foreach( $atts as $key => $value ) {
			switch( $key ) {
				case 'category_id' :
					if ( $value != '[current]' && $value != '{current}' ) {
						$value = implode( ',', array_map( 'intval', explode( ',', $value ) ) );
					}
					break;
				case 'number' :
					$value = intval( $value );
					if ( $value <= 0 ) {
						$value = -1;
					}
					break;
				case 'order' :
					$value = strtoupper( $value );
					switch( $value ) {
						case 'ASC' :
						case 'DESC' :
							break;
						default :
							$value = null;
					}
					break;
				case 'orderby' :
					$value = strtolower( $value );
					switch( $value ) {
						case 'name' :
						case 'author' :
						case 'date' :
						case 'title' :
						case 'modified' :
						case 'menu_order' :
						case 'parent' :
						case 'id' :
						case 'rand' :
						case 'comment_count' :
							break;
						default :
							$value = 'title';
					}
					break;
				case 'show_author' :
				case 'show_comment_count' :
				case 'show_date' :
					$value = strtolower( $value );
					$value = $value == 'true' || $value == 'yes' || $value == '1';
					break;
				default :
					$value = null;
			}
			if ( $value !== null ) {
				$atts[$key] = $value;
			} else {
				unset( $atts[$key] );
			}
		}

		$args = array_merge( $atts, array( 'post_type' => 'document' ) );

		if ( isset( $args['number'] ) ) {
			$args['numberposts'] = $args['number'];
			unset( $args['number'] );
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
					$author = ' ' . sprintf( '<span class="author">by %s</span>', get_the_author_meta( 'display_name', $document->post_author ) );
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

	/**
	 * List children.
	 * 
	 * @param array $atts
	 * 
	 * @return string
	 * 
	 * @uses wp_list_pages
	 * @link http://codex.wordpress.org/Function_Reference/wp_list_pages
	 */
	public static function list_children( $atts = array() ) {

		if ( !is_array( $atts ) ) {
			$atts = array();
		}

		$atts['echo']      = false;
		if ( !isset( $atts['title_li'] ) ) {
			$atts['title_li']  = '';
		}

		$atts['post_type'] = 'document';

		if ( isset( $atts['child_of'] ) && ( $atts['child_of'] == '{current}' ) ) {
			$atts['child_of'] = get_the_ID();
		}

		$result  = apply_filters(
			'documentation_list_children_prefix',
			'<div class="documentation">' .
			'<ul>'
		);
		$result .= wp_list_pages( $atts );
		$result .= apply_filters(
			'documentation_list_children_suffix',
			'</ul>' .
			'</div>' // .documentation
		);
		return $result;
	}

	/**
	 * Document hierarchy renderer.
	 * 
	 * Used to display a document hierarchy which can be easily understood and
	 * navigated through, for example when we want to display the current
	 * relevant sublevels within the document hierarchy.
	 * 
	 * Attributes:
	 * 
	 * - root_node @todo consider later
	 * - root_depth : number of levels to include from the root level, defaults to 1 including all documents at root level (without parents); set to 0 to hide all documents at root level except the parent of the current document 
	 * - supernode_height : number of levels to include above the current document, defaults to 1
	 * - supernode_subnode_depth : number of levels to include below each supernode, defaults to 1
	 * - subnode_depth : number of levels to include below the current document, defaults to 1
	 * 
	 * // @todo support for heading scanning is not implemented yet
	 * - scan_headings : whether to scan the current document's heading, defaults to false; if set to true, headings are displayed as a sublevel hierarchy
	 * - create_heading_anchors : if scan_headings is enabled, creates anchors for headings and links the headings-based sublevel hierarchy
	 * - min_heading : minimum heading level to take into account, defaults to 1 for h1
	 * - max_heading : maximum heading level to take into account, defaults to 3 for h3 
	 * 
	 * Notes:
	 * 
	 * - Where "root level" is mentioned, by default this means documents that have no parents.
	 * - The default "root node" is the virtual document with ID 0 that is assumed to be the parent of all documents without a parent document.
	 * 
	 * @param array $atts
	 * @return string
	 */
	public static function document_hierarchy( $atts = array() ) {

		global $wp_query;

		if ( !is_array( $atts ) ) {
			$atts = array();
		}

		//$root_node = isset( $atts['root_node'] ) ? max( 0, intval( $atts['root_node'] ) ) : 0;
		$root_node = 0;
		$root_depth = isset( $atts['root_depth'] ) ? max( 0, intval( $atts['root_depth'] ) ) : 1;
		$supernode_height = isset( $atts['supernode_height'] ) ? max( 0, intval( $atts['supernode_height'] ) ) : 1;
		$supernode_subnode_depth = isset( $atts['supernode_subnode_depth'] ) ? max( 0, intval( $atts['supernode_subnode_depth'] ) ) : 1;
		$subnode_depth = isset( $atts['subnode_depth'] ) ? max( 0, intval( $atts['subnode_depth'] ) ) : 1;

		$scan_headings = isset( $atts['scan_headings'] ) ? $atts['scan_headings'] != false : true;
		$create_heading_anchors = isset( $atts['create_heading_anchors'] ) ? $atts['create_heading_anchors'] != false : true;
		$min_heading = isset( $atts['min_heading'] ) ? max( 1, intval( $atts['min_heading'] ) ) : 1;
		$max_heading = isset( $atts['max_heading'] ) ? max( 1, intval( $atts['max_heading'] ) ) : 3;

		// Build the document index that relates document parents and children.
		// Root documents are at $document_index[0]['children'].
		$document_index = array();
		$documents = get_pages( array( 'post_type' => 'document' ) );
		foreach( $documents as $document ) {
			$document_index[$document->ID]['post_parent'] = $document->post_parent;
			$document_index[$document->post_parent]['children'][] = $document->ID;
		}

		$document_id = null;
		$queried_object = $wp_query->get_queried_object();
		if ( $queried_object instanceof WP_Post ) {
			if ( $queried_object->post_type == 'document' ) {
				$document_id = $queried_object->ID;
			}
		}

		// retrieve subnodes from root level
		$root_subnodes = array();
		self::get_subnodes( $document_index, $root_node, $root_depth, $root_subnodes );

		if ( $document_id ) {
			// retrieve all supernodes up to root level
			$supernodes = array();
			self::get_supernodes( $document_index, $document_id, null, $supernodes );

			// ... and add the subnodes of all these supernodes
			$supernode_subnodes = array();
			foreach( $supernodes as $supernode ) {
				self::get_subnodes( $document_index, $supernode, $supernode_subnode_depth, $supernode_subnodes );
			}

			// get the subnodes of the current document
			$subnodes = array();
			self::get_subnodes( $document_index, $document_id, $subnode_depth, $subnodes );

			// node union
			$nodes = array_unique(
				array_merge(
					$root_subnodes,
					$supernodes,
					$subnodes,
					$supernode_subnodes
				),
				SORT_NUMERIC
			);
		} else {
			$nodes = $root_subnodes;
		}

		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-walker-document.php';

		return
			'<div class="documentation-hierarchy">' .
			'<ul>' .
			self::list_documents( array(
				'echo'      => false,
				'include'   => $nodes,
				'post_type' => 'document',
				'title_li'  => '',
				'walker'    => new Documentation_Walker_Document()
			) ) .
			'</ul>' .
			'</div>'; // .documentation-hierarchy

	}

	/**
	 * Returns an array containing the IDs of all subnodes for the ID
	 * of the starting node provided in $node.
	 * 
	 * Starting Node children and children of subnodes are included.
	 * 
	 * @param array $hierarchy
	 * @param int $node ID of the starting node
	 * @param int $height number of subnode levels to take into account
	 * @param array $nodes resulting subnodes
	 * @return array of node IDs returned in $nodes
	 */
	private static function get_subnodes( &$hierarchy, $node, $depth, &$nodes = array() ) {
		if ( ( $depth === null ) || ( $depth >= 0 ) ) {
			if ( isset( $hierarchy[$node] ) ) {
				if ( !in_array( $node, $nodes ) ) {
					$nodes[] = $node;
				}
				if ( !empty( $hierarchy[$node]['children'] ) ) {
					foreach( $hierarchy[$node]['children'] as $child ) {
						self::get_subnodes( $hierarchy, $child, ( $depth !== null ? $depth - 1 : null ), $nodes );
					}
				}
			}
		}
	}

	/**
	 * Returns an array containing the IDs of all supernodes for the ID
	 * of the starting node provided in $node.
	 * 
	 * No children of supernodes are included.
	 * 
	 * @param array $hierarchy
	 * @param int $node ID of the starting node
	 * @param int $height number of supernode levels to take into account
	 * @param array $nodes resulting supernodes
	 * @return array of node IDs returned in $nodes
	 */
	private static function get_supernodes( &$hierarchy, $node, $height, &$nodes = array() ) {
		if ( ( $height === null ) || ( $height >= 0 ) ) {
			if ( isset( $hierarchy[$node] ) ) {
				if ( !in_array( $node, $nodes ) ) {
					$nodes[] = $node;
				}
				if ( !empty( $hierarchy[$node]['post_parent'] ) ) {
					self::get_supernodes( $hierarchy, $hierarchy[$node]['post_parent'], $height !== null ? $height - 1 : null, $nodes );
				}
			}
		}
	}

	/**
	 * Adapted from wp_list_pages() for our document post type.
	 *  
	 * @see wp_list_pages()
	 * @param string|array $args
	 * @return string|null echoes output by default; determined by the value of 'echo' in $args
	 */
	private static function list_documents( $args = '' ) {

		$defaults = array(
			'depth' => 0,
			'show_date' => '',
			'date_format' => get_option('date_format'),
			'child_of' => 0,
			'exclude' => '',
			'title_li' => __( 'Documents', 'documentation' ),
			'echo' => 1,
			'authors' => '',
			'sort_column' => 'menu_order, post_title',
			'link_before' => '',
			'link_after' => '',
			'walker' => '',
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$output = '';
		$current_page = 0;

		// sanitize, mostly to keep spaces out
		$r['exclude'] = preg_replace( '/[^0-9,]/', '', $r['exclude'] );

		// Allow plugins to filter an array of excluded pages (but don't put a nullstring into the array)
		$exclude_array = ( $r['exclude'] ) ? explode( ',', $r['exclude'] ) : array();
		$r['exclude'] = implode( ',', apply_filters( 'wp_list_pages_excludes', $exclude_array ) );

		// Query pages.
		$r['hierarchical'] = 0;
		$pages = get_pages( $r );

		if ( !empty($pages) ) {
			if ( $r['title_li'] ) {
				$output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';
			}

			global $wp_query;
			if ( Documentation_Post_Type::is_document() ) {
				$current_page = $wp_query->get_queried_object_id();
			}
			$output .= walk_page_tree( $pages, $r['depth'], $current_page, $r );

			if ( $r['title_li'] ) {
				$output .= '</ul></li>';
			}
		}

		$output = apply_filters( 'wp_list_pages', $output, $r );

		if ( $r['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
	}

}
Documentation_Renderer::init();
