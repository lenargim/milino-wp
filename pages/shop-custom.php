<?php
//Template Name: Shop Custom

defined('ABSPATH') || exit;


if (!isset($_COOKIE["attributes"])) {
	wp_redirect('/order-form/');
	exit;
}


get_template_part('parts/header/head');
?>
  <div class="shop-custom">
    <main>
      <div class="container">
							<?php get_template_part('parts/header/header-menu'); ?>
      </div>
      <form id="shop-custom-form">
        <div class="container">
          <form>
            <h1>Shop</h1>
											<?php
											$args = [
												'status' => 'publish',
												'limit' => -1,
												'type' => 'variable',
												'order' => 'ASC',
												'orderby' => 'ID',
												'category' => array('slab-door'),
											];
											$products = wc_get_products($args);
											$attrArr = json_decode(stripslashes($_COOKIE["attributes"]));
											$meta_query = [];
											foreach ($attrArr as $key => $value):

												$meta_query[] = [
													'key' => 'attribute_pa_' . $key,
													'value' => $value,
												];

											endforeach;
											?>
            <div class="product__list"><?php
													foreach ($products as $product):
														$query = new \WP_Query(array(
															'post_parent' => $product->get_ID(),
															'post_status' => 'publish',
															'post_type' => 'product_variation',
															'posts_per_page' => -1,
															'meta_query' => $meta_query
														));

														$result = array();
														if ($query->have_posts()) {
															while ($query->have_posts()) {
																$query->next_post();
																$result[] = $query->post;
															}
//															wp_reset_postdata();
														}

														$min_price = INF;
														$max_price = 0;
														if (count($result)):
															foreach ($result as $variable):
																$var_ID = $variable->ID;
																$v_product = new WC_Product_Variation($var_ID);
																$price = $v_product->get_price();
																$min_price = $price < $min_price ? $price : $min_price;
																$max_price = $price > $max_price ? $price : $max_price;
															endforeach;
														endif;

														$query_attr_params = '?';
														foreach ($attrArr as $key => $value):
															$query_attr_params .= 'attribute_pa_' . $key . '=' . $value . '&';
														endforeach;
														$url = rtrim($product->get_permalink(), '/')
//                             . $query_attr_params;
//																											wp_reset_query();
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
                 <div class="product__name"><?php echo $product->get_name() ?></div>
                 <div class="product__price">
                   <?php if ($min_price !== $max_price): ?>
                            <span><?php echo $min_price?>$</span>-
                            <span><?php echo $max_price?>$</span>
                    <?php else: ?>
                     <span><?php echo $min_price?>$</span>
                   <?php endif; ?>

                 </div>
               </a>
													<?php endforeach; ?>
            </div>
          </form>
        </div>
      </form>
    </main>
			<?php get_template_part('parts/sidebar/sidebar'); ?>
  </div>

<?php get_template_part('parts/footer/footer'); ?>