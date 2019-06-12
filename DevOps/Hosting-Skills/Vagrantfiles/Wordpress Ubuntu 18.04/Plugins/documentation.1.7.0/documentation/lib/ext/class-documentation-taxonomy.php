<?php
/**
 * class-documentation-taxonomy.php
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
 * Documentation taxonomy.
*/
class Documentation_Taxonomy {

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'wp_init' ) );
	}

	/**
	 * Register post type and taxonomy.
	 */
	public static function wp_init() {
		self::taxonomy();
	}

	/**
	 * Registers the documentation taxonomies.
	 */
	public static function taxonomy() {
		register_taxonomy(
			'document_category',
			array( 'document' ),
			array(
				'hierarchical' => true,
				'labels'       => array(
					'name'              => _x( 'Document Categories', 'taxonomy general name', 'documentation' ),
					'singular_name'     => _x( 'Document Category', 'taxonomy singular name', 'documentation' ),
					'search_items'      => __( 'Search Categories', 'documentation' ),
					'all_items'         => __( 'All Categories', 'documentation' ),
					'parent_item'       => __( 'Parent Category', 'documentation' ),
					'parent_item_colon' => __( 'Parent Category:', 'documentation' ),
					'edit_item'         => __( 'Edit Category', 'documentation' ),
					'update_item'       => __( 'Update Category', 'documentation' ),
					'add_new_item'      => __( 'Add New Category', 'documentation' ),
					'new_item_name'     => __( 'New Category Name', 'documentation' ),
					'menu_name'         => __( 'Categories', 'documentation' ),
				),
				'public'       => true,
				'query_var'    => true,
				'rewrite'      => array( 'slug' => 'document_category' ),
				'show_in_nav_menus' => true,
				'show_in_rest'        => true,
				'show_tagcloud'     => true,
				'show_ui'           => true,
				'show_admin_column' => true
			)
		);

		register_taxonomy(
			'document_tag',
			array( 'document' ),
			array(
				'hierarchical' => false,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'document_tag' ),
				'public' => true,
				'show_in_rest' => true,
				'show_ui' => true,
				'show_admin_column' => true,
			)
		);
	}

}
Documentation_Taxonomy::init();
