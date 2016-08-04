<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>
	<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="hex content-icon-hex"><div class="content-icon"><i class="fa fa-rocket"></i></div></div>', $post, $product ); ?>

<?php endif; ?>
