<?php
/**
 * The upsell Customizer controll.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Valmiki_Customize_Misc_Control' ) ) {
	/**
	 * Create our in-section upsell controls.
	 * Escape your URL in the Customizer using esc_url().
	 *
	 */
	class Valmiki_Customize_Misc_Control extends WP_Customize_Control {
		public $description = '';
		public $url = '';
		public $type = 'addon';
		public $label = '';

		public function enqueue() {
			wp_enqueue_style( 'valmiki-customizer-controls-css', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/controls/css/upsell-customizer.css', array(), VALMIKI_VERSION );
		}

		public function to_json() {
			parent::to_json();
			$this->json[ 'url' ] = esc_url( $this->url );
		}

		public function content_template() {
			?>
			<p class="description" style="margin-top: 5px;">{{{ data.description }}}</p>
			<span class="get-addon">
				<a href="{{{ data.url }}}" class="button button-primary" target="_blank">{{ data.label }}</a>
			</span>
			<?php
		}
	}
}
