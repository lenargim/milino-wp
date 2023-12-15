<?php
/**
	* The template for displaying product content in the single-product.php template
	*
	* This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
	* Hook: woocommerce_before_single_product.
	*
	* @hooked woocommerce_output_all_notices - 10
	*/
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
  <div class="product__wrap">

    <div class="product__left">
					<?php
					wc_get_template('single-product/title.php');
					$image_id = $product->get_image_id();
					$image_url = wp_get_attachment_image_url($image_id, 'full');
					?>

      <div class="img">
							<?php
							if ($image_url): ?>
         <img src="<?php echo $image_url; ?>" alt="<?php echo $product->get_name(); ?>">
							<?php endif; ?>
      </div>

      <div class="product__tags"><?php
							$tags = $product->tag_ids;
							foreach ($tags as $tag):?>
         <span><?php echo get_term($tag)->name; ?></span>
							<?php endforeach; ?>
      </div>
      <div class="product__attributes">
							<?php if (isset($_COOKIE["product_cat"])):
								$category = json_decode(stripslashes($_COOKIE["product_cat"])); ?>
         <div class="sidebar__attribute">
           <div>Room:</div>
           <div><?php echo $category; ?></div>
         </div>
							<?php endif; ?>

							<?php if (isset($_COOKIE["door"])):
								$doorArr = json_decode(stripslashes($_COOKIE["door"]));
								foreach ($doorArr as $index => $cat):
									if ($index === 0) {
										$label = 'Door type';
									} else if ($index === 1) {
										$label = 'Door Finish material';
									} else if ($index === 2) {
										$label = 'Door finish color';
									}
									?>

          <div class="sidebar__attribute">
            <div><?php echo $label ?>:</div>
            <div><?php echo $cat; ?></div>
          </div>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if (isset($_COOKIE["box_material"])):
								$box = json_decode(stripslashes($_COOKIE["box_material"]));

								?>

         <div class="sidebar__attribute">
           <div>Box Material:</div>
           <div><?php echo $box; ?></div>
         </div>
							<?php endif; ?>

							<?php if (isset($_COOKIE["drawer"])):
								$drawerArr = json_decode(stripslashes($_COOKIE["drawer"]));
								foreach ($drawerArr as $index => $cat):
									if ($index === 0) {
										$label = 'Drawer Brand';
									} else if ($index === 1) {
										$label = 'Drawer Type';
									} else if ($index === 2) {
										$label = 'Drawer color';
									}
									?>

          <div class="sidebar__attribute">
            <div><?php echo $label ?>:</div>
            <div><?php echo $cat; ?></div>
          </div>
								<?php endforeach; ?>
							<?php endif; ?>
      </div>
    </div>

    <div class="product__right">
					<?php
					/**
						* Hook: woocommerce_single_product_summary.
						*
						* @hooked woocommerce_template_single_title - 5
						* @hooked woocommerce_template_single_rating - 10
						* @hooked woocommerce_template_single_price - 10
						* @hooked woocommerce_template_single_excerpt - 20
						* @hooked woocommerce_template_single_add_to_cart - 30
						* @hooked woocommerce_template_single_meta - 40
						* @hooked woocommerce_template_single_sharing - 50
						* @hooked WC_Structured_Data::generate_product_data() - 60
						*/
					do_action('woocommerce_single_product_summary');
					?>
    </div>


  </div>

  <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
