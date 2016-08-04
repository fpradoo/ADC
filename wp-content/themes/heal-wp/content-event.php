<?php
/**
 * @package heal-wp
 */
global $heal_option;
$date_formate = get_post_meta( $post->ID, '_events_setting_id_event_date', true );	
$start_time = get_post_meta( $post->ID, '_events_setting_id_event_time', true );
$start_end = get_post_meta( $post->ID, '_events_setting_id_event_time_end', true );
?>
<div class="col-md-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
		<div class="single-event-post">
			<figure class="featured-image">
				<?php if(has_post_thumbnail()) { ?>
				<?php the_post_thumbnail(); ?>
				<?php }else{ ?>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/no-img.jpg" alt="">
				<?php } ?>
				<figcaption>
					<div class="col-md-12 chaucirculos">
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
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>	
											<span class="time-name hour">Hours</span>
										</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->
								<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-1000" style="opacity: 1; bottom: 0px;">
									<div class="time-circle dash minutes_dash animated" data-animation="rollIn" data-animation-delay="900">
										<span class="time-number">
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>	
											<span class="time-name min">Minutes</span>
										</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->
								<div class="col-xs-6 col-md-3 col-md-3 from-bottom delay-1400" style="opacity: 1; bottom: 0px;">
									<div class="time-circle dash seconds_dash animated" data-animation="rollIn" data-animation-delay="1200">
										<span class="time-number">
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>
											<span class="digit">
												<div class="top" style="display: none;">0</div>
												<div class="bottom" style="display: block;">0</div>
											</span>	
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
				<div class="event-timeline">
					<h4><?php _e('Event Timeline', 'heal'); ?></h4>
					<p>
						<?php if(!empty($date_formate)) { ?><?php _e('<b>Date</b>: ', 'heal'); ?> <?php echo date("F j, Y", $date_formate); ?> <br> <?php } ?>
							<?php if(!empty($start_time) ) { ?><?php _e('<b>Time</b>: ', 'heal'); ?> <?php echo date("H:i", $start_time); ?> to <?php echo date("H:i", $start_end); ?> <br> <?php } ?>
								
								<?php if(get_post_meta( $post->ID, '_events_setting_id_event_timezone', true )) { ?>	<?php _e('<b>Timezone</b>: ', 'heal'); ?> <?php echo esc_html(get_post_meta( $post->ID, '_events_setting_id_event_timezone', true )); ?> <br> <?php } ?>

								<?php if(get_post_meta( $post->ID, '_events_setting_id_event_place', true )) { ?>	<?php _e('<b>Place</b>: ', 'heal'); ?> <?php echo esc_html(get_post_meta( $post->ID, '_events_setting_id_event_place', true )); ?> <?php } ?>
							</p>
						</div>
						<?php the_content(); ?>
						<?php if(get_post_meta( $post->ID, '_events_setting_id_event_place_map', true ))  { ?>
						<div class="event-map">
							<h4><?php _e('Event Location', 'heal') ?></h4>
							<p>
								<div id="gmap_<?php echo get_the_id(); ?>" class="event-google-map"></div>
							</p>
						</div>
						<?php } ?>
						<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'heal' ),
							'after'  => '</div>',
							) );
							?>
						</div><!-- .entry-content -->
						<footer class="entry-footer clearfix">
							<?php heal_entry_footer(); ?>
						</footer><!-- .entry-footer -->
					</div>
					<!-- ./single-causes-post -->
				</article><!-- #post-## -->
			</div><!-- /.col-md-10 -->
			<script>
				jQuery(document).ready(function($) {
					"use strict";
					<?php if(!empty($date_formate) || !empty($start_time) && !empty($end_time) ) { ?>
						$('#<?php echo get_the_id(); ?>').countDown({
							targetDate: {
								'day': '<?php echo date("j", $date_formate); ?>',
								'month': '<?php echo date("m", $date_formate); ?>',
								'year': '<?php echo date("Y", $date_formate); ?>',
								'hour': '<?php echo date("H", $start_time); ?>',
								'min': '<?php echo date("i", $start_time); ?>',
								'sec': '0'
							},
							omitWeeks: true
						});
						<?php } ?>
		
							/*----------- Google Map - with support of gmaps.js ----------------*/
							function isMobile() { 
								return ('ontouchstart' in document.documentElement);
							}
							function init_gmap() {
								if ( typeof google == 'undefined' ) return;
								var options = {
									center: [<?php echo esc_html(get_post_meta( $post->ID, '_events_setting_id_event_place_map', true ) ); ?> ],
									zoom: 15,
									mapTypeControl: true,
									mapTypeControlOptions: {
										style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
									},
									navigationControl: true,
									scrollwheel: false,
									streetViewControl: true
								}
								if (isMobile()) {
									options.draggable = false;
								}
								$('#gmap_<?php echo get_the_id(); ?>').gmap3({
									map: {
										options: options
									},
									marker: {
										latLng: [<?php echo esc_html(get_post_meta( $post->ID, '_events_setting_id_event_place_map', true ) ); ?> ],
										options: { icon: '<?php echo esc_attr($heal_option['heal_map_icon']['url']); ?>' }
									}
								});
							}
							init_gmap();
						});	
</script>