<?php
/**
 * The template for displaying home page content.
 * Template Name: Full width Page without sidebar
 * @package heal
 */

get_header(); ?>
<div class="container blog-page-container">
	<div class="row">

		<div id="blog-section" class="col-md-12 blog-section">

			<!-- Post Box-->
			<div class="row post-box">
				<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div><!-- /#post-box --><!-- /.row -->
			<!-- Post Box End -->
			<hr>

		</div><!-- /#blog-section -->	
		
	</div>
</div>
<?php get_footer(); ?>
