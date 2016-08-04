<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package heal
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>


	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="title">
			<?php comments_number( __('0 Comment', 'heal' ), __('1 Comment', 'heal' ), __('% Comments', 'heal' ) ); ?>
		</h3>

		<div id="submited-comment" class="comment-list">

			<?php
			wp_list_comments( array(
				'style'       => 'li',
				'short_ping'  => true,
				'callback' => 'heal_comment',
				'avatar_size' => 100
				) );
				?>
			</div><!-- .comment-list -->

			<?php 

		// are there comments to navigate through 
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'heal' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'heal' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'heal' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'heal' ); ?></p>
	<?php endif; ?>


	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'heal' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'heal' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'heal' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
	<?php endif; // check for comment navigation ?>

<?php endif; // have_comments() ?>

<div id="leave-comment" class="clearfix">

	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<input class="form-control" id="author" name="author" type="text" placeholder="Name" size="30"' . $aria_req . '/>',
		'email'  => '<input class="form-control" id="email" name="email" type="email" placeholder="Email" size="30"' . $aria_req . '/>',
				//'url'  => '<input id="url" name="url" type="url" placeholder="Website" value="">',
		);

	$comments_args = array(
		'fields' =>  $fields,
		'id_form'          			=> 'commentform',
		'title_reply'       		=> __( 'Dejanos un comentario', 'heal' ),
		'title_reply_to'    		=> __( 'Comentar to %s', 'heal' ),
		'cancel_reply_link' 		=> __( 'Cancelar comentario', 'heal' ),
		'label_submit'      		=> __( 'COMENTAR', 'heal' ),
		'comment_notes_before'      => '',
		'comment_notes_after'       => '',
		'comment_field'             => '<textarea class="form-control" id="comment" name="comment" placeholder="Mensaje" rows="8" required></textarea>',
		'label_submit'              => 'Comentar'
		);
	ob_start();
	comment_form($comments_args);
			//echo str_replace('class="comment-form"','class="comment-form"',ob_get_clean());
			//echo str_replace('class="form-submit"','class="form-submit"',ob_get_clean());
	?>

</div><!-- #comments -->
