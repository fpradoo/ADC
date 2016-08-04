 <?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;

 	?>
 	<!-- Clients Section -->
 	<section id="clients" data-type="background" data-speed="100">
 		<?php if(!$heal_option['heal_Client_agular']) { ?> 
 		<div class="clients-section parallax-style angular section-padding">
 			<div class="parallax-overlay dark-overlay">
 				<div class="top-angle">
 				</div><!-- /.top-angle -->
 				<div class="container">
 				<?php } else { ?>
 				<div class="clients-section parallax-style">
 				<div class="parallax-overlay dark-overlay">
 					<div class="container">
 						<?php } ?>
 						<div class="pb clearfix">
 							<h3 class="parallax-title">
 								<?php _e('¡VISITÁ TAMBIÉN!', 'heal') ?>
 							</h3>
 						</div><!-- /.section-head clearfix -->

 						<div class="row">
 							<div class="clients-logo">
 								<div class="col-sm-3">
 									<div class="client-logo">
 										<a href="<?php echo esc_url($heal_option['heal_client_one_url']); ?>">
 											<img src="<?php echo esc_url($heal_option['heal_client_one']['url']); ?>" alt="<?php echo esc_attr( $heal_option['heal_client_one_url'] ); ?>">
 										</a>
 									</div><!-- /.client-logo -->
 								</div><!-- /.col-sm-3 -->

 								<div class="col-sm-3">
 									<div class="client-logo">
 										<a href="<?php echo esc_attr($heal_option['heal_client_two_url']); ?>">
 											<img src="<?php echo esc_attr($heal_option['heal_client_two']['url']); ?>" alt="<?php echo esc_attr( $heal_option['heal_client_two_url'] ); ?>">
 										</a>
 									</div><!-- /.client-logo -->
 								</div><!-- /.col-sm-3 -->

 								<div class="col-sm-3">
 									<div class="client-logo">
 										<a href="<?php echo esc_url( $heal_option['heal_client_three_url'] ); ?>">
 											<img src="<?php echo esc_url( $heal_option['heal_client_three']['url'] ); ?>" alt="<?php echo esc_attr( $heal_option['heal_client_three_url'] ); ?>">
 										</a>
 									</div><!-- /.client-logo -->
 								</div><!-- /.col-sm-3 -->




 								<div class="col-sm-3">
 									<div class="client-logo">
 										<a href="<?php echo esc_url( $heal_option['heal_client_four_url']); ?>">
 											<img src="<?php echo esc_url( $heal_option['heal_client_four']['url']); ?>" alt="<?php echo esc_attr( $heal_option['heal_client_four_url'] ); ?>">
 										</a>
 									</div><!-- /.client-logo -->
 								</div><!-- /.col-sm-3 -->
 							</div><!-- /.clients-logo -->
 						</div><!-- /.low -->
 					</div><!-- /.container -->
 				</div><!-- /.parallax-overlay -->
 			</div><!-- /.clients-section -->
 		</section><!-- /#clients -->
 		<!-- Clients Section End -->





