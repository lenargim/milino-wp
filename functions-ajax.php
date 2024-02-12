<?php

add_action('wp_ajax_new_filter', 'add_material_filter');
add_action('wp_ajax_nopriv_new_filter', 'add_material_filter');


function add_material_filter()
{
	$next_step = $_POST['next_step'];
	$params = [
		'slug' => $next_step['slug'],
		'name' => $next_step['name'],
		'type' => $next_step['type'],
		'is_main' => $next_step['isMain'],
		'parent_id' => $_POST['parent_id'],
	];


	get_template_part('woocommerce/parts/shop/category', null, $params);

	wp_die();
}

add_action('wp_ajax_delete_item', 'delete_cart_item');
add_action('wp_ajax_nopriv_delete_item', 'delete_cart_item');


function delete_cart_item()
{
	$key = sanitize_text_field($_POST['key']);
	if ($key) {
		$cart = WC()->cart;
		$cart->remove_cart_item($key);
//		$data['count']    = WC()->cart->cart_contents_count;
		echo wc_get_template('cart/mini-cart.php');
		wp_die();
	}
}


add_action('wp_ajax_check_products_exist_if_filter', 'get_prod_count');
add_action('wp_ajax_nopriv_check_products_exist_if_filter', 'get_prod_count');

function get_prod_count()
{
	$products = wc_get_products(get_material_filter_arguments());
	echo count($products);
	wp_die();
}


add_action('wp_ajax_filter_cabinets', 'filter_cabinets_request');
add_action('wp_ajax_nopriv_filter_cabinets', 'filter_cabinets_request');


function filter_cabinets_request()
{
	$subcategory = sanitize_text_field($_POST['subcategory']);
	if ($subcategory):
		$args = get_material_filter_arguments();
		$args['category'] = $subcategory;
		$products = wc_get_products($args);
		if (count($products)):
			foreach ($products as $product):
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
       <div class="product__tags"><?php
								$tags = $product->tag_ids;
								foreach ($tags as $tag):?>
          <span><?php echo get_term($tag)->name; ?></span>
								<?php endforeach; ?>
       </div>
     </div>
     </a><?php
			endforeach;
		endif;
		wp_die();
	endif;
}

function get_material_filter_arguments()
{
	$category = json_decode(stripslashes($_COOKIE["product_cat"]));
	$doorArr = json_decode(stripslashes($_COOKIE["door"]));
	$box = json_decode(stripslashes($_COOKIE["box_material"]));
	$drawerArr = json_decode(stripslashes($_COOKIE["drawer"]));
	$args = [
		'status' => 'publish',
		'limit' => -1,
//		'type' => 'variable',
		'order' => 'ASC',
		'orderby' => 'ID',
		'category' => $category,
	];
	$tax_query = [
		'relation' => 'AND',
	];

	foreach ($doorArr as $door):
		$tax_query[] = [
			'taxonomy' => 'door',
			'field' => 'name',
			'terms' => $door,
			'include_children' => false
		];
	endforeach;
	foreach ($drawerArr as $drawer):
		$tax_query[] = [
			'taxonomy' => 'drawer',
			'field' => 'name',
			'terms' => $drawer,
			'include_children' => false
		];
	endforeach;

	$tax_query[] = [
		'taxonomy' => 'box_material',
		'field' => 'name',
		'terms' => $box,
	];

	$args['tax_query'] = $tax_query;
	return $args;
}