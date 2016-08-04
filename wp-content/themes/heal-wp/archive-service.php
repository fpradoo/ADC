<?php
/**
 * Template Name: Service
 * @version 1.1.1
 * @package heal-wp
 */

get_header(); ?>

<section id="primary" class="content-area">
	<div class="container blog-page-container">
		<div class="row">

			<div id="blog-section" class="col-md-8 blog-section">
				
				<?php 

				query_posts('post_type=service' );

				if ( have_posts() ) : ?>

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

				

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			<?php heal_paging_nav(); ?>

		</div>
		<?php get_sidebar(); ?>

	</div>
	<!-- ./blog-section -->
	
</div>


</section><!-- #primary -->

<?php get_footer(); ?>
