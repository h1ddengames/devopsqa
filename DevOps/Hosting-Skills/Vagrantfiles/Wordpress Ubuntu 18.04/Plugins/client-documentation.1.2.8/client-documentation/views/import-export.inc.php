<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	
?>
<div class="wrap sd_importexport">
	<h2><?php _e('Import / Export', 'client-documentation' ); ?></h2>

	<h3><?php _e('Export', 'client-documentation' ); ?></h3>
	<p>
		<textarea id="sd_export" class="large-text disabled" disabled></textarea>
	</p>
	<p>
		<a href="#export" class="button button-primary sd_export_button" id="sd_export_button"><?php _e( 'Export', 'client-documentation' ); ?></a>
		<input type="checkbox" id="sd_export_options" value="include" checked /> 
		<label for="sd_include_options"><?php _e( 'Include options', 'client-documentation' ); ?></label>
		<small>( <?php _e( 'if included, options will be overwritten', 'client-documentation' ); ?> )</small>
	</p>
	
	<h3 class="top_spacer"><?php _e('Import', 'client-documentation' ); ?></h3>
	<p>
		<textarea id="sd_import" class="large-text"></textarea>
	</p>
	<p>
		<a href="#import" class="button button-primary sd_import_button" id="sd_import_button"><?php _e( 'Import', 'client-documentation' ); ?></a>
	</p>
</div>