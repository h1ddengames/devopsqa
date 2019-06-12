<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */

$post_sidebar = 'sidebar-1';
if ( is_singular() || is_home() ) :
	$sidebar_id = ( is_home() && ! is_front_page() ) ? get_option( 'page_for_posts' ) : get_the_id();
	$post_sidebar = get_post_meta( $sidebar_id, 'corpopress-selected-sidebar', true );
	$post_sidebar = ! empty( $post_sidebar ) ? $post_sidebar : 'sidebar-1';
endif;
if ( ! is_active_sidebar( $post_sidebar ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $post_sidebar ); ?>
</aside><!-- #secondary -->
