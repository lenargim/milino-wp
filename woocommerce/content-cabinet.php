<?php
global $product;

if (empty($product) || !$product->is_visible()) {
	return;
}
$url = rtrim($product->get_permalink(), '/');
?>
<a href="<?php echo $url; ?>" class="product__item">
	<?php if ($product->get_image_id()):
		$img_url = wp_get_attachment_url($product->get_image_id());
	else:
		$img_url = IMAGES_PATH . 'no-img.jpeg';
	endif;
	?>

  <div class="product__img img"><img src="<?php echo $img_url; ?>"
                                     alt="<?php echo $product->get_name() ?>"></div>
  <div class="product__data">
  <div class="product__name"><?php echo $product->get_name() ?></div>
  <div class="product__desc"><?php echo $product->get_short_description(); ?></div>
  </div>

  <div class="product__price">
			<?php
			$min_price = $product->get_variation_price('min');
			$max_price = $product->get_variation_price('max');
			if ($min_price !== $max_price): ?>
     <span><?php echo $min_price ?>$</span>-
     <span><?php echo $max_price ?>$</span>
			<?php else: ?>
     <span><?php echo $min_price ?>$</span>
			<?php endif; ?>
  </div>
</a>