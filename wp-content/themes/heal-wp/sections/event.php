<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;

/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/

	$event_menu = $heal_option['heal_event_menu']; 
	$event_id = strtolower(str_replace(' ', '_', $event_menu));

	?>
	<!-- Next Event -->
	<section id="<?php echo esc_attr( $event_id ); ?>">
		<?php if( $heal_option['heal_upevent_section_off'])  { ?>
		<?php if(!$heal_option['heal_upevent_section_agular']) { ?>
		<div id="next-event" class="next-event angular" data-type="background" data-speed="30">
		<div class="parallax-style">
			<div class="parallax-overlay section-padding">
			<div class="top-angle">
			</div><!-- /.top-angle -->	
			<div class="container pb">
			<?php } else { ?>
			<div id="next-event" class="next-event" data-type="background" data-speed="30">
				<div class="parallax-overlay section-padding">
				<div class="container">
				<?php } ?>

						<h3 class="parallax-title">
							<?php _e('our next event in', 'heal') ?>	
						</h3><!-- /.parallax-title -->
						<div class="row">
							<div id="event_time_countdown" class="next-event-container">

								<div class="col-xs-6 col-sm-3 col-md-3">
									<div class="time-circle dash days_dash ">
										<span class="time-number">
											<span class="digit">0</span><span class="digit">0</span><span class="digit">0</span>
										</span>
										<span class="time-name">Days</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->

								<div class="col-xs-6 col-sm-3 col-md-3">
									<div class="time-circle dash hours_dash ">
										<span class="time-number">
											<span class="digit">0</span><span class="digit">0</span>
										</span>
										<span class="time-name">Hours</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->

								<div class="col-xs-6 col-sm-3 col-md-3">
									<div class="time-circle dash minutes_dash ">
										<span class="time-number">
											<span class="digit">0</span><span class="digit">0</span>
										</span>
										<span class="time-name">Minutes</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->

								<div class="col-xs-6 col-sm-3 col-md-30">
									<div class="time-circle dash seconds_dash">
										<span class="time-number">
											<span class="digit">0</span><span class="digit">0</span>
										</span>
										<span class="time-name">Seconds</span>
									</div><!-- /.time-circle -->
								</div><!-- /.col-md-3 -->

							</div><!-- /.next-event-container -->
							<?php global $heal_option; 

							if(isset($heal_option['heal-event-posts-countdown'])) {
								query_posts('post_type=event&p=' .$heal_option['heal-event-posts-countdown']);
								if(have_posts()) : while(have_posts()) : the_post();  ?>
								<p class="event-btn-container">
									<a class="btn custom-btn angle-effect" href="<?php the_permalink(); ?>">Read More</a>
								</p>
								
							<?php endwhile; endif; wp_reset_query(); } ?>

						</div><!-- /.row -->
					</div><!-- /.container -->
				</div><!-- /.bg-parallax-overlay -->
			</div><!-- /.parallax-style -->
			</div>
			<?php } ?>
		</section><!-- /#next-event -->
		<!-- Next Event End -->	
		<!-- Upcoming Events Section -->
		<section id="upcoming-events">
			<?php if(!$heal_option['heal_upcomming_agular']) { ?>
			<div class="upcoming-events-section gray-bg angular section-padding">
				<div class="top-angle"></div>
				<?php } else { ?>
				<div class="upcoming-events-section gray-bg section-padding">
					<?php } ?>
					<div class="container">
						<div class="row">
							<div class="col-md-4">
								<div class="content-box">
									<div class="hex content-icon-hex hex-margin">
										<div class="content-icon">

											<span aria-hidden="true" class="<?php echo esc_attr($heal_option['heal_event_icon']); ?>"></span>
										</div><!-- /.content-icon -->
									</div><!-- /.content-icon-hex -->
									<h3 class="content-title"><?php echo esc_html( $heal_option['heal_event_title'] ); ?></h3>
									<p class="content-description"><strong><span style="color: #404040; font-family: Calibri; white-space: font-size: 12px: pre-wrap; line-height: 1.5;">LEADING CASES-</span></strong>
										<span style="color: #404040;font-family: Calibri;white-space: pre-wrap;text-align: left;font-size: 17px;">ADC litiga en casos de gran incidencia social, y en algunos casos, los fallos conseguidos han sentado jurisprudencia, sirviendo como base para generalizar medidas en beneficio de la sociedad civil en su conjunto
										</span>...
									</p>
								</div><!-- /.content-box -->

								<div id="event-owl-nav" class="slide-nav-containers owl-nav"></div><!-- /.slide-nav-container -->
							</div><!-- /.col-md-4 -->

							<div class="col-md-8">
								<div class="row">
									<div class="event-container padingeventapple">
										<div id="event-post-slider"  class="owl-carousel owl-theme padingevent">

								<?php 

								/*-----------------------------------------------------------
									event post type query start.
									-----------------------------------------------------------*/
									query_posts('post_type=event' );

									if(have_posts()) : while(have_posts()) : the_post(); ?> 

									<div class="item col-md-12">
										<div class="event-content padingevent">
											<h4 class="content-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4><!-- /.event-title -->
											<div class="event-date-time-place">
												<div>
													<?php 
													$date_formate = get_post_meta( $post->ID, '_events_setting_id_event_date', true );	
													$start_time = get_post_meta( $post->ID, '_events_setting_id_event_time', true );
													$start_end = get_post_meta( $post->ID, '_events_setting_id_event_time_end', true );


													?>
													<span><i class="fa fa-clock-o"></i></span> <?php if(!empty($date_formate)) echo gmdate("F j, Y", $date_formate); ?> <?php _e(' at ', 'heal') ?> <?php  if(!empty($start_time)) echo gmdate("g:i a", $start_time); ?> <?php _e(' to ', 'heal') ?> <?php if(!empty($start_end)) echo gmdate("g:i a", $start_end); ?>
												</div>

												<span><i class="fa fa-map-marker"></i></span> <?php _e('Place: ', 'heal'); ?> <?php echo esc_html( get_post_meta( $post->ID, '_events_setting_id_event_place', true )); ?>
											</div> 
											<div class="event-img">
												<?php if ( has_post_thumbnail() ) { 
													the_post_thumbnail('causes-thumb'); 
												} else {
													echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
												}
												?>
											</div><!-- /.event-img -->
										</div><!-- /.event-content  -->
									</div><!-- /.item col-md-12 -->
									<?php 
									endwhile;endif; 
									wp_reset_query(); // reset the query
									?>




								</div><!-- /#event-post-slider -->

							</div><!-- /.event-container-->
						</div><!-- /.row -->
					</div><!-- /.com-md-8 -->
				</div><!-- /.row --> 
			</div><!-- /.container -->
					
		</div><!-- /.upcoming-events-section -->
	</section><!-- /.upcoming-events -->	
		<!--Upcoming Events Section End-->