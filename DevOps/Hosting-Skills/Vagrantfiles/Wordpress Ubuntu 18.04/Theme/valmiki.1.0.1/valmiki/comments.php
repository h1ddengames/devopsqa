<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to valmiki_comment() which is
 * located in the inc/template-tags.php file.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * valmiki_before_comments hook.
 *
 */
do_action( 'valmiki_before_comments' );
?>
<div id="comments">

	<?php
	/**
	 * valmiki_inside_comments hook.
	 *
	 */
	do_action( 'valmiki_inside_comments' );

	if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( 1 === $comments_number ) {
				printf(
					/* translators: %s: post title */
					esc_html_x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'valmiki' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: number of comments, 2: post title */
					esc_html( _nx(
						'%1$s thought on &ldquo;%2$s&rdquo;',
						'%1$s thoughts on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'valmiki'
					) ),
					number_format_i18n( $comments_number ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h3>

		<?php
		/**
		 * valmiki_below_comments_title hook.
		 *
		 */
		do_action( 'valmiki_below_comments_title' );

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'valmiki' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'valmiki' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'valmiki' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			/*
			 * Loop through and list the comments. Tell wp_list_comments()
			 * to use valmiki_comment() to format the comments.
			 * If you want to override this in a child theme, then you can
			 * define valmiki_comment() and that will be used instead.
			 * See valmiki_comment() in inc/template-tags.php for more.
			 */
			wp_list_comments( array(
				'callback' => 'valmiki_comment',
			) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'valmiki' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'valmiki' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'valmiki' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
		<?php endif;

	endif;

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'valmiki' ); // WPCS: XSS OK. ?></p>
	<?php endif;

	$defaults = array(
		'comment_field' => '<p class="comment-form-comment"><label for="comment" class="screen-reader-text">' . esc_html__( 'Comment', 'valmiki' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'comment_notes_before' => null,
		'comment_notes_after'  => null,
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => apply_filters( 'valmiki_leave_comment', __( 'Leave a Comment', 'valmiki' ) ),
		'label_submit'         => apply_filters( 'valmiki_post_comment', __( 'Post Comment', 'valmiki' ) ),
	);

	comment_form( $defaults );
	?>

</div><!-- #comments -->
