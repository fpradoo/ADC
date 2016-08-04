<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<!-- Shop Section  -->
<section id="shop" class="blog-page-container">
	<div class="container">
		<div class="row">
		
		

				<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
				?>
			
			<div class="col-md-9 md-bm50">
				<div id="primary-area">
					<div class="clearfix">
						<div class="col-sm-5 p0"> <!-- this class is end in result-count.php -->
							<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

								<h2 class="page-title title m0"><?php woocommerce_page_title(); ?></h2>

							<?php endif; ?>
							<?php //woocommerce_get_template( 'loop/result-count.php' ); ?>
							<?php //do_action( 'woocommerce_archive_description' ); ?>
						</div>
						<div class="col-sm-7 p0">
						<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
						?>
						</div>	

					</div>


					<?php if ( have_posts() ) : ?>

						<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

					<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

						<?php wc_get_template( 'loop/no-products-found.php' ); ?>

					<?php endif; ?>

						<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
						?>

					</div>
			</div><!-- col-md-9 md-bm50 -->
			<div class="col-md-3 blog-sidebar">
				<?php
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				// do_action( 'woocommerce_sidebar' );
				dynamic_sidebar('sidebar-1');
				?>
			</div>
			<!-- sidebar -->

		</div><!-- /.row -->
	</div><!-- /.container -->
</section><!-- /#product-archive  -->
<!-- Shop Section End -->
<?php get_footer( 'shop' ); ?>
