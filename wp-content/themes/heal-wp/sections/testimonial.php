<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;

/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/
	
//$testimonial_menu = $heal_option['heal_testimonial_menu']; 
//$testimonial_id = strtolower(str_replace(' ', '_', $testimonial_menu));
?>

<?php if($heal_option['heal_testimonial_on_off']) { ?>
<!--Testimonial Section-->
<section id="testimonial">
	<div class="testimonial-section parallax-style">
		<?php if(!$heal_option['heal_testimonial_agular']) { ?>
		<div class="angular parallax-overlay section-padding">
			<div class="top-angle"></div>
			<div class="container pb">
			<?php } else { ?>
			<div class="parallax-overlay section-padding">
			<div class="container">
				<?php } ?>
			
				<div class="row">
					<div class="col-md-12">
						<div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?php 
								if(isset($heal_option['heal_testimonial_slides'][1]['title'])) {
									for ($i=0; $i < count($heal_option['heal_testimonial_slides']) ; $i++) { ?>
									<li data-target="#testimonial-carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0)?'active':'';?>"></li>	
									<?php 
								} 
							}
							?>	
						</ol><!-- /.carousel-indicators -->
						<div class="carousel-inner">
							<?php if(isset($heal_option['heal_testimonial_slides'][1]['title'])) {
								$i = 0;
								$testimonials = $heal_option['heal_testimonial_slides'];
								foreach ($testimonials as $testimonial) {
									?>
									<div class="item <?php echo !$i? 'active' : ''; ?>">
										<div class="testimonial-figure">

											<h3 class="parallax-title author-name">
												<?php echo esc_html( $testimonial['title'] ); ?>
											</h3><!-- /.parallax-title -->
											<p class="authors-review">
												<?php echo esc_textarea( $testimonial['description'] ); ?>
											</p><!-- /.authors-review -->
											<div class="author-avatar">
												<img class="img-circle" src="<?php echo esc_url( $testimonial['image']); ?>" alt="carousel image">
											</div><!-- /.author-avatar -->
										</div><!-- /.testimonial-figure -->
									</div><!-- /.item -->
									<?php 
									$i = 1;
								} 
							} 
							?>

						</div><!-- /.carousel-inner -->
					</div><!-- /#testimonial-carousel -->
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.parallax-overlay -->
</div><!-- /.testimonial-section -->
</section><!-- /#testimonial -->
<!--Testimonial Section End-->

<?php } ?>

