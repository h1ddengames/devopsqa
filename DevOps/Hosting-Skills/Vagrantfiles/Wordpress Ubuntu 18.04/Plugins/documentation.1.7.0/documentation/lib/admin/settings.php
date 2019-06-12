<?php
/**
 * settings.php
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
 * @package documentation 1.0.0
 * @since documentation 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !current_user_can( Documentation_Settings::$capability ) ) {
	wp_die( __( 'Access denied.', 'documentation' ) );
}

if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'set' ) && wp_verify_nonce( $_POST['documentation-settings'], 'admin' ) ) {

	$options = Documentation::get_options();
	$options['document_comments_open'] = !empty( $_POST['document_comments_open'] );
	$options['document_use_block_editor'] = !empty( $_POST['document_use_block_editor'] );

	$maybe_slug = !empty( $_POST['document_slug'] ) ? $_POST['document_slug'] : '';
	$maybe_slug = preg_replace( '/(\s|[^A-Za-z0-9-_])+/', '', wp_strip_all_tags( $maybe_slug ) );
	$options['document_slug'] = $maybe_slug;

	Documentation::set_options( $options );

	echo
		'<p class="info">' .
		__( 'The settings have been saved.', 'documentation' ) .
		'</p>';
}

$options = Documentation::get_options();
$document_comments_open = isset( $options['document_comments_open'] ) ? $options['document_comments_open'] : true;
$document_slug = !empty( $options['document_slug'] ) ? $options['document_slug'] : '';
$document_use_block_editor = isset( $options['document_use_block_editor'] ) ? $options['document_use_block_editor'] : true;

echo '<div class="settings">';
echo '<form name="settings" method="post" action="">';
echo '<div>';

echo '<label>';
printf( '<input type="checkbox" name="document_comments_open" %s />', $document_comments_open ? ' checked="checked" ' : '' );
echo ' ';
echo __( 'Allow comments on documents', 'documentation' );
echo '</label>';
echo '<p class="description">';
echo __( 'Disable this option if you do not want to allow visitors to post comments on documents.', 'documentation' );
echo ' ';
echo __( 'If this option is enabled, you may choose to allow comments on each document individually.', 'documentation' );
echo ' ';
echo __( 'If this option is disabled, comments on all documents are disabled.', 'documentation' );
echo '</p>';

echo '<div class="separator"></div>';

echo '<label>';
printf( '<input type="checkbox" name="document_use_block_editor" %s />', $document_use_block_editor ? ' checked="checked" ' : '' );
echo ' ';
echo __( 'Enable the block editor to edit documents', 'documentation' );
echo '</label>';
echo '<p class="description">';
echo __( 'Disable this option if you do not want to use the block editor to edit documents.', 'documentation' );
echo '</p>';

echo '<div class="separator"></div>';

echo '<label>';
echo __( 'Document slug', 'documentation' );
echo ' ';
printf( '<input type="text" name="document_slug" value="%s" />', esc_attr( $document_slug ) );
echo '<p class="description">';
echo __( 'Depending on your Permalink settings, URLs of documents will contain this in their path before the section that identifies the document.', 'documentation' );
echo ' ';
echo __( 'If left empty, the default <em>document</em> applies.', 'documentation' );
echo ' ';
echo sprintf( __( 'After changing this, please visit the <a href="%s">Permalinks</a> admin section to make sure that the permalink structure is updated.', 'documentation' ), admin_url( 'options-permalink.php' ) );
echo '</p>';
echo '</label>';

echo '<div class="separator"></div>';

wp_nonce_field( 'admin', 'documentation-settings', true, true );

echo '<div class="buttons">';
printf( '<input class="save button button-primary" type="submit" name="submit" value="%s" />', esc_attr( __( 'Save', 'documentation' ) ) );
echo '<input type="hidden" name="action" value="set" />';
echo '</div>';

echo '</div>';
echo '</form>';
echo '</div>';
