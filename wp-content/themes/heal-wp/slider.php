<?php 
global $heal_option;

?>	

<!-- Top Slider -->
<?php if($heal_option['slider_parallax_control']){ ?>
<section id="top-section" <?php if(isset($heal_option['mob_slider_of_off']) ) { ?>class="hidden-xs" <?php } ?>>
	<?php echo do_shortcode(esc_attr($heal_option['slider_revolution']));  ?>
</section>
<?php } else { ?>

<section id="top-section" class="hidden-xs" data-type="background" data-speed="30">
	
	<div class="top-section parallax-style">
		<div class="parallax-overlay">
			<div class="slider-txt-container">
				<div id="top-carousel" class="carousel slide" data-ride="carousel">

					<ol class="carousel-indicators">
						<?php 
						if(isset($heal_option['heal-slides'][1]['title'])) {
							for($i = 0; $i< count($heal_option['heal-slides']); $i++){ ?>
							<li data-target="#top-carousel" data-slide-to="<?php echo esc_attr($i); ?>" class="<?php echo esc_attr(!$i ?'active':'');?>"></li>
							<?php }
						}else{ ?>
						<li data-target="#top-carousel" data-slide-to="0" class="active"></li>
						<li data-target="#top-carousel" data-slide-to="1" class=""></li>
						<li data-target="#top-carousel" data-slide-to="2" class=""></li>
						<?php } ?>
					</ol><!-- /.carousel-indicators -->
					<div class="carousel-inner">
						<?php 
						if(isset($heal_option['heal-slides'][1]['title'])) {
							$i = 0;
							$sliders = $heal_option['heal-slides'];
							foreach ($sliders as $slider) {

								?>
								<div class="item <?php echo !$i ? 'active' : ''; ?>">
									<div class="thin-txt">
										<?php echo wp_kses_stripslashes( $slider['description'] ); ?>
									</div>
									<p class="link">
										<a href="<?php echo esc_url($slider['url']); ?>" class="btn custom-btn angle-effect"><?php echo esc_attr(($slider['title']) ? $slider['title'] : 'LEARN MORE') ; ?></a>
									</p> 				
								</div><!-- /.item -->
								<?php 
								$i = 1;	
							}

						}
						?>
					</div><!-- /.item -->
				</div><!-- /.carousel-inner -->
				<a class="slide-nav left" href="#top-carousel" data-slide="prev"><span></span></a>
				<a class="slide-nav right" href="#top-carousel" data-slide="next"><span></span></a>
			</div><!-- /#top-carousel -->
		</div><!-- /.slider-txt-container -->
	</div><!-- /.parallax-overlay -->
</section><!-- /#top-section -->
<!-- Top Slider End-->
<?php } ?>