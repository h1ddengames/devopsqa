<?php
/**
 * The template for displaying search forms
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php apply_filters( 'valmiki_search_label', _ex( 'Search for:', 'label', 'valmiki' ) ); // WPCS: XSS ok, sanitization ok. ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( apply_filters( 'valmiki_search_placeholder', _x( 'Search &hellip;', 'placeholder', 'valmiki' ) ) ); // WPCS: XSS ok, sanitization ok. ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_attr( apply_filters( 'valmiki_search_label', _ex( 'Search for:', 'label', 'valmiki' ) ) ); // WPCS: XSS ok, sanitization ok. ?>">
	</label>
	<input type="submit" class="search-submit" value="<?php echo apply_filters( 'valmiki_search_button', _x( 'Search', 'submit button', 'valmiki' ) ); // WPCS: XSS ok, sanitization ok. ?>">
</form>
