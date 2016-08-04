<?php
/**
 * The template for displaying home page content.
 * Template Name: Full width Page without title
 * @package heal
 */

get_header(); ?>
<div class="container blog-page-container">
	<div class="row">

		<div id="blog-section">

			<!-- Post Box-->
			<div class="row post-box">
				<?php while ( have_posts() ) : the_post(); ?>

					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
						<div class="entry-content">
							<?php the_content(); ?>
							<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'heal' ),
								'after'  => '</div>',
								) );
								?>
							</div><!-- .entry-content -->

							<footer class="entry-footer">
								<?php edit_post_link( __( 'Edit', 'heal' ), '<span class="edit-link">', '</span>' ); ?>
							</footer><!-- .entry-footer -->
						</article><!-- #post-## -->


					<?php endwhile; // end of the loop. ?>
				</div><!-- /#post-box --><!-- /.row -->
				<!-- Post Box End -->
				<hr>

			</div><!-- /#blog-section -->	
			
		</div>
	</div>
	<?php get_footer(); ?>
