<?php
/**
 * class-documentation-search.php
 *
 * Copyright (c) 2014 "kento" Karim Rahimpur www.itthinx.com
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
 * @since 1.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Documentation search facilities.
 */
class Documentation_Search {

	const SEARCH_TOKEN  = 'document-search';
	const SEARCH_QUERY  = 'document-query';
	const LIMIT         = 'limit';
	const DEFAULT_LIMIT = 10;
	const TITLE         = 'title';
	const EXCERPT       = 'excerpt';
	const CONTENT       = 'content';
	const ORDER         = 'order';
	const ORDER_BY      = 'order_by';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_shortcode( 'documentation_search_form', array( __CLASS__, 'documentation_search_form' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) );
// 		add_action( 'wp_ajax_document_search', array( __CLASS__, 'ajax' ) );
// 		add_action( 'wp_ajax_nopriv_document_Search', array( __CLASS__, 'ajax' ) );

	}

	public static function wp_enqueue_scripts() {
		wp_register_script( 'typewatch', DOCUMENTATION_PLUGIN_URL . 'js/jquery.typewatch.js', array( 'jquery' ), DOCUMENTATION_CORE_VERSION, true );
		wp_register_script( 'document-search', DOCUMENTATION_PLUGIN_URL . 'js/document-search.js', array( 'jquery', 'typewatch' ), DOCUMENTATION_CORE_VERSION, true );
		wp_register_style( 'document-search', DOCUMENTATION_PLUGIN_URL . 'css/document-search.css', array(), DOCUMENTATION_CORE_VERSION );
	}

	/**
	 * Handles a search request and renders results as JSON encoded string.
	 * @todo add order options
	 */
	public static function wp_init() {

		if ( isset( $_REQUEST[self::SEARCH_TOKEN] ) && !empty( $_REQUEST[self::SEARCH_QUERY] ) ) {

			global $wpdb;

			$title       = isset( $_REQUEST[self::TITLE] ) ? intval( $_REQUEST[self::TITLE] ) > 0 : true;
			$excerpt     = isset( $_REQUEST[self::EXCERPT] ) ? intval( $_REQUEST[self::EXCERPT] ) > 0 : false;
			$content     = isset( $_REQUEST[self::CONTENT] ) ? intval( $_REQUEST[self::CONTENT] ) > 0 : false;
			$limit       = isset( $_REQUEST[self::LIMIT] ) ? intval( $_REQUEST[self::LIMIT] ) : self::DEFAULT_LIMIT;
			$numberposts = intval( apply_filters( 'documentation_search_limit', $limit ) );

			$order       = isset( $_REQUEST[self::ORDER] ) ? strtoupper( trim( $_REQUEST[self::ORDER] ) ) : 'DESC';
			switch( $order ) {
				case 'DESC' :
				case 'ASC' :
					break;
				default :
					$order = 'ASC';
			}
			$order_by    = isset( $_REQUEST[self::ORDER_BY] ) ? strtolower( trim( $_REQUEST[self::ORDER_BY] ) ) : 'date';
			switch( $order_by ) {
				case 'date' :
				case 'title' :
				case 'ID' :
				case 'rand' :
					break;
				default :
					$order_by = 'title';
			}

			if ( !$title && !$excerpt && !$content ) {
				$title = true;
			}

			// We are using prepare, just apply esc_like ...
			if ( method_exists( $wpdb, 'esc_like' ) ) {
				$like = '%' . $wpdb->esc_like( $_REQUEST[self::SEARCH_QUERY] ) . '%';
			} else {
				$like = '%' . like_escape( $_REQUEST[self::SEARCH_QUERY] ) . '%';
			}
			// ... otherwise (if not using prepare) we must also esc_sql:
			// $like = '%' . esc_sql( like_escape( $_REQUEST[self::SEARCH_QUERY] ) ) . '%';

			$args   = array();
			$params = array();
			if ( $title ) {
				$args[] = ' post_title LIKE %s ';
				$params[] = $like;
			}
			if ( $excerpt ) {
				$args[] = ' post_excerpt LIKE %s ';
				$params[] = $like;
			}
			if ( $content ) {
				$args[] = ' post_content LIKE %s ';
				$params[] = $like;
			}

			$query = $wpdb->prepare(
				sprintf( "SELECT ID FROM $wpdb->posts WHERE post_type = 'document' AND post_status = 'publish' AND ( %s )", implode( ' OR ', $args ) ),
				$params
			);

			// Obtain a preliminary result set. This is not limited.
			$results = $wpdb->get_results( $query );

			$include = array();
			if ( !empty( $results ) && is_array( $results ) ) {
				foreach ( $results as $result ) {
					$include[] = $result->ID;
				}
			}

			$results = array();
			$post_ids = array();
			if ( count( $include ) > 0 ) {
				// Run it through get_posts() so that the normal process for obtaining
				// posts and taking account filters etc can be applied.
				$posts = get_posts( array(
					'post_type' => 'document',
					'post_status' => 'publish',
					'include' => $include,
					'numberposts' => $numberposts,
					'order' => $order,
					'orderby' => $order_by
				) );
				$i = 0;
				foreach( $posts as $post ) {
					$post_ids[] = $post->ID;

					$results[$post->ID] = array(
						'id'    => $post->ID,
						'url'   => get_permalink( $post->ID ),
						'title' => get_the_title( $post ),
						'i'     => $i
					);
					$i++;
				}
				usort( $results, array( __CLASS__, 'usort' ) );
			}

			echo json_encode( $results );
			exit;
		}
	}

	/**
	 * Sort helper using the i index.
	 * 
	 * @param array $e1
	 * @param array $e2
	 * @return int
	 */
	public static function usort( $e1, $e2 ) {
		return $e1['i'] - $e2['i'];
	}

	/**
	 * Shortcode handler, renders a documentation search form.
	 * 
	 * Enqueues required scripts and styles.
	 * 
	 * @param array $atts order, order_by, title, excerpt, content, limit
	 * @param array $content not used
	 * @return string form HTML
	 */
	public static function documentation_search_form( $atts = array(), $content = '' ) {

		$atts = shortcode_atts(
			array(
				'order'    => null,
				'order_by' => null,
				'title'    => null,
				'excerpt'  => null,
				'content'  => null,
				'limit'    => null
			),
			$atts
		);

		$url_params = array();
		foreach( $atts as $key => $value ) {
			if ( $value !== null ) {
				$value = strip_tags( trim( $value ) );
				switch( $key ) {
					case 'order' :
					case 'order_by' :
						break;
					case 'title' :
					case 'excerpt' :
					case 'content' :
						$value = strtolower( $value );
						$value = $value == 'true' || $value == 'yes' || $value == '1';
						break;
					case 'limit' :
						$value = intval( $value );
						break;
				}
				$url_params[$key] = urlencode( $value );
			}
		}

		wp_enqueue_script( 'typewatch' );
		wp_enqueue_script( 'document-search' );
		wp_enqueue_style( 'document-search' );

		$output = '';

		$documentation_search = true;

		$n          = rand();
		$search_id  = 'documentation-search-' . $n;
		$field_id   = 'documentation-search-field-' . $n;
		$results_id = 'documentation-search-results-' .$n;

		$output .= sprintf( '<div id="%s" class="documentation-search">', esc_attr( $search_id ) );

		$output .= '<div class="documentation-search-form">';
		$output .= '<form action="">';
		$output .= '<div>';
		$output .= sprintf(
			'<input id="%s" type="text" class="documentation-search-field" />',
			esc_attr( $field_id )
		);
		$output .= '</div>';
		$output .= '</form>';
		$output .= '</div>'; // .documentation-search-form

		$output .= '<div class="documentation-search-results">';
		$output .= '</div>'; // .documentation-search-results

		$output .= '</div>'; // .documentation-search

		$output .= '<script type="text/javascript">';
		$output .= 'if ( typeof jQuery !== "undefined" ) {';
		$output .= 'jQuery(document).ready(function(){';
		$output .= sprintf(
			'jQuery("#%s").typeWatch( {
				callback: function (value) { documentationSearch(\'%s\', \'%s\', \'%s\', \'%s\', value); },
				wait: 750,
				highlight: true,
				captureLength: 2
			} );',
			esc_attr( $field_id ), // jQuery selector for the input field
			esc_attr( $field_id ), // jQuery selector for the input field passed to documentationSearch()
			esc_attr( $search_id ), // container selector
			esc_attr( $search_id . ' div.documentation-search-results' ), // results container selector
			add_query_arg( $url_params, admin_url( 'admin-ajax.php' ) ) // post target URL
		);
		$output .= '});'; // ready
		$output .= '}'; // if
		$output .= '</script>';

		return $output;
	}

}
Documentation_Search::init();
