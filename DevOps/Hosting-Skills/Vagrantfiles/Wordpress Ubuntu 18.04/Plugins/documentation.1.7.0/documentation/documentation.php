<?php
/**
 * Plugin Name: Documentation
 * Plugin URI: http://www.itthinx.com/plugins/documentation
 * Description: A documentation management system.
 * Version: 1.7.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * License: GPLv3
 * 
 * Copyright (c) 2013 - 2019 "kento" Karim Rahimpur www.itthinx.com
 * 
 * This code is released under the GNU General Public License Version 3.
 * The following additional terms apply to all files as per section
 * "7. Additional Terms." See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * All legal, copyright and license notices and all author attributions
 * must be preserved in all files and user interfaces.
 * 
 * Where modified versions of this material are allowed under the applicable
 * license, modified version must be marked as such and the origin of the
 * modified material must be clearly indicated, including the copyright
 * holder, the author and the date of modification and the origin of the
 * modified material.
 * 
 * This material may not be used for publicity purposes and the use of
 * names of licensors and authors of this material for publicity purposes
 * is prohibited.
 * 
 * The use of trade names, trademarks or service marks, licensor or author
 * names is prohibited unless granted in writing by their respective owners.
 * 
 * Where modified versions of this material are allowed under the applicable
 * license, anyone who conveys this material (or modified versions of it) with
 * contractual assumptions of liability to the recipient, for any liability
 * that these contractual assumptions directly impose on those licensors and
 * authors, is required to fully indemnify the licensors and authors of this
 * material.
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

define( 'DOCUMENTATION_CORE_VERSION', '1.7.0' );
define( 'DOCUMENTATION_PLUGIN_FILE', __FILE__ );
define( 'DOCUMENTATION_PLUGIN_DOMAIN', 'documentation' );
define( 'DOCUMENTATION_PLUGIN_URL', plugin_dir_url( DOCUMENTATION_PLUGIN_FILE ) );
if ( !defined( 'DOCUMENTATION_CORE_DIR' ) ) {
	define( 'DOCUMENTATION_CORE_DIR', WP_PLUGIN_DIR . '/documentation' );
}
if ( !defined( 'DOCUMENTATION_CORE_LIB' ) ) {
	define( 'DOCUMENTATION_CORE_LIB', DOCUMENTATION_CORE_DIR . '/lib/core' );
}
if ( !defined( 'DOCUMENTATION_ADMIN_LIB' ) ) {
	define( 'DOCUMENTATION_ADMIN_LIB', DOCUMENTATION_CORE_DIR . '/lib/admin' );
}
if ( !defined( 'DOCUMENTATION_VIEWS_LIB' ) ) {
	define( 'DOCUMENTATION_VIEWS_LIB', DOCUMENTATION_CORE_DIR . '/lib/views' );
}
if ( !defined( 'DOCUMENTATION_EXT_LIB' ) ) {
	define( 'DOCUMENTATION_EXT_LIB', DOCUMENTATION_CORE_DIR . '/lib/ext' );
}
if ( !defined( 'DOCUMENTATION_CORE_URL' ) ) {
	define( 'DOCUMENTATION_CORE_URL', WP_PLUGIN_URL . '/documentation' );
}
require_once DOCUMENTATION_CORE_LIB . '/class-documentation-controller.php';
