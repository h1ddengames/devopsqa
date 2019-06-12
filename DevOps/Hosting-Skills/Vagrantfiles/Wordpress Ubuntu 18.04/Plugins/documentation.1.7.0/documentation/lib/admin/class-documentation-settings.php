<?php
/**
 * class-documentation-settings.php
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
 * Admin section.
 */
class Documentation_Settings {

	/**
	 * Capability required to access the settings.
	 * @var string
	 */
	private static $capability;

	/**
	 * Admin options setup.
	 */
	public static function init() {
		self::$capability = apply_filters( 'documentation_settings_capability', 'manage_options' );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'plugin_action_links_'. plugin_basename( DOCUMENTATION_PLUGIN_FILE ), array( __CLASS__, 'admin_settings_link' ) );
	}

	/**
	 * Admin options admin setup.
	 */
	public static function admin_init() {
		wp_register_style( 'documentation_admin', DOCUMENTATION_PLUGIN_URL . 'css/admin.css', array(), DOCUMENTATION_CORE_VERSION );
	}

	/**
	 * Loads styles for the admin section.
	 */
	public static function admin_print_styles() {
		wp_enqueue_style( 'documentation_admin' );
	}

	/**
	 * Add a menu item to the Appearance menu.
	 */
	public static function admin_menu() {
		$page = add_submenu_page(
			'edit.php?post_type=document',
			__( 'Documentation Settings', 'documentation' ),
			__( 'Settings', 'documentation' ),
			self::$capability,
			'documentation-settings',
			array( __CLASS__, 'settings' )
		);
		add_action( 'admin_print_styles-' . $page, array( __CLASS__, 'admin_print_styles' ) );
	}

	/**
	 * Settings screen.
	 */
	public static function settings() {
		if ( !current_user_can( self::$capability ) ) {
			wp_die( __( 'Access denied.', 'documentation' ) );
		}
		echo '<h2>';
		echo __( 'Settings', 'documentation' );
		echo '</h2>';
		echo '<div class="documentation-settings">';
		include_once DOCUMENTATION_ADMIN_LIB . '/settings.php';
		echo '</div>'; // .documentation-settings

		echo '<div class="documentation-settings-info">';
		echo __( 'Documents can be attached to products in WooCommerce using the <a href="http://www.itthinx.com/shop/woocommerce-documentation/">WooCommerce Documentation</a> extension.', 'documentation' );
		echo '</div>'; // .documentation-settings-info

		echo '<div class="documentation-documentation-info">';
		echo __( 'For details on the usage of this documentation system, please visit the <a href="http://docs.itthinx.com/document/documentation/">Documentation</a> pages.', 'documentation' );
		echo '</div>'; // .documentation-documentation-info
	}

	/**
	 * Adds plugin links.
	 *
	 * @param array $links
	 * @param array $links with additional links
	 * @return array
	 */
	public static function admin_settings_link( $links ) {
		if ( current_user_can( self::$capability ) ) {
			$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=documentation-settings' ) . '">' . __( 'Settings', 'documentation' ) . '</a>';
			$links[] = '<a href="http://docs.itthinx.com/document/documentation/">' . __( 'Documentation', 'documentation' ) . '</a>';
		}
		return $links;
	}

}
add_action( 'init', array( 'Documentation_Settings', 'init' ) );
