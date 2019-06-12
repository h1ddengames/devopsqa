<?php
/**
 * Load necessary Customizer controls and functions.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Controls
require_once trailingslashit( dirname( __FILE__ ) ) . 'controls/class-range-control.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'controls/class-typography-control.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'controls/class-upsell-section.php';
require_once trailingslashit( dirname( __FILE__ ) ) . 'controls/class-upsell-control.php';

// Helper functions
require_once trailingslashit( dirname( __FILE__ ) ) . 'helpers.php';
