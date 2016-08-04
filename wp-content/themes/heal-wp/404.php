<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package heal-wp
 */

get_header(); ?>

<div id="primary" class="container blog-page-container">
	<main id="main" class="site-main" role="main">

		<section class="jumbotron error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops!!! Nothing Found', 'heal' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'heal' ); ?></p>

				<div class="blog-sidebar">
					<?php get_search_form(); ?>
				</div>
				<div class="col-md-6">
					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
				</div>
				
				<div class="col-md-6">
					<?php if ( heal_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
						<div class="widget widget_categories">
							<h2 class="widget-title"><?php _e( 'Most Used Categories', 'heal' ); ?></h2>
							<ul>
								<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
									) );
									?>
								</ul>
							</div><!-- .widget -->
						<?php endif; ?>
					</div>
					
						<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					
					

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
