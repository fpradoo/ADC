<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<!-- Related Products Carousel -->
	<section id="related-products-carousel" class="related-products-carousel section-padding">
		<div class="container">

			<div class="title-container text-center">
				<h2 class="striped-title">
					<?php _e('Related<span> product</span>', 'focuz') ?>
					<span class="stripe-t-left"></span>
					<span class="stripe-t-back"></span>
					<span class="stripe-t-right"></span>
				</h2>
				
			</div>
			<div class="owl-container">

				<div class="carousel-navigator text-center">
					<button class="btn nav-btn sm-btn rbtn prev"><i class="fa fa-long-arrow-left"></i></button>
					<button class="btn nav-btn sm-btn rbtn next"><i class="fa fa-long-arrow-right"></i></button>
				</div>
				<div id="related-products-slide" class="owl-carousel pt50" data-pagination="false" data-screenitems="[[0, 1], [600, 2], [1000, 3], [1200, 4]]" data-items="4" data-autoplay="3000">
					
					<?php while ( $products->have_posts() ) : $products->the_post();  ?>
					<div class="item">
						<div class="product-item clearfix">
							<div class="product-image">
								<a href="#" class="thumb">
									<?php the_post_thumbnail('shop_single'); ?>
								</a>
								<?php 
								global $product;
								$attachment_ids = $product->get_gallery_attachment_ids();

								foreach( $attachment_ids as $attachment_id ) 
								{
									 $image_link = wp_get_attachment_url( $attachment_id );
								}
								?>
								<a href="<?php echo esc_url($image_link   ); ?>" class="quick-view boxer" title="<?php the_title(); ?>"><span>Quick View</span></a>
								
							</div><!--  /.product-image -->

							<div class="product-description">
								<div class="stripe-full product-head">
									<h2 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h2>
									<div class="product-rating">
										<?php woocommerce_get_template( 'single-product/rating.php' ); ?>
									</div>
									<div class="product-price"><?php woocommerce_get_template( 'single-product/price.php' ); ?></div>
								</div>
								<div class="product-excerpt">
								<?php the_excerpt(); ?>
									</div>
								<div class="product-action">
									<?php echo cc_love(); ?>
									<?php woocommerce_get_template( 'loop/add-to-cart.php' ); ?>
								</div>
							</div><!--  /.product-description -->
						</div>
					</div>
					<?php endwhile; // end of the loop. ?>


				</div>

			</div>
		</div><!--  /.container -->
	</section><!-- /#related-products-carousel  -->
	<!-- End Related Products Carousel -->


<?php endif;

wp_reset_postdata();
