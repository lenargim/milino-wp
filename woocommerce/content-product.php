<?php
/**
	* The template for displaying product content within loops
	*
	* This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
	*
	* HOWEVER, on occasion WooCommerce will need to update template files and you
	* (the theme developer) will need to copy the new files to your theme to
	* maintain compatibility. We try to do this as little as possible, but it does
	* happen. When this occurs the version of the template file will be bumped and
	* the readme will list any important changes.
	*
	* @see     https://docs.woocommerce.com/document/template-structure/
	* @package WooCommerce\Templates
	* @version 3.6.0
	*/

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
?>
<li <?php wc_product_class('', $product); ?>>

  <a href="<?php echo get_permalink($product->get_id()); ?>">
			<?php echo $product->get_image(); ?>
  </a>
  <div class="product__name"><?php echo $product->get_name(); ?></div>

  <div class="product__info">
    <div class="product__taxonomy">
      <span>Category:</span>
					<?php echo wc_get_product_category_list($product->ID); ?>
    </div>
			<?php $term_names = wp_get_post_terms($product->get_id(), 'door', ['fields' => 'names', 'orderby' => 'id']);
			if (count($term_names)): ?>
     <div class="product__taxonomy">
       <span>Door:</span>
						<?php $term_names = wp_get_post_terms($product->get_id(), 'door', ['fields' => 'names', 'orderby' => 'id']); ?>
       <span><?php echo implode(', ', $term_names); ?></span>
     </div>
			<?php endif; ?>
			<?php $term_names = wp_get_post_terms($product->get_id(), 'box_material', ['fields' => 'names', 'orderby' => 'id']); ?>
    <span><?php if (count($term_names)): ?></span>
    <div class="product__taxonomy">
      <span>Box Material:</span>
      <span><?php echo implode(', ', $term_names); ?></span>
    </div>
		<?php endif; ?>
			<?php $term_names = wp_get_post_terms($product->get_id(), 'drawer', ['fields' => 'names', 'orderby' => 'id']); ?>
    <span><?php if (count($term_names)): ?></span>
    <div class="product__taxonomy">
      <span>Drawer:</span>
					<?php $term_names = wp_get_post_terms($product->get_id(), 'drawer', ['fields' => 'names', 'orderby' => 'id']); ?>
      <span><?php echo implode(', ', $term_names); ?></span>
    </div>
		<?php endif; ?>

<!--    <span>Price:</span>-->
<!--			--><?php
//			$min_price = $product->get_variation_price('min');
//			$max_price = $product->get_variation_price('max');
//			if ($min_price !== $max_price): ?>
<!--     <span>--><?php //echo $min_price ?><!--$</span>--->
<!--     <span>--><?php //echo $max_price ?><!--$</span>-->
<!--			--><?php //else: ?>
<!--     <span>--><?php //echo $min_price ?><!--$</span>-->
<!--			--><?php //endif; ?>


  </div>


	<?php
	echo wc_get_template_part('add-to-cart');

	/**
		* Hook: woocommerce_before_shop_loop_item.
		*
		* @hooked woocommerce_template_loop_product_link_open - 10
		*/
	//	do_action( 'woocommerce_before_shop_loop_item' );

	/**
		* Hook: woocommerce_before_shop_loop_item_title.
		*
		* @hooked woocommerce_show_product_loop_sale_flash - 10
		* @hooked woocommerce_template_loop_product_thumbnail - 10
		*/
	//	do_action( 'woocommerce_before_shop_loop_item_title' );


	/**
		* Hook: woocommerce_shop_loop_item_title.
		*
		* @hooked woocommerce_template_loop_product_title - 10
		*/
	//	do_action( 'woocommerce_shop_loop_item_title' );


	/**
		* Hook: woocommerce_after_shop_loop_item_title.
		*
		* @hooked woocommerce_template_loop_rating - 5
		* @hooked woocommerce_template_loop_price - 10
		*/
	//	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
		* Hook: woocommerce_after_shop_loop_item.
		*
		* @hooked woocommerce_template_loop_product_link_close - 5
		* @hooked woocommerce_template_loop_add_to_cart - 10
		*/
	do_action('woocommerce_after_shop_loop_item');
	?>
</li>
