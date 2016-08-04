<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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

				

						<?php get_template_part( 'content', 'page' ); ?>


				<?php endwhile; // end of the loop. ?>
			</div><!-- /#post-box --><!-- /.row -->
			<!-- Post Box End -->
			<hr>

		</div><!-- /#blog-section -->	
		<?php get_sidebar(); ?>
		
	</div>
</div>
<?php get_footer(); ?>
