<?php
/**
 * The template for displaying search results pages.
 *
 * @package heal-wp
 */

get_header(); ?>
<div class="container blog-page-container">
	<div class="row">

		<div id="blog-section" class="col-md-8 blog-section">

			<!-- Post Box-->
			<div class="row post-box">
				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'heal' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->


					<?php 
				// start loop
					while ( have_posts() ) : the_post(); ?>

					<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'Buscar' );
				?>

			<?php endwhile; ?>

			<?php heal_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		
	</div>
	<!-- post box -->
	
</div>
<?php get_sidebar(); ?>
</div>
</div>
<!-- /.blog-page-container -->


<?php get_footer(); ?>
