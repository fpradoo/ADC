<?php
/**
 * Template Name: Causes
 * @version 1.1.1
 * @package heal-wp
 */

get_header(); 

global $heal_option;

?>
<section id="primary" class="content-area">
	<div class="container blog-page-container">
		<div class="row">

			<div id="blog-section" class="col-md-8 blog-section post-box">

				<?php 
				query_posts('post_type=causes' );
				if ( have_posts() ) : while(have_posts()) : the_post();

				$heal_causes_id = get_the_ID();

				$donation_goal = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_goal', true );
				$donation_current = round( get_post_meta( $heal_causes_id, '_causes_setting_id_donation_manual', true ) );

				$display_donation_bar = true;
				if ( $donation_goal == '' || $donation_goal == 0 ) {
					$display_donation_bar = false;
				}

				if ( $donation_current == '' || $donation_current == 0 ) {
					$donation_percentage = 0;
					$donation_current = 0;
					$donation_need = 0;
				} else {
					if ( $display_donation_bar ) {
						$donation_percentage = round ( $donation_current / $donation_goal * 100, 2 );
						$donation_need = $donation_goal-$donation_current;
					} else {
						$donation_percentage = '0';
					}
				}

				?>


				<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
					<div class="single-causes-post">
						<figure class="featured-image">
							<?php if ( has_post_thumbnail() ) { 
								the_post_thumbnail(); 
							} else {
								echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
							}
							?>
							<figcaption>
								<div class="col-sm-9">
									<?php if ( $display_donation_bar ) : ?>
										<div class="caption-txt pull">
											<span class="donated"><?php echo esc_html($donation_percentage); ?><?php _e('% Donated', 'heal') ?></span>
											<span class="to-go">/ <?php _e('$', 'heal') ?><?php echo esc_html($donation_need); ?> <?php _e('To Go', 'heal') ?></span>
											<span class="to-need">/ <?php _e('$', 'heal') ?><?php echo esc_html($donation_goal); ?> <?php _e('Goal', 'heal') ?></span>
										</div>


										<div class="progress">
											<div id="causes-progress-1" class="progress-bar custom-progress-bar" role="progressbar" aria-valuenow="60" style="width:<?php echo esc_html($donation_percentage); ?>%;" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">
													<?php echo esc_html($donation_percentage); ?><?php _e('% Complete', 'heal') ?></span>
												</div>
											</div>
										<?php endif; ?>
										<!-- /.progress -->
									</div>

								</figcaption>
							</figure>

							<h2 class="post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<div class="entry-content">
								<?php the_excerpt(); ?>

								<a class="btn custom-btn angle-effect" href="<?php the_permalink(); ?>"><?php _e('Read More', 'heal') ?></a>

								
							</div><!-- .entry-content -->


						</div>
					</article>
				<?php endwhile; ?>



			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			<?php heal_paging_nav(); ?>

		</div>
		

		<?php get_sidebar(); ?>

		<!-- ./blog-section -->

	</div>


</div>
</section><!-- #primary -->

<?php get_footer(); ?>
