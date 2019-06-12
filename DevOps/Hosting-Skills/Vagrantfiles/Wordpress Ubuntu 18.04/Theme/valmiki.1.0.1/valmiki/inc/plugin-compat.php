<?php
/**
 * Add compatibility for some popular third party plugins.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'valmiki_setup_woocommerce' );
/**
 * Set up WooCommerce
 *
 */
function valmiki_setup_woocommerce() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Add support for WC features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	//Remove default WooCommerce wrappers
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_sidebar', 'valmiki_construct_sidebars' );
}

if ( ! function_exists( 'valmiki_woocommerce_start' ) ) {
	add_action( 'woocommerce_before_main_content', 'valmiki_woocommerce_start', 10 );
	/**
	 * Add WooCommerce starting wrappers
	 *
	 */
	function valmiki_woocommerce_start() { ?>
		<div id="primary" <?php valmiki_content_class();?>>
			<main id="main" <?php valmiki_main_class(); ?>>
				<?php
				/**
				 * valmiki_before_main_content hook.
				 *
				 */
				do_action( 'valmiki_before_main_content' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php valmiki_article_schema( 'CreativeWork' ); ?>>
					<div class="inside-article">
						<?php
						/**
						 * valmiki_before_content hook.
						 *
						 *
						 * @hooked valmiki_featured_page_header_inside_single - 10
						 */
						do_action( 'valmiki_before_content' );
						?>
						<div class="entry-content" itemprop="text">
	<?php
	}
}

if ( ! function_exists( 'valmiki_woocommerce_end' ) ) {
	add_action( 'woocommerce_after_main_content', 'valmiki_woocommerce_end', 10 );
	/**
	 * Add WooCommerce ending wrappers
	 *
	 */
	function valmiki_woocommerce_end() { ?>
						</div><!-- .entry-content -->
						<?php
						/**
						 * valmiki_after_content hook.
						 *
						 */
						do_action( 'valmiki_after_content' );
						?>
					</div><!-- .inside-article -->
				</article><!-- #post-## -->
				<?php
				/**
				 * valmiki_after_main_content hook.
				 *
				 */
				do_action( 'valmiki_after_main_content' );
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
	<?php
	}
}

if ( ! function_exists( 'valmiki_woocommerce_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'valmiki_woocommerce_css', 100 );
	/**
	 * Add WooCommerce CSS
	 *
	 */
	function valmiki_woocommerce_css() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$mobile = apply_filters( 'valmiki_mobile_media_query', '(max-width:768px)' );
		$css = '.woocommerce .page-header-image-single {
			display: none;
		}

		.woocommerce .entry-content,
		.woocommerce .product .entry-summary {
			margin-top: 0;
		}

		.related.products {
			clear: both;
		}

		.checkout-subscribe-prompt.clear {
			visibility: visible;
			height: initial;
			width: initial;
		}

		@media ' . esc_attr( $mobile ) . ' {
			.woocommerce .woocommerce-ordering,
			.woocommerce-page .woocommerce-ordering {
				float: none;
			}

			.woocommerce .woocommerce-ordering select {
				max-width: 100%;
			}

			.woocommerce ul.products li.product,
			.woocommerce-page ul.products li.product,
			.woocommerce-page[class*=columns-] ul.products li.product,
			.woocommerce[class*=columns-] ul.products li.product {
				width: 100%;
				float: none;
			}
		}';

		$css = str_replace(array("\r", "\n", "\t"), '', $css);
		wp_add_inline_style( 'woocommerce-general', $css );
	}
}

if ( ! function_exists( 'valmiki_bbpress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'valmiki_bbpress_css', 100 );
	/**
	 * Add bbPress CSS
	 *
	 */
	function valmiki_bbpress_css() {
		$css = '#bbpress-forums ul.bbp-lead-topic,
		#bbpress-forums ul.bbp-topics,
		#bbpress-forums ul.bbp-forums,
		#bbpress-forums ul.bbp-replies,
		#bbpress-forums ul.bbp-search-results,
		#bbpress-forums,
		div.bbp-breadcrumb,
		div.bbp-topic-tags {
			font-size: inherit;
		}

		.single-forum #subscription-toggle {
			display: block;
			margin: 1em 0;
			clear: left;
		}

		#bbpress-forums .bbp-search-form {
			margin-bottom: 10px;
		}

		.bbp-login-form fieldset {
			border: 0;
			padding: 0;
		}';

		$css = str_replace(array("\r", "\n", "\t"), '', $css);
		wp_add_inline_style( 'bbp-default', $css );
	}
}

if ( ! function_exists( 'valmiki_buddypress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'valmiki_buddypress_css', 100 );
	/**
	 * Add BuddyPress CSS
	 *
	 */
	function valmiki_buddypress_css() {
		$css = '#buddypress form#whats-new-form #whats-new-options[style] {
			min-height: 6rem;
			overflow: visible;
		}';

		$css = str_replace(array("\r", "\n", "\t"), '', $css);
		wp_add_inline_style( 'bp-legacy-css', $css );
	}
}

if ( ! function_exists( 'valmiki_beaver_builder_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'valmiki_beaver_builder_css', 100 );
	/**
	 * Add Beaver Builder CSS
	 *
	 * Beaver Builder pages set to no sidebar used to automatically be full width, however
	 * now that we have the Page Builder Container meta box, we want to give the user
	 * the option to set the page to full width or contained.
	 *
	 * We can't remove this CSS as people who are depending on it will lose their full
	 * width layout when they update.
	 *
	 * So instead, we only apply this CSS to posts older than the date of this update.
	 *
	 */
	function valmiki_beaver_builder_css() {
		// Check is Beaver Builder is active
		// If we have the full-width-content class, we don't need to do anything else
		if ( in_array( 'fl-builder', get_body_class() ) && ! in_array( 'full-width-content', get_body_class() ) && ! in_array( 'contained-content', get_body_class() ) ) {
			global $post;

			if ( ! isset( $post ) ) {
				return;
			}

			$compare_date = strtotime( "2017-03-14" );
			$post_date    = strtotime( $post->post_date );
			if ( $post_date < $compare_date ) {
				$css = '.fl-builder.no-sidebar .container.grid-container {
					max-width: 100%;
				}

				.fl-builder.one-container.no-sidebar .site-content {
					padding:0;
				}';
				$css = str_replace(array("\r", "\n", "\t"), '', $css);
				wp_add_inline_style( 'valmiki-style', $css );
			}
		}
	}
}