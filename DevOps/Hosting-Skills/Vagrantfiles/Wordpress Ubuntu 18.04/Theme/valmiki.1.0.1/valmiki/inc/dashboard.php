<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'valmiki_create_menu' ) ) {
	add_action( 'admin_menu', 'valmiki_create_menu' );
	/**
	 * Adds our "Valmiki" dashboard menu item
	 *
	 */
	function valmiki_create_menu() {
		$valmiki_page = add_theme_page( 'Valmiki', 'Valmiki', apply_filters( 'valmiki_dashboard_page_capability', 'edit_theme_options' ), 'valmiki-options', 'valmiki_settings_page' );
		add_action( "admin_print_styles-$valmiki_page", 'valmiki_options_styles' );
	}
}

if ( ! function_exists( 'valmiki_options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the Valmiki dashboard page
	 *
	 */
	function valmiki_options_styles() {
		wp_enqueue_style( 'valmiki-options', get_template_directory_uri() . '/css/admin/admin-style.css', array(), VALMIKI_VERSION );
	}
}

if ( ! function_exists( 'valmiki_settings_page' ) ) {
	/**
	 * Builds the content of our Valmiki dashboard page
	 *
	 */
	function valmiki_settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="valmiki-masthead clearfix">
					<div class="valmiki-container">
						<div class="valmiki-title">
							<a href="<?php echo esc_url(VALMIKI_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Valmiki', 'valmiki' ); ?></a> <span class="valmiki-version"><?php echo VALMIKI_VERSION; ?></span>
						</div>
						<div class="valmiki-masthead-links">
							<?php if ( ! defined( 'VALMIKI_PREMIUM_VERSION' ) ) : ?>
								<a class="valmiki-masthead-links-bold" href="<?php echo esc_url(VALMIKI_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'Premium', 'valmiki' );?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url(VALMIKI_WPKOI_AUTHOR_URL); ?>" target="_blank"><?php esc_html_e( 'WPKoi', 'valmiki' ); ?></a>
                            <a href="<?php echo esc_url(VALMIKI_DOCUMENTATION); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'valmiki' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * valmiki_dashboard_after_header hook.
				 *
				 */
				 do_action( 'valmiki_dashboard_after_header' );
				 ?>

				<div class="valmiki-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * valmiki_dashboard_inside_container hook.
							 *
							 */
							 do_action( 'valmiki_dashboard_inside_container' );
							 ?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'valmiki-settings-group' ); ?>
									<?php do_settings_sections( 'valmiki-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="valmiki_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'valmiki' )
										);
										?>
									</div>

									<?php
									/**
									 * valmiki_inside_options_form hook.
									 *
									 */
									 do_action( 'valmiki_inside_options_form' );
									 ?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Blog' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Colors' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Copyright' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Disable Elements' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Demo Import' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Hooks' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Import / Export' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Menu Plus' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Page Header' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Secondary Nav' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Spacing' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Typography' => array(
											'url' => VALMIKI_THEME_URL,
									),
									'Elementor Addon' => array(
											'url' => VALMIKI_THEME_URL,
									)
								);

								if ( ! defined( 'VALMIKI_PREMIUM_VERSION' ) ) : ?>
									<div class="postbox valmiki-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', 'valmiki' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php foreach( $modules as $module => $info ) { ?>
												<div class="add-on activated valmiki-clear addon-container grid-parent">
													<div class="addon-name column-addon-name" style="">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
													</div>
													<div class="addon-action addon-addon-action" style="text-align:right;">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php esc_html_e( 'More info', 'valmiki' ); ?></a>
													</div>
												</div>
												<div class="valmiki-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php
								endif;

								/**
								 * valmiki_options_items hook.
								 *
								 */
								do_action( 'valmiki_options_items' );
								?>
							</div>

							<div class="valmiki-right-sidebar grid-30" style="padding-right: 0;">
								<div class="customize-button hide-on-mobile">
									<?php
									printf( '<a id="valmiki_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
										esc_url( admin_url( 'customize.php' ) ),
										esc_html__( 'Customize', 'valmiki' )
									);
									?>
								</div>

								<?php
								/**
								 * valmiki_admin_right_panel hook.
								 *
								 */
								 do_action( 'valmiki_admin_right_panel' );

								  ?>
                                
                                <div class="wpkoi-doc">
                                	<h3><?php esc_html_e( 'Valmiki documentation', 'valmiki' ); ?></h3>
                                	<p><?php esc_html_e( 'If You`ve stuck, the documentation may help on WPKoi.com', 'valmiki' ); ?></p>
                                    <a href="<?php echo esc_url(VALMIKI_DOCUMENTATION); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Valmiki documentation', 'valmiki' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-social">
                                	<h3><?php esc_html_e( 'WPKoi on Facebook', 'valmiki' ); ?></h3>
                                	<p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow WPKoi on Facebook.', 'valmiki' ); ?></p>
                                    <a href="<?php echo esc_url(VALMIKI_WPKOI_SOCIAL_URL); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', 'valmiki' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-review">
                                	<h3><?php esc_html_e( 'Help with You review', 'valmiki' ); ?></h3>
                                	<p><?php esc_html_e( 'If You like Valmiki theme, show it to the world with Your review. Your feedback helps a lot.', 'valmiki' ); ?></p>
                                    <a href="<?php echo esc_url(VALMIKI_WORDPRESS_REVIEW); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Add my review', 'valmiki' ); ?></a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'valmiki_admin_errors' ) ) {
	add_action( 'admin_notices', 'valmiki_admin_errors' );
	/**
	 * Add our admin notices
	 *
	 */
	function valmiki_admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_valmiki-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'valmiki-notices', 'true', esc_html__( 'Settings saved.', 'valmiki' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( 'valmiki-notices', 'imported', esc_html__( 'Import successful.', 'valmiki' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( 'valmiki-notices', 'reset', esc_html__( 'Settings removed.', 'valmiki' ), 'updated' );
		}

		settings_errors( 'valmiki-notices' );
	}
}
