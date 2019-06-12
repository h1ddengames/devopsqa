<?php
/**
 * class-documentation-add-ons.php
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
 * Shows the recommended plugins and add-ons.
 */
class Documentation_Add_Ons {

	/**
	 * Adds the admin_menu action hook.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 11 ); // so we have it last after settings
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
	}

	/**
	 * Adds the Add Ons menu item to the Documentation menu.
	 */
	public static function admin_menu() {
		$page = add_submenu_page(
			add_query_arg( array( 'post_type' => 'document' ), 'edit.php' ),
			__( 'Add-Ons', 'widgets-control' ),
			__( 'Add-Ons', 'widgets-control' ),
			'edit_posts', // @todo if we use our own capabilities this needs to be edit_documents
			'documentation-add-ons',
			array( __CLASS__, 'render_admin' )
		);
		add_action( 'admin_print_styles-' . $page, array( __CLASS__, 'admin_print_styles' ) );
	}

	
	/**
	 * Admin options admin setup.
	 */
	public static function admin_init() {
		wp_register_style( 'documentation_admin_addons', DOCUMENTATION_PLUGIN_URL . 'css/admin_addons.css', array(), DOCUMENTATION_CORE_VERSION );
	}

	/**
	 * Loads styles for the admin section.
	 */
	public static function admin_print_styles() {
		wp_enqueue_style( 'documentation_admin_addons' );
	}

	/**
	 * Renders the Add-Ons admin section.
	 */
	public static function render_admin() {
		echo '<div class="documentation-admin-add-ons wrap">';
		echo '<h1>';
		echo __( 'Add-Ons', 'documentation' );
		echo '</h1>';
		self::add_ons_content();
		echo '</div>'; // .documentation-admin-add-ons.wrap
	}

	/**
	 * Renders the content of the Add-Ons section.
	 *
	 * @param $params array of options (offset is 0 by default and used to adjust heading h2)
	 */
	public static function add_ons_content( $params = array( 'offset' => 0 ) ) {

		$d = intval( $params['offset'] );
		$h2 = 2 + $d;
		$h3 = 3 + $d;

		printf( '<h%d class="add-ons-sub-title">', $h2 );
		echo __( 'Recommended Tools and Extensions', 'documentation' );
		printf( '</h%d>', $h2 );

		$entries = array(
			'woocommerce-documentation' => array(
				'title'   => 'WooCommerce Documentation',
				'content' => 'This extension for WooCommerce and the Documentation plugin for WordPress allows to link documentation pages to products and display them automatically on the product pages.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/woocommerce-documentation.png',
				'url'     => 'http://www.itthinx.com/shop/woocommerce-documentation/',
				'index'   => 100
			),
			'groups' => array(
				'title'   => 'Groups',
				'content' => 'Groups is designed as an efficient, powerful and flexible solution for group-oriented memberships and content access control. Use it to control who can view documents and more.',
				'image'   => DOCUMENTATION_PLUGIN_URL . 'images/add-ons/groups.png',
				'url'     => 'https://wordpress.org/plugins/groups/',
				'index'   => 100
			),
			'groups-restrict-categories' => array(
				'title'   => 'Groups Restrict Categories',
				'content' => 'An extension based on Groups, provides access restrictions for categories and tags, custom post types and taxonomies. Very useful to restrict whole sets of documents based on their document categories or tags.',
				'image'   => DOCUMENTATION_PLUGIN_URL . 'images/add-ons/groups-restrict-categories.png',
				'url'     => 'https://www.itthinx.com/shop/groups-restrict-categories/',
				'index'   => 100
			),
			'search-live' => array(
				'title'   => 'Search Live',
				'content' => 'Search Live supplies effective integrated live search facilities and advanced search features. Makes it really easy to find the desired documents.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/search-live.png',
				'url'     => 'https://wordpress.org/plugins/search-live/',
				'index'   => 200
			),
			'widgets-control' => array(
				'title'   => 'Widgets Control',
				'content' => 'Widgets Control is a toolbox that features visibility management for all widgets, sidebars, sections of content and content blocks. This is very useful to show content and widgets in context.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/widgets-control.png',
				'url'     => 'https://wordpress.org/plugins/widgets-control/',
				'index'   => 200
			),
			'widgets-control-pro' => array(
				'title'   => 'Widgets Control Pro',
				'content' => 'Widgets Control Pro is the advanced version of the Widgets Control toolbox that features visibility management for all widgets, sidebars, sections of content and content blocks. With its additional features, it is even more useful to show document-specific content and widgets, including the options to show widgets on documents and related pages only.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/widgets-control-pro.png',
				'url'     => 'https://www.itthinx.com/shop/widgets-control-pro/',
				'index'   => 200
			),
			'decent-comments' => array(
				'title'   => 'Decent Comments',
				'content' => 'Decent Comments shows what people say. If you want to show comments along with their author’s avatars and an excerpt of their comment, then this is the right plugin for you. Use it to show comments posted on documents only or including them.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/decent-comments.png',
				'url'     => 'https://wordpress.org/plugins/decent-comments/',
				'index'   => 300
			),
			'open-graph-protocol-framework' => array(
				'title'   => 'Open Graph Protocol Framework',
				'content' => 'The Open Graph protocol enables any web page to become a rich object in a social graph. For instance, this is used on Facebook to allow any web page to have the same functionality as any other object on Facebook. This will automate the process of adding basic and optional metadata to documents.',
				'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/open-graph-protocol-framework.png',
				'url'     => 'https://wordpress.org/plugins/open-graph-protocol-framework/',
				'index'   => 300
			)
		);
		usort( $entries, array( __CLASS__, 'add_ons_sort' ) );

		echo '<ul class="add-ons">';
		foreach( $entries as $key => $entry ) {
			echo '<li class="add-on">';
			echo sprintf( '<a href="%s" target="_blank">', $entry['url'] );
			printf( '<h%d class="add-ons-sub-sub-title">', $h3 );
			echo sprintf( '<img src="%s"/>', $entry['image'] );
			echo '<span class="title">';
			echo $entry['title'];
			echo '</span>';
			printf( '</h%d>', $h3 );
			echo '<p>';
			echo $entry['content'];
			echo '</p>';
			echo '</a>';
			echo '</li>'; // .add-on
		}
		echo '</ul>'; // .add-ons

		printf( '<h%d class="add-ons-sub-title">', $h2 );
		printf( __( 'More from <a href="%s">itthinx</a>', 'documentation' ), esc_attr( 'https://www.itthinx.com/' ) );
		printf( '</h%d>', $h2 );

		$entries = array(
				'affiliates' => array(
					'title'   => 'Affiliates',
					'content' => 'The free Affiliates system provides powerful tools to maintain an Affiliate Marketing Program.',
					'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/affiliates.png',
					'url'     => 'https://wordpress.org/plugins/affiliates/',
					'index'   => 100
				),
				'affiliates-pro' => array(
					'title'   => 'Affiliates Pro',
					'content' => 'Boost Sales with the best Affiliate Marketing for your WordPress site.',
					'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/affiliates-pro.png',
					'url'     => 'http://www.itthinx.com/shop/affiliates-pro/',
					'index'   => 200
				),
				'affiliates-enterprise' => array(
					'title'   => 'Affiliates Enterprise',
					'content' => 'Affiliates Enterprise provides an even more advanced affiliate management system for sellers, shops and developers, who want to boost sales with their own affiliate program. Features affiliate campaigns, tracking pixels and multiple tiers.',
					'image'   => DOCUMENTATION_PLUGIN_URL. 'images/add-ons/affiliates-enterprise.png',
					'url'     => 'http://www.itthinx.com/shop/affiliates-enterprise/',
					'index'   => 300
				),
		);
		usort( $entries, array( __CLASS__, 'add_ons_sort' ) );

		echo '<ul class="add-ons">';
		foreach( $entries as $key => $entry ) {
			echo '<li class="add-on">';
			echo sprintf( '<a href="%s" target="_blank">', $entry['url'] );
			printf( '<h%d class="add-ons-sub-sub-title">', $h3 );
			echo sprintf( '<img src="%s"/>', $entry['image'] );
			echo '<span class="title">';
			echo $entry['title'];
			echo '</span>';
			printf( '</h%d>', $h3 );
			echo '<p>';
			echo $entry['content'];
			echo '</p>';
			echo '</a>';
			echo '</li>'; // .add-on
		}
		echo '</ul>'; // .add-ons
	}

	/**
	 * Helper function to sort add-on entries.
	 *
	 * @param array $e1
	 * @param array $e2
	 * @return number
	 */
	public static function add_ons_sort( $e1, $e2 ) {
		$i1 = isset( $e1['index'] ) ? $e1['index'] : 0;
		$i2 = isset( $e2['index'] ) ? $e2['index'] : 0;
		$t1 = isset( $e1['title'] ) ? $e1['title'] : '';
		$t2 = isset( $e2['title'] ) ? $e2['title'] : '';

		return $i1 - $i2 + strnatcmp( $t1, $t2 );
	}

}
Documentation_Add_Ons::init();
