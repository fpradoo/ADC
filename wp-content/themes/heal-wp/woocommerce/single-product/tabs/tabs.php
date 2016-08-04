<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
<section>
	<div class="container">
		<div class="clearfix"></div>
		<div class="product-description clearfix">
			<div role="tabpanel">
				<ul class="nav nav-tabs" role="tablist">
					<?php 
					$i = 0;
					foreach ( $tabs as $key => $tab ) : ?>

					<li role="presentation" class="<?php echo $key ?>_tab <?php echo (!$i) ? 'active' : ' ' ;  ?>">
						<a role="tab"  data-toggle="tab" href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
					</li>

					<?php 
					$i = 1;
					endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php
					$i = 0;
					foreach ( $tabs as $key => $tab ) : ?>

					<div role="tabpanel" class="panel entry-content tab-pane <?php echo (!$i) ? 'active' : ' ' ;  ?>" id="tab-<?php echo $key ?>">
						<?php call_user_func( $tab['callback'], $key, $tab ) ?>
					</div>

					<?php 
					$i = 1;
					endforeach; ?>
				</div>
			</div>
		</div>

	<?php endif; ?>
</div>

</section>