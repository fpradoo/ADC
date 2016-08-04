<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package heal
 */

/**-----------------------------------------------------------------------------------------------
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 -------------------------------------------------------------------------------------------------*/

function heal_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'heal_page_menu_args' );

/*-----------------------------------------------------------
    heal nav menu.
    -----------------------------------------------------------*/

function heal_nav_menu(){
    if (function_exists('wp_nav_menu')) {
        wp_nav_menu( array( 
            'theme_location'    => 'inner_menu', 
            'menu_class'        => 'nav navbar-nav pull-right',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
        );
    };
}

/**-----------------------------------------------------------------------------------------------
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 -----------------------------------------------------------------------------------------------*/

function heal_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'heal_body_classes' );


/**-----------------------------------------------------------------------------------------------
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 -----------------------------------------------------------------------------------------------*/

function heal_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'heal' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'heal_wp_title', 10, 2 );

/**-----------------------------------------------------------------------------------------------
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 -----------------------------------------------------------------------------------------------*/

function heal_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'heal_setup_author' );


/*-----------------------------------------------------------
    favicon image.
    -----------------------------------------------------------*/

if (!function_exists("ccr_favicon")) {
    function ccr_favicon(){
        global $heal_option;        
        if( $heal_option['heal_favicon_icon'] ){
            echo '<link rel="shortcut icon" href="' . $heal_option['heal_favicon_icon']['url'] .'" >';            
        } else {
            echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/favicon.png" >';
        }
    }
}


/*-----------------------------------------------------------
    excerpt filtering.
    -----------------------------------------------------------*/

function new_excerpt_more( $more ) {
    return ' ';
}
add_filter('excerpt_more', 'new_excerpt_more');


/*-----------------------------------------------------------
    post excerpt length.
    -----------------------------------------------------------*/

function heal_excerpt_length($length) {    
    global $heal_option;
    return $heal_option['blog_excerpt_length'];
}
add_filter('excerpt_length', 'heal_excerpt_length');


/*-----------------------------------------------------------
    get blog url dynamically.
    -----------------------------------------------------------*/

function heal_get_blog_link(){
    $blog_post = get_option("page_for_posts");
    if($blog_post){
        $permalink = get_permalink($blog_post);
    }
    else
        $permalink = site_url();
    return $permalink;
}


/*-----------------------------------------------------------
    filter search form.
    -----------------------------------------------------------*/

add_filter('get_search_form', 'heal_filter_search_form');

function heal_filter_search_form($form) {
    $form = '<form role="search" method="get" id="searchform" class="sidebar-search  clearfix" action="' . home_url( '/' ) . '" >
    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" required>
    <button class="btn" type="submit"><i class="fa fa-search"></i></button></form>';

    return $form;
}



/*-----------------------------------------------------------
    worpdress logo can be change.
    -----------------------------------------------------------*/

if(!function_exists('ccr_admin_logo_login')){
    function ccr_admin_logo_login(){
        global $heal_option;
        if( $heal_option['admin_logo']['url'] ){
            ?>
            <style type="text/css">
                body.login div#login h1 a {
                    background-image: url("<?php echo esc_url($heal_option['admin_logo']['url']);?>");
                    padding-bottom: 30px;
                }
            </style>

            <?php } else { ?>

            <style type="text/css">
                body.login div#login h1 a {
                    background-image: url('<?php echo admin_url('/images/wordpress-logo.png');?>');
                    padding-bottom: 30px;
                }
            </style>

            <?php }
        }
        add_action( 'login_enqueue_scripts', 'ccr_admin_logo_login' );
    }

/*-----------------------------------------------------------
    Logo Login URL changed from wordpress.org to Site URL.
    -----------------------------------------------------------*/

    if(!function_exists('ccr_logo_login_url')){
        function ccr_logo_login_url(){
            return site_url();
        }
        add_filter( 'login_headerurl', 'ccr_logo_login_url' );
    }



/*-----------------------------------------------------------------------------------*/
/*      heal Comment
/*-----------------------------------------------------------------------------------*/ 


if(!function_exists('heal_comment')):

    function heal_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
            // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="submited-comment">

        <p>Pingback: <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'heal' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
        break;
        default :

        global $post;
        ?>

        <li <?php comment_class(); ?>>

            <div class="comment">
                <ul class="commentlist">

                    <li class="comment" id="comment-<?php comment_ID(); ?>">
                        <article>
                            <div class="author-image col-md-3">
                             <?php
                             echo get_avatar( $comment, $args['avatar_size'] );
                             ?>               
                         </div><!-- /.author -->


                         <div class="comment-content col-md-9">
                            <p class="comment-meta">
                                <?php
                                printf( '<span class="comment-author">%1$s</span>',
                                    get_comment_author_link());
                                    ?><br> 
                                    On <?php echo get_comment_date() ?> <span class="comment-time"> at <?php echo get_comment_time()?></span>
                                    <?php edit_comment_link( __( 'Edit', 'heal' ), '<span class="edit-link">', '</span>' ); ?>
                                </p>
                                <?php comment_text(); ?>
                                <p>

                                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'heal' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

                                </p>
                                <?php if ( '0' == $comment->comment_approved ) : ?>
                                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'heal' ); ?></p>
                                <?php endif; ?>

                            </div>
                        </article>
                    </li>

                </ul>
            </div>

            <?php
            break;
            endswitch; 
        }

        endif;

