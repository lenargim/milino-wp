<?php
/**
	* Review order table
	*
	* This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
	*
	* HOWEVER, on occasion WooCommerce will need to update template files and you
	* (the theme developer) will need to copy the new files to your theme to
	* maintain compatibility. We try to do this as little as possible, but it does
	* happen. When this occurs the version of the template file will be bumped and
	* the readme will list any important changes.
	*
	* @see https://docs.woocommerce.com/document/template-structure/
	* @package WooCommerce\Templates
	* @version 5.2.0
	*/

defined('ABSPATH') || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table table">

	<?php
	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
		$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
		if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) : ?>
    <div class="product-item">
    <span class="product-name">
				<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?>
        </span>
			<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <span class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>


			<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
      </div>
		<?php endif;
	endforeach;
	?>

	<?php do_action('woocommerce_review_order_before_order_total'); ?>
 <div class="total">
   <span><?php esc_html_e('Total', 'woocommerce'); ?>:</span>
   <span><?php wc_cart_totals_order_total_html(); ?></span>
 </div>

	<?php do_action('woocommerce_review_order_after_order_total'); ?>

</div>
