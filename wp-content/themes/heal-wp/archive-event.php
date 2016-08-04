<?php
/**
 * Template Name: Event
 * @version 2.0.2
 * @package heal-wp
 */
get_header();
global $heal_option;
?>
<section id="primary" class="content-area">
	<div class="container blog-page-container">
		<div class="row">
			<div class="col-md-8 post-box">
				<?php 
				query_posts('post_type=event' );
				if(have_posts()) : while(have_posts()) : the_post(); 

				$date_formate = get_post_meta( $post->ID, '_events_setting_id_event_date', true );	
				$start_time = get_post_meta( $post->ID, '_events_setting_id_event_time', true );
				$start_end = get_post_meta( $post->ID, '_events_setting_id_event_time_end', true );

				?> 

				<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
					<div class="single-event-post">
						
						<figure class="featured-image">
							<?php if(has_post_thumbnail()) { ?>
							<?php the_post_thumbnail(); ?>
							<?php }else{ ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/no-img.jpg" alt="">
							<?php } ?>
							<figcaption>
								<div class="col-md-12">
									<div class="col-md-4">
										<?php _e('<h3>Event Start: </h3>', 'heal') ?>
									</div>
									<div class="col-md-8">					
										<div id="<?php echo get_the_id(); ?>" class="next-event-container">
											<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-200" style="opacity: 1; bottom: 0px;">
												<div class="time-circle dash days_dash animated" data-animation="rollIn" data-animation-delay="300">
													<span class="time-number">
														
														<span class="digit">
															<div class="top" style="display: none;">0</div>
															<div class="bottom" style="display: block;">0</div>
														</span>
														<span class="digit">
															<div class="top" style="display: none;">0</div>
															<div class="bottom" style="display: block;">0</div>
														</span>
														<span class="digit">
															<div class="top" style="display: none;">0</div>
															<div class="bottom" style="display: block;">0</div>
														</span>		
														<span class="time-name">Days</span>
													</span>
												</div><!-- /.time-circle -->
											</div><!-- /.col-md-3 -->
											<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-600" style="opacity: 1; bottom: 0px;">
												<div class="time-circle dash hours_dash animated" data-animation="rollIn" data-animation-delay="600">
													<span class="time-number">
														<span class="digit"><div class="top" style="display: none;">2</div><div class="bottom" style="display: block;">2</div></span><span class="digit"><div class="top" style="display: none;">2</div><div class="bottom" style="display: block;">2</div></span>
														<span class="time-name hour">Hours</span>
													</span>
												</div><!-- /.time-circle -->
											</div><!-- /.col-md-3 -->
											<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-1000" style="opacity: 1; bottom: 0px;">
												<div class="time-circle dash minutes_dash animated" data-animation="rollIn" data-animation-delay="900">
													<span class="time-number">
														<span class="digit"><div class="top" style="display: none;">0</div><div class="bottom" style="display: block;">0</div></span><span class="digit"><div class="top" style="display: none;">8</div><div class="bottom" style="display: block;">8</div></span>
														<span class="time-name min">Minutes</span>
													</span>
												</div><!-- /.time-circle -->
											</div><!-- /.col-md-3 -->
											<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-1400" style="opacity: 1; bottom: 0px;">
												<div class="time-circle dash seconds_dash animated" data-animation="rollIn" data-animation-delay="1200">
													<span class="time-number">
														<span class="digit"><div class="top" style="display: block; overflow: hidden; height: 12.0781px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;">0</div><div class="bottom" style="display: block; overflow: hidden; height: 21.3901825998375px;">1</div></span><span class="digit"><div class="top" style="display: block; overflow: hidden; height: 12.0781px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;">9</div><div class="bottom" style="display: block; overflow: hidden; height: 21.3901825998375px;">0</div></span>
														<span class="time-name sec">Seconds</span>
													</span>
												</div><!-- /.time-circle -->
											</div><!-- /.col-md-3 -->
										</div>
										<!-- /.progress -->
									</div>
								</div>
							</figcaption>
						</figure>

						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="entry-content clearfix">
							<?php the_excerpt(); ?>

							<a class="btn custom-btn angle-effect" href="<?php the_permalink(); ?>"><?php _e('Read More', 'heal') ?></a>

						</div><!-- .entry-content -->

					</div>
					<!-- ./single-causes-post -->
				</article><!-- #post-## -->

				
				<script>

					jQuery(document).ready(function($) {
						"use strict";
						<?php if(!empty($date_formate) || !empty($start_time) && !empty($end_time) ) { ?>
							$('#<?php echo get_the_id(); ?>').countDown({
								targetDate: {
									'day': '<?php echo (date("j", $date_formate)) ? date("j", $date_formate) : '0'; ?>',
									'month': '<?php echo (date("m", $date_formate)) ? date("m", $date_formate) : '0'; ?>',
									'year': '<?php echo (date("Y", $date_formate)) ? date("Y", $date_formate) : '0'; ?>',
									'hour': '<?php echo (date("H", $start_time)) ? date("H", $start_time) : '0'; ?>',
									'min': '<?php echo (date("i", $start_time)) ? date("i", $start_time) : '0'; ?>',
									'sec': '0'
								},
								omitWeeks: true
							});
							<?php } ?>

						});	
				</script>

			<?php 


			endwhile; endif;
			wp_reset_postdata();
			?>
		</div><!-- /.col-md-10 -->

		<?php get_sidebar(); ?>

	</div>
</div>
</section>

<?php get_footer(); ?>