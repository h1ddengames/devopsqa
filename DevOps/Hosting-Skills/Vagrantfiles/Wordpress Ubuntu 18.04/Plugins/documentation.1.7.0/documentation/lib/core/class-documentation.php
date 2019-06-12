<?php
/**
 * class-documentation.php
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
 * Core forum class, handles comments and post/comment rights.
 */
class Documentation {

	const OPTIONS = 'documentation_options';

	/**
	 * Not much to do here for now.
	 */
	public static function init() {
	}

	/**
	 * Get the plugin's options array.
	 * @return array
	 */
	public static function get_options() {
		$data = get_option( self::OPTIONS, null );
		if ( $data === null ) {
			if ( add_option( self::OPTIONS, array(), '', 'no' ) ) {
				$data = get_option( self::OPTIONS, null );
			}
		}
		return $data;
	}

	/**
	 * Set the plugin's options.
	 * @param array $data
	 */
	public static function set_options( $data ) {
		$current_data = get_option( self::OPTIONS, null );
		if ( $current_data === null ) {
			add_option( self::OPTIONS, $data, '', 'no' );
		} else {
			update_option( self::OPTIONS, $data );
		}
	}
}
Documentation::init();
