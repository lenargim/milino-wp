<?php
/**
	* Mini-cart
	*
	* Contains the markup for the mini-cart, used by the cart widget.
	*
	* This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
	*
	* HOWEVER, on occasion WooCommerce will need to update template files and you
	* (the theme developer) will need to copy the new files to your theme to
	* maintain compatibility. We try to do this as little as possible, but it does
	* happen. When this occurs the version of the template file will be bumped and
	* the readme will list any important changes.
	*
	* @see     https://docs.woocommerce.com/document/template-structure/
	* @package WooCommerce\Templates
	* @version 7.9.0
	*/

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<?php $cart = WC()->cart; ?>

<?php if (!$cart->is_empty()) :
	$cart_items = $cart->get_cart();
	?>
  <div class="woocommerce-mini-cart__content">
    <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
					<?php
					do_action('woocommerce_before_mini_cart_contents');

					foreach ($cart_items as $cart_item_key => $cart_item) {
						$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
							$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
							$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
							$product_price = apply_filters('woocommerce_cart_item_price', $cart->get_product_price($_product), $cart_item, $cart_item_key);
							$regular_price = $_product->get_regular_price();
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
							?>
        <li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
          <div class="top">
            <div class="remove" data-key="<?php echo $cart_item_key; ?>">&times;</div>
            <div class="img"><?php echo $thumbnail; ?></div>
            <div class="name"><?php echo wp_kses_post($product_name); ?></div>
          </div>
          <div class="data">
											<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
											<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $regular_price ? $product_price : 'Price unknown') . '</span>', $cart_item, $cart_item_key); ?>
          </div>
        </li>
							<?php
						}
					}
					do_action('woocommerce_mini_cart_contents');
					?>
    </ul>
  </div>

	<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
  <div class="woocommerce-mini-cart__buttons buttons">
    <p class="woocommerce-mini-cart__total total">
					<?php
					if (is_custom_price($cart_items)):
						echo 'Total price unknown because of customisation';
					else:
						echo '<span>Total : </span>' . $cart->get_cart_subtotal();
					endif;
					?>
    </p>
    <a href="/cabinets" class="button">&#x2190; Back to Cabinets</a>
    <a href="/checkout" class="button">Checkout &#x2192;</a>
  </div>
	<?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>

<?php else : ?>
  <div class="woocommerce-mini-cart__content">
    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e('No products in the cart.', 'woocommerce'); ?></p>
  </div>
  <a href="/cabinets" class="button sidebar__back">&#x2190; Back to Cabinets</a>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>
