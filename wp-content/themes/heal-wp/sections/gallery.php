<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;
/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/
	
	$causes_menu = $heal_option['heal_causes_menu']; 
	$causes_id = strtolower(str_replace(' ', '_', $causes_menu));
	?>
	<?php 

	if( $heal_option['heal_donation_on_off'] ) {

	if (isset($heal_option['heal-causes-feature-posts-donation'])) {
		query_posts('post_type=causes&p=' .$heal_option['heal-causes-feature-posts-donation'] );
		if(have_posts()) : the_post(); 
	/*-----------------------------------------------------------
		donation calculation.
		-----------------------------------------------------------*/
		$heal_causes_id =get_the_ID();
		$donation_goal = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_goal', true );
		$donation_current = round( get_post_meta( $heal_causes_id, '_causes_setting_id_donation_manual', true ) );
		$currency_symbol = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_currency_symbol', true );
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
		<section id="<?php echo ($heal_option['heal_donation_button_on_off']) ? 'donate' : esc_attr($causes_id); ?>" class="donate-bg" data-type="background" data-speed="30">
			<div class="about-parallax parallax-style">
				<?php if(!$heal_option['heal_about_parallax_agular']) { ?>
				<div class="angular parallax-overlay section-padding">
					<div class="top-angle"></div>
					<div class="container pb">
					<?php } else { ?>
					<div class="parallax-overlay section-padding">
					<div class="container">
						<?php } ?>	
							<h3 class="parallax-title">
								<?php echo esc_html($heal_option['heal_about_donation']); ?>
							</h3><!-- /.parallax-title -->
							<p class="parallax-description">
								<?php the_title() ?> <?php echo ($currency_symbol) ? $currency_symbol : '$'; ?> <?php echo esc_html($donation_goal); ?> <br>
								<span class="amount"><?php echo ($currency_symbol) ? $currency_symbol : '$'; ?> <?php echo esc_html($donation_current); ?> </span><?php _e('so far !!', 'heal') ?> 
							</p><!-- /.parallax-description -->
							<div class="progress-bar-container">
								<div class="progress">
									<div id="about-progress-1" class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo esc_attr($donation_percentage); ?><?php _e('%', 'heal') ?>;">
										<span class="sr-only"><?php echo esc_html($donation_percentage); ?><?php _e('% Complete', 'heal') ?> </span>
									</div><!-- /.progress-bar -->
								</div><!-- /.progress -->
							</div><!-- /.progress-bar-container -->
							<p>
								<a href="<?php the_permalink(); ?>" class="btn donate-btn"><?php _e('Donate Now ', 'heal') ?><i class="fa fa-heart"></i></a>
							</p>
						</div><!-- /.container -->
					</div><!-- /.parallax-overlay -->
				</div><!-- /.about-parallax -->
			</section><!-- /#about-parallax -->
			<!-- About Parallax Section End -->
		<?php endif; 
	//reset query
		wp_reset_query();
	}
	?>

	<?php } ?>
	<!--Causes Section-->
	<section id="<?php echo esc_attr($causes_id); ?>">
		<?php if(!$heal_option['heal_causes_agular']) { ?> 
		<div class="causes-section gray-bg  angular section-padding">
			<div class="top-angle">
			</div><!-- /.top-angle -->
			<div class="container from-bottom delay-200 pb">
			<?php } else { ?>
			<div class="causes-section gray-bg section-padding">
			<div class="container from-bottom delay-200">
				<?php } ?>
					<div class="row">
						<div class="col-md-4"> 
							<div class="content-box">
								<div class="hex content-icon-hex hex-margin">
									<div class="content-icon">
										<span aria-hidden="true" class="<?php echo esc_attr($heal_option['heal_causes_icon']); ?>"></span>
									</div>
								</div>
								<h3 class="content-title">
									<?php echo esc_html($heal_option['heal_causes_title']); ?>
								</h3>
								<p class="content-description"> 
									<?php echo wp_kses_stripslashes($heal_option['heal_causes_des']); ?>
								</p>
								<div id="causes-owl-nav" class="slide-nav-container owl-nav"></div><!-- /.slide-nav-container -->


							</div><!-- /.content-box --> 
						</div><!-- /.col-md-4 -->
						<div class="col-md-8">
							<div class="row">
								<div id="causes-post-slider"  class="owl-carousel owl-theme">
									<?php 
								//query post
									query_posts('post_type=causes' );	
									if(have_posts()) : while(have_posts()) : the_post(); 
									$heal_causes_id =get_the_ID();
									$donation_goal = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_goal', true );
									$currency_symbol = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_currency_symbol', true );
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
									<div class="item col-md-12">
										<div class="causes-post">
											<figure>
												<?php if ( has_post_thumbnail() ) { 
													the_post_thumbnail('causes-thumb'); 
												} else {
													echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
												}
												?>
												<figcaption>
													<div class="caption-txt">
														<span class="donated"><?php echo esc_html($donation_percentage); ?><?php _e('% Donated', 'heal') ?></span>
														<span class="to-go">/ <?php echo ($currency_symbol) ? $currency_symbol : '$' ;?> <?php echo esc_html($donation_need); ?> <?php _e('To Go', 'heal') ?></span>
													</div>
													<div class="progress">
														<div id="causes-progress-<?php echo get_the_id(); ?>" class="progress-bar custom-progress-bar" role="progressbar" aria-valuenow="60" style="width:<?php echo esc_html($donation_percentage); ?><?php _e('%', 'heal') ?>;" aria-valuemin="0" aria-valuemax="100">
															<span class="sr-only">
																<?php echo esc_html($donation_percentage); ?><?php _e('% % Complete', 'heal') ?> 
															</span>
														</div>
													</div><!-- /.progress -->
												</figcaption>
											</figure>	
											<h3 class="causes-post-title"><?php the_title(); ?></h3><!-- /.causes-post-title -->
											<p class="post-text"><?php echo (get_the_excerpt()); ?></p><!-- /.post-text -->
											<a class="btn donate-btn" href="<?php the_permalink(); ?>">
												<?php _e('Donate Now', 'heal') ?>
											</a>
										</div><!-- /.causes-post -->
									</div><!-- /.item col-md-12 -->
								<?php endwhile;endif; 
									//reset query
								wp_reset_query();
								?>
							</div><!-- /.causes-post-slider -->
						</div><!-- /row -->
					</div><!-- /.col-md-8 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.causes-section -->
	</section><!-- /#causes -->
	<!--Causes Section End-->
