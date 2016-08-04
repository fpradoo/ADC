<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package heal-wp
 */

/*-----------------------------------------------------------------------------------*/
/*	Display navigation to next/previous set of posts when applicable.  
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_paging_nav' ) ) :

function heal_paging_nav($pages = '', $range = 2) {
	
	$showitems = ($range * 1)+1;  

	global $paged;

	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;

		if(!$pages)
		{
			$pages = 1;
		}
	}   

	if(1 != $pages)
	{
		echo '<div class="row post-box">';
		echo '<div class="col-sm-2"></div><div class="page-navigator col-sm-10"><ul class="page-navigation">';
	
		if($paged > 2 && $paged > $range+1 && $showitems < $pages){
			echo '<li><a class="page-no pre" href="'.get_pagenum_link(1).'"></a></li>';
		}


		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<li><a href='#' class='page-no pre active'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='page-no pre'>".$i."</a></li>";
			}
		}


		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
			echo '<li><a class="page-no pre" href="'.get_pagenum_link($pages).'">&raquo;</a></li>';
		}

	
		echo '</ul></div>';
		echo '</div>';

	}
}

endif;


/*-----------------------------------------------------------------------------------*/
/*	  Display navigation to next/previous set of posts when applicable.
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_wp_paging_nav' ) ) :
function heal_wp_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'heal' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="btn read-more pull-left"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'heal' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="btn read-more pull-right"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'heal' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	  Display navigation to next/previous post when applicable.
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_post_nav' ) ) :

function heal_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		
		<div class="nav-links">
			<?php
			previous_post_link( '<div class="nav-previous pull-left">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'heal' ) );
			next_post_link(     '<div class="nav-next pull-right">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'heal' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	 Prints HTML with meta information for the current post-date/time and author. 
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_posted_on' ) ) :

function heal_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
		);

	
	$num_comments = get_comments_number();

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __('No Comments','heal');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments', 'heal');
		} else {
			$comments = __('1 Comment', 'heal');
		}
		$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';

	} else {
		$write_comments =  __('Comments are off for this post.', 'heal');

	}

	$categories = get_the_category();

	$separator = ', ';
	$output = '';
	if($categories){
		foreach($categories as $category) {
			$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'heal' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}
	}

	$category_name = sprintf(
		_x('In %s', 'category name', 'heal'), trim($output, $separator)
		);

	$comments_count = sprintf(
		_x('With %s |', 'comments number', 'heal'), $write_comments
		);
	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'heal' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

	$byline = sprintf(
		_x( 'Posted by %s | ', 'post author', 'heal' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( ucfirst(get_the_author()) ) . '</a></span>'
		);

	echo '<p class="post-meta">' . $byline . $comments_count . '<span class="byline"> ' . $category_name . '</span></p>';

}
endif;

/*-----------------------------------------------------------------------------------*/
/*	  Prints HTML with meta information for the categories, tags and comments.
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_entry_footer' ) ) :

function heal_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'heal' ) );
		if ( $tags_list ) {
			printf( '<span class="tagcloud">' . __( 'Tagged %1$s', 'heal' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'heal' ), __( '1 Comment', 'heal' ), __( '% Comments', 'heal' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'heal' ), '<span class="edit-link">', '</span>' );
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	  Returns true if a blog has more than 1 category.
/*-----------------------------------------------------------------------------------*/ 

function heal_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'heal_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
			) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'heal_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so heal_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so heal_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in heal_categorized_blog.
 */
function heal_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'heal_categories' );
}
add_action( 'edit_category', 'heal_category_transient_flusher' );
add_action( 'save_post',     'heal_category_transient_flusher' );


/*-----------------------------------------------------------------------------------*/
/*	 post formate icom 
/*-----------------------------------------------------------------------------------*/ 

function heal_post_format_icon() {
	
	if ( has_post_format( 'aside' )) {
		echo '<i class="fa fa-file-text-o"></i>';
	} elseif ( has_post_format( 'chat' )) {
		echo '<i class="fa fa-wechat"></i>';
	} elseif ( has_post_format( 'gallery' )) {
		echo '<i class="fa fa-film"></i>';
	} elseif ( has_post_format( 'link' )) {
		echo '<i class="fa fa-link"></i>';
	} elseif ( has_post_format( 'image' )) {
		echo '<i class="fa fa-file-image-o"></i>';
	} elseif ( has_post_format( 'quote' )) {
		echo '<i class="fa fa-quote-left"></i>';
	} elseif ( has_post_format( 'status' )) {
		echo '<i class="fa fa-refresh"></i>';
	} elseif ( has_post_format( 'video' )) {
		echo '<i class="fa fa-file-video-o"></i>';
	} elseif ( has_post_format( 'audio' )) {
		echo '<i class="fa fa-file-audio-o"></i>';
	} else {
		echo '<i class="fa fa-pencil"></i>';
	}

}