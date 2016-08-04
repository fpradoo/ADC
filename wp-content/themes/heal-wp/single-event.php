<?php
/**
 * The template for displaying all single posts.
 *
 * @package heal-wp
 */

get_header(); ?>
<div class="container blog-page-container">
	<div class="row">

		<div id="blog-section" class="col-md-8 blog-section">

			<!-- Post Box-->
			<div class="row post-box">
			
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'event' ); ?>


					<?php endwhile; // end of the loop. ?>
					
			</div><!-- /#post-box --><!-- /.row -->
			<!-- Post Box End -->
			<hr>
			<?php heal_post_nav(); ?>

		</div><!-- /#blog-section -->	
		<?php get_sidebar(); ?>
		
	</div>
</div>
<?php get_footer(); ?>
