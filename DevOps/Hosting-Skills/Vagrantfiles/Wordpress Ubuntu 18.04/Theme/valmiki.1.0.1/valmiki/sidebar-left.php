<?php
/**
 * The Sidebar containing the main widget areas.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If the navigation is set in the sidebar, set variable to true.
$navigation_active = ( 'nav-left-sidebar' == valmiki_get_navigation_location() ) ? true : false;

// If the secondary navigation is set in the sidebar, set variable to true.
if ( function_exists( 'valmiki_secondary_nav_get_defaults' ) ) {
	$secondary_nav = wp_parse_args(
		get_option( 'valmiki_secondary_nav_settings', array() ),
		valmiki_secondary_nav_get_defaults()
	);

	if ( 'secondary-nav-left-sidebar' == $secondary_nav['secondary_nav_position_setting'] ) {
		$navigation_active = true;
	}
}
?>
<div id="left-sidebar" itemtype="https://schema.org/WPSideBar" itemscope="itemscope" <?php valmiki_left_sidebar_class(); ?>>
	<div class="inside-left-sidebar">
		<?php
		/**
		 * valmiki_before_left_sidebar_content hook.
		 *
		 */
		do_action( 'valmiki_before_left_sidebar_content' );

		if ( ! dynamic_sidebar( 'sidebar-2' ) ) :

			if ( false == $navigation_active ) : ?>

				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

				<aside id="archives" class="widget">
					<h2 class="widget-title"><?php esc_html_e( 'Archives', 'valmiki' ); ?></h2>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

			<?php endif;

		endif;

		/**
		 * valmiki_after_left_sidebar_content hook.
		 *
		 */
		do_action( 'valmiki_after_left_sidebar_content' );
		?>
	</div><!-- .inside-left-sidebar -->
</div><!-- #secondary -->
