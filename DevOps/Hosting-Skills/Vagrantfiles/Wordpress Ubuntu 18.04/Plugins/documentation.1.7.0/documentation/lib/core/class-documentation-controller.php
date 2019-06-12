<?php
/**
 * class-documentation-controller.php
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
 * @since documentation 1.6.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the plugin's bootloader class.
 */
class Documentation_Controller {

	/**
	 * Holds admin messages to show.
	 * @var array
	 */
	public static $admin_messages = array();

	/**
	 * Boots the plugin.
	 */
	public static function boot() {
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
		require_once DOCUMENTATION_CORE_LIB . '/class-documentation.php';
		require_once DOCUMENTATION_EXT_LIB . '/class-documentation-post-type.php';
		require_once DOCUMENTATION_EXT_LIB . '/class-documentation-taxonomy.php';
		if ( !is_admin() ) {
			require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-shortcodes.php';
		} else {
			require_once DOCUMENTATION_ADMIN_LIB . '/class-documentation-settings.php';
			require_once DOCUMENTATION_ADMIN_LIB . '/class-documentation-add-ons.php';
		}
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-categories-widget.php';
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-documents-widget.php';
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-document-children-widget.php';
		require_once DOCUMENTATION_VIEWS_LIB . '/class-documentation-document-hierarchy-widget.php';
		require_once DOCUMENTATION_CORE_LIB . '/class-documentation-search.php';
		register_activation_hook( DOCUMENTATION_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_deactivation_hook( DOCUMENTATION_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Prints admin notices.
	 */
	public static function admin_notices() {
		if ( !empty( self::$admin_messages ) ) {
			foreach ( self::$admin_messages as $msg ) {
				echo $msg;
			}
		}
	}

	/**
	 * Hooked on the 'init' action; loads translations and the notice class.
	 */
	public static function init() {
		load_plugin_textdomain( 'documentation', null, 'documentation/languages' );
		if ( is_admin() ) {
			if ( current_user_can( 'activate_plugins' ) ) { // important: after init hook
				require_once DOCUMENTATION_ADMIN_LIB. '/class-documentation-admin-notice.php';
			}
		}
	}

	/**
	 * Hooked on plugin activation to flush rewrite rules after registering our document post type.
	 */
	public static function activation() {
		Documentation_Post_Type::post_type();
		Documentation_Taxonomy::taxonomy();
		flush_rewrite_rules( false );
	}

	/**
	 * Hooked on plugin deactivation to flush rewrite rules.
	 */
	public static function deactivation() {
		flush_rewrite_rules( false );
	}
}
Documentation_Controller::boot();
