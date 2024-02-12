<?php
/**
	* Checkout Form
	*
	* This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
	*
	* HOWEVER, on occasion WooCommerce will need to update template files and you
	* (the theme developer) will need to copy the new files to your theme to
	* maintain compatibility. We try to do this as little as possible, but it does
	* happen. When this occurs the version of the template file will be bumped and
	* the readme will list any important changes.
	*
	* @see https://docs.woocommerce.com/document/template-structure/
	* @package WooCommerce\Templates
	* @version 3.5.0
	*/

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>

<div class="checkout">
  <div class="container">
    <form name="checkout" method="post" class="woocommerce-checkout checkout__wrap"
          action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
					<?php if ($checkout->get_checkout_fields()) : ?>
						<?php do_action('woocommerce_checkout_before_customer_details'); ?>
       <h1>Checkout</h1>
       <div id="customer_details">
         <div>
										<?php do_action('woocommerce_checkout_billing'); ?>
         </div>

         <div>
										<?php do_action('woocommerce_checkout_shipping'); ?>
         </div>
       </div>

						<?php do_action('woocommerce_checkout_after_customer_details'); ?>

					<?php endif; ?>

      <div class="checkout__buttons">
          <a href="<?php echo esc_url(wp_get_referer());?>" class="button">Back</a>
							<?php do_action('woocommerce_review_order_before_submit'); ?>
							<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button checkout__submit alt' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place order</button>'); ?>
							<?php do_action('woocommerce_review_order_after_submit'); ?>
							<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
      </div>

    </form>
  </div>
  <aside class="checkout__sidebar sidebar">
   <div class="sidebar__container">

			<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

    <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

			<?php do_action('woocommerce_checkout_before_order_review'); ?>

    <div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action('woocommerce_checkout_order_review'); ?>
    </div>

			<?php do_action('woocommerce_checkout_after_order_review'); ?>
   </div>
  </aside>
</div>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
