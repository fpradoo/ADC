<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;

/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/
	$contact_menu = $heal_option['heal_contact_menu']; 
	$contact_id = strtolower(str_replace(' ', '_', $contact_menu));

	?>
	<!-- Contact Section -->
	<section id="<?php echo esc_attr( $contact_id ); ?>">
		<?php if(!$heal_option['heal_contact_section_agular']) { ?> 
		<div class="contact-section white-bg angular section-padding">
			<div class="top-angle">
			</div><!-- /.top-angle -->
			<div class="container pb">
			<?php } else { ?>
			<div class="contact-section section-padding">
			<div class="container">
				<?php } ?>
					<div class="section-head clearfix">
						<h2 class="section-title">
							<?php echo esc_html( $heal_option['heal_contact_title'] ); ?>
						</h2>
						<div class="sectioncontacto">
							<?php echo wp_kses_stripslashes( $heal_option['heal_contact_des'] ); ?>
						</div>
					</div><!-- /.section-head clearfix -->
				</div><!-- /.container -->

				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="contact-form-container">
								<h3 class="content-title">
									<?php echo esc_html($heal_option['heal_contact_form_7_title'] ); ?>
								</h3>
								<?php 
								$shortcode = $heal_option['heal_contact_form_7'];
								echo do_shortcode("$shortcode"); 
								?>

							</div><!-- /.contact-form-container -->
						</div><!-- /.col-md-6 -->

						<div class="col-md-6">
							<div class="contact-info">
								<h3 class="content-title">
									<?php echo esc_html($heal_option['heal_contact_address_title'] ); ?>
								</h3>
					<p class="content-description">
						<?php echo wp_kses_stripslashes( $heal_option['heal_contact_msg'] ); ?>						
								</p>
								<address> 
									<ul class="contact-address">
										<li class="fa-map-marker">
											<?php echo esc_html( $heal_option['heal_contact_address'] ); ?>
										</li>
										<li  class="fa-phone">
											<?php echo esc_html( $heal_option['heal_contact_mobile'] ); ?>
										</li>
										<li class="fa-envelope">
											<?php echo esc_html( $heal_option['heal_contact_email'] ); ?>
				
						</li>


</p>
<a class="btn custom-btn angle-effect1 mailboton" href="mailto:comunicacion@adc.org.ar">POR COMUNICACIÓN Y PRENSA</a>
</p>

<div class="footer-social-btn pull-right">
				<?php if($heal_option['heal_twitter']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_twitter']); ?>" class="twitter-btn"><i class="fa fa-twitter"></i></a>
				<?php } ?>

				<?php if($heal_option['heal_facebook']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_facebook']); ?>" class="facebook-btn"><i class="fa fa-facebook"></i></a>
				<?php }?>

									
				<?php if($heal_option['heal_google_plus']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_google_plus']); ?>" class="google-plus-btn"><i class="fa fa-google-plus"></i></a>
				<?php } ?>

				<?php if($heal_option['heal_youtube']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_youtube']); ?>" class="youtube-btn"><i class="fa fa-youtube"></i></a>
				<?php } ?>

				

			</div><!-- /.footer-social-btn -->


									</ul><!-- /.contact-address --> 
								</address>
							</div><!-- /.contact-info -->
						</div><!-- /.col-md-6 -->
					</div><!-- /.row -->
				</div><!-- /.container -->

			</div><!-- /.contact-section -->
		</section><!-- /#contact -->
		<!-- Contact Section End -->

		<?php if($heal_option['heal_map_on_off']) { ?>
		<!-- Google Map Section -->

		<div id="google-map">
		<?php if(!$heal_option['heal_map_agular']) { ?> 
		<div class="map-container white-bg angular">
			<div class="top-angle">
			</div><!-- /.top-angle -->
			<?php } else { ?>
			<div class="map-container">
			<?php } ?>
				<div id="googleMaps" class="google-map-container"></div>
			</div>
		</div><!-- /#google-map-->
		<!-- Google Map Section End -->	
		<?php } ?>