<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;
	
/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/
	$service_menu = $heal_option['heal_service_menu']; 
	$service_id = strtolower(str_replace(' ', '_', $service_menu));
	?>
	<!-- Services Section -->
	<section id="<?php echo esc_attr( $service_id ); ?>">
		<?php if(!$heal_option['heal_service_agular']) { ?> 
		<div class="services-section white-bg angular section-padding">
			<div class="top-angle">
			</div><!-- /.top-angle -->
			<?php } else { ?>
			<div class="services-section white-bg section-padding">
				<?php } ?>
				<div class="container pb areas">
					<div class="section-head clearfix">
						<h2 class="section-title"><?php echo esc_html( $heal_option['heal_service_title'] ); ?></h2>
						<div class="section-description">
							<?php echo wp_kses_stripslashes( $heal_option['heal_service_des'] ); ?>
						</div>
						
					</div><!-- /.section-head clearfix -->
					<div class="section-content">
						<div class="row">
							<?php 
							query_posts('post_type=service' );	
							if(have_posts()) : while(have_posts()) : the_post(); ?> 
							<div class="col-md-4 from-bottom delay-200">
								<div class="service-box">
										<div class="service-icon" style='position: relative; margin-bottom: 17px;'>
											<?php
											$titulo = (get_post_meta($post->ID, '_service_setting_id_icon', true));
											switch ($titulo) {
												case 'li_world':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-02.jpg">';
													break;
												case 'li_search':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-06.jpg">';
													break;
												case 'li_heart':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-05.jpg">';
													break;
												case 'li_key':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-03.jpg">';
													break;	
												case 'li_lock':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-01.jpg">';
													break;
												case 'li_megaphone':
													echo '<img style="width:45%" src="http://grulla360.com.ar/ADC/wp-content/uploads/2016/05/Areas-M-04.jpg">';
													break;
											}
											?>
										</div><!-- /.service-icon -->
									<h3 class="service-title content-title"><?php the_title(); ?></h3><!-- /.service-title content-title -->
									<p class="service-description"><?php echo(get_the_excerpt()); ?></p><!-- /.service-description -->
									<div class="services-button">
										<a href="<?php the_permalink(); ?>" class="btn custom-btn angle-effect">
											<?php echo esc_attr((get_post_meta($post->ID, '_service_setting_id_learn_more', true)) ? get_post_meta($post->ID, '_service_setting_id_learn_more', true) : _e('Learn More', 'heal')) ; ?>
										</a>
									</div><!-- /.services-button -->
								</div><!-- /.service-box -->
							</div><!-- /.col-md-4 -->
						<?php endwhile;endif; 
						wp_reset_query(); //reset Query
						?>
					</div><!-- /.row -->
				</div><!-- /.section-content -->
			</div><!-- /.container-->
		</div><!-- /.services-section -->
	</section><!-- /#services -->
	<!--Services Section End-->

	<?php if ($heal_option['heal_pricing_on_off']) { ?>
	<!-- Pricing Section -->
	<section id="pricing"> 
		<div class="pricing-section">
			<?php if(!$heal_option['heal_service_pricing_agular']) { ?> 
			<div class="gray-bg angular">
				<div class="top-angle">
				</div><!-- /.top-angle -->
				<div class="container pb">
				<?php } else { ?>
				<div class="gray-bg padding2"> 	<div class="container padin">
					<?php } ?>
						<div class="row">
							<div class="section-content espaciodona">
								<div class="col-md-4 from-bottom delay-200">
									<div class="content-box">
										<div class="hex content-icon-hex hex-margin1">
											<div class="content-icon">
												<span aria-hidden="true" class="<?php echo esc_attr($heal_option['heal_team_guardian_icon']); ?>"></span>
											</div>
										</div><!-- /.content-icon-hex -->
										<h3 class="content-title2 titulogrande">
											<?php echo esc_html($heal_option['heal_guardian_title']); ?>
										</h3><!-- /.content-title --> 					<h3 class="content-title55"><?php echo wp_kses_stripslashes( $heal_option['heal_guardian_des'] ); ?>									</p> 
									</div><!-- /.content-box -->
								</div><!-- /.col-md-4 -->
								<div class="col-md-8 from-right delay-200 margin-responsive">
									<div class="pricing-table">
										<div class="pricing-item">
											<div class="item-head">
												<span class="item-name"><?php echo esc_html($heal_option['heal_basic_pricing_title']); ?></span>
												<span class="item-currency"></span><span class="item-price"><?php echo esc_html($heal_option['heal_basic_pricing_price']); ?></span> 
											</div><!-- /.item-head -->
											<div class="item-footer">
												<a href="<?php echo esc_url($heal_option['heal_basic_pricing_price_link']); ?>" class="btn custom-btn angle-effect"><?php echo ($heal_option['heal_basic_pricing_price_button_text']) ? $heal_option['heal_basic_pricing_price_button_text'] : _e('Purchase', 'heal') ?></a>
											</div><!-- /.item-footer -->
										</div><!-- /.pricing-item -->
										<div class="pricing-item even">
											<div class="item-head">
												<span class="item-name"><?php echo esc_html($heal_option['heal_gold_pricing_title']); ?></span>
												<span class="item-currency"></span><span class="item-price"><?php echo esc_html($heal_option['heal_gold_pricing_price']); ?></span> 
											</div><!-- /.item-head -->
											<div class="item-footer">
												<a href="<?php echo esc_url($heal_option['heal_gold_pricing_price_link']); ?>" class="btn custom-btn angle-effect"><?php echo ($heal_option['heal_gold_pricing_price_button_text']) ? $heal_option['heal_gold_pricing_price_button_text'] : _e('Purchase', 'heal') ?></a>
											</div><!-- /.item-footer -->
										</div><!-- /.pricing-item -->
										<div class="pricing-item">
											<div class="item-head">
												<span class="item-name"><?php echo esc_html( $heal_option['heal_silver_pricing_title'] ); ?></span>
												<span class="item-currency"></span><span class="item-price"><?php echo esc_html($heal_option['heal_silver_pricing_price']); ?></span> 
											</div><!-- /.item-head -->
											<div class="item-footer">
												<a href="<?php echo esc_url($heal_option['heal_silver_pricing_price_link']); ?>" class="btn custom-btn angle-effect"><?php echo ($heal_option['heal_silver_pricing_price_button_text']) ? $heal_option['heal_silver_pricing_price_button_text'] : _e('Purchase', 'heal') ?></a>
											</div><!-- /.item-footer -->
										</div><!-- /.pricing-item -->
									</div><!-- /.pricing-table -->
								</div><!-- /.col-md-8 -->
							</div><!-- /.section-content -->
						</div><!-- /.row -->
					</div><!-- /.container -->
				</div><!-- ./gray-bg -->
			</div><!-- /.pricing-section -->
		</section><!-- /#pricing -->
		<!-- Pricing Section End -->
<?php } ?>

<?php if ($heal_option['heal_volunteer_off_on']) { ?>

		<!-- Volunteer Section -->
		<section id="volunteer">
			<div class="volunteer-section">
				<?php if(!$heal_option['heal_volunteer_agular']) { ?> 
				<div class="gray-bg angular section-padding">
					<div class="top-angle">
					</div><!-- /.top-angle -->
					<div class="container pb">
					<?php } else { ?>
					<div class="gray-bg section-padding">
					<div class="container">
						<?php } ?>
						
							<div class="row">
								<div class="section-content">
									<div class="media-content media-left col-md-4 from-bottom delay-200">
										<div class="meida-container">
											<img src="<?php echo esc_url($heal_option['heal_team_volunteer_img']['url']); ?>" alt="">
										</div><!-- /.meida-container -->
									</div><!-- /.media-content -->
									<div class="content-box col-md-8 from-bottom delay-600">
										<div class="hex content-icon-hex pull-left">
											<div class="content-icon">
												<span aria-hidden="true" class="<?php echo esc_attr($heal_option['heal_team_volunteer_icon']); ?>"></span>
											</div>
										</div><!-- /.content-icon-hex -->
										<h3 class="content-title2"><?php echo esc_html($heal_option['heal_team_volunteer_title']); ?></h3>
										<?php echo wp_kses_stripslashes( $heal_option['heal_team_volunteer_des'] ); ?>
										<p>
											<a href="<?php echo esc_url($heal_option['heal_team_volunteer_link']); ?>" class="btn custom-btn angle-effect anotate">
												<?php echo $heal_option['heal_team_volunteer_text_link']; ?>
											</a>
										</p>
									</div><!-- /.content-box -->
								</div><!-- /.section-content -->
							</div><!-- /.row -->
						</div><!-- /.container -->
					</div><!-- ./gray-bg -->
				</div><!-- /.volunteer-section -->
			</section><!-- /#volunteer -->
			<!-- Volunteer Section End -->
			<?php } ?>