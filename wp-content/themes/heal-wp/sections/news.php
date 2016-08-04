<?php 
/*-----------------------------------------------------------
 	global variable of theme option to grab theme data
 	-----------------------------------------------------------*/ 
 	global $heal_option;

/*-----------------------------------------------------------
	menu settings.
	-----------------------------------------------------------*/

	$news_menu = $heal_option['heal_news_menu']; 
	$news_id = strtolower(str_replace(' ', '_', $news_menu));

	?>
	<!--News Section-->
	<section id="<?php echo esc_attr( $news_id ); ?>">
		<?php if(!$heal_option['heal_news_agular']) { ?>
		<div class="news-section white-bg angular section-padding">
			<div class="top-angle">
			</div><!-- /.top-angle -->
			<div class="container pb">
			<?php } else { ?>
			<div class="news-section white-bg section-padding">
			<div class="containernews">
				<?php } ?>
				
					<div class="section-head clearfix clearfix titulonoticias">
						<h2 class="section-title">
							<?php echo esc_html( $heal_option['heal_news_title'] ); ?>
						</h2><!-- /.section-title -->
						<div class="section-description">
							<?php echo wp_kses_post( $heal_option['heal_news_des'] ); ?>
						</div>
					</div><!-- /.section-head clearfix -->

					<div class="row">
						<div class="news-container">

						<?php
						/*-----------------------------------------------------------
							query post.
							-----------------------------------------------------------*/
							query_posts('post_type=post&posts_per_page='. $heal_option['heal_show_number'] );

							if(have_posts()) : while(have_posts()) : the_post(); ?> 
							<div class="news-item col-md-6 from-bottom delay-200">
								<?php if ( has_post_thumbnail() ) { 
									the_post_thumbnail( 'home-thumb' ); 
									} else {
										echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
									}
								?>
								<article class="news-article">
									<div class="article-container">
										<div class="post-meta cuadradorojo dos">
											<div class="meta-icon">
												<span>
													<?php heal_post_format_icon(); ?>
												</span>
											</div>

											<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('j M, y'); ?></time>
											<span class="name">
												<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo ucfirst(get_the_author()); ?></a>
											</span>
											<span>
												<a href="<?php comments_link(); ?>"><?php comments_number( '', '1 Comment', '% Comments' ); ?></a>
											</span>
										</div><!-- /.post-meta -->
										<div class="cuadradonoticias">
											<h3 class="content-titlenoticias noticiasdescripciontitulo"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											
											<div>
												<a href="<?php the_permalink(); ?>" class="btn custom-btn angle-effect"><?php _e('Read More', 'heal') ?></a>
											</div>
										</div><!-- /.post-details -->
									</div><!-- /.article-container -->
								</article><!-- /.news-article -->
							</div><!-- /.news-item -->

						<?php endwhile;endif; 

						//reset query
						wp_reset_query();
						?>

					<div class="view-all">
						<a href="www.grulla360.com.ar/categoria/publicaciones/"><?php echo ($heal_option['heal_news_button_text']) ? $heal_option['heal_news_button_text'] : _e('View All News', 'heal') ?></a>
					</div>
				</div><!-- /.news-container -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.news-section -->
</section><!-- /#news -->
<!--News Section End-->

