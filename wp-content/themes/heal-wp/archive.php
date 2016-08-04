<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package heal-wp
 */

get_header(); ?>

<section id="primary" class="content-area">
	<div class="container blog-page-container">
		<div class="row">

			<div id="blog-section" class="col-md-8 blog-section">
				<main id="main" class="site-main" role="main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
								<?php
								if ( is_category() ) :
									single_cat_title();

								elseif ( is_tag() ) :
									single_tag_title();

								elseif ( is_author() ) :
									printf( __( 'Author: %s', 'heal' ), '<span class="vcard">' . get_the_author() . '</span>' );

								elseif ( is_day() ) :
									printf( __( 'Day: %s', 'heal' ), '<span>' . get_the_date() . '</span>' );

								elseif ( is_month() ) :
									printf( __( 'Month: %s', 'heal' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'heal' ) ) . '</span>' );

								elseif ( is_year() ) :
									printf( __( 'Year: %s', 'heal' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'heal' ) ) . '</span>' );

								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									_e( 'Asides', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
									_e( 'Galleries', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									_e( 'Images', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									_e( 'Videos', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									_e( 'Quotes', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									_e( 'Links', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
									_e( 'Statuses', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
									_e( 'Audios', 'heal' );

								elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
									_e( 'Chats', 'heal' );

								else :
									_e( 'Archives', 'heal' );

								endif;
								?>
							</h1>
							<?php
					// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
							?>
						</header><!-- .page-header -->

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

					<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php heal_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>
		</main><!-- #main -->


	</div>
	<?php get_sidebar(); ?>
</div>
</div>

</section><!-- #primary -->

<?php get_footer(); ?>
