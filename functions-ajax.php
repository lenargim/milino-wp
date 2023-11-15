<?php

add_action('wp_ajax_new_filter', 'add_material_filter');
add_action('wp_ajax_nopriv_new_filter', 'add_material_filter');


function add_material_filter()
{
	$next_step = $_POST['next_step'];
	$parent_id = $_POST['parent_id'];
	$category = $_POST['category'];
	$attributesArr = $_POST['attributes'];

	if ($next_step['type'] === 'category') {
		$categoriesArgs = [
			'taxonomy' => 'product_cat',
			'parent' => $parent_id,
			'hide_empty' => false,
			'orderby' => 'id'
		];
		$params = [
			'args' => $categoriesArgs,
			'slug' => $next_step['slug'],
			'name' => $next_step['name'],
		];
	} else {
		$params = [
			'category' => $category,
			'attributes_arr' => $attributesArr,
			'slug' => $next_step['slug'],
			'no_filter' => $next_step['noFilter'],
		];
	}


	get_template_part('woocommerce/parts/shop/' . $next_step['type'], null, $params);

	wp_die();
}


add_action('wp_ajax_update_sidebar', 'get_sidebar_data');
add_action('wp_ajax_nopriv_update_sidebar', 'get_sidebar_data');

function get_sidebar_data()
{
	$attributes = $_POST['attributes'];
	$arr = array();
	foreach ($attributes as $attribute_key => $attribute_value):
		$pa = 'pa_' . $attribute_key;
		$taxonomy = get_taxonomy($pa);
		$term = get_term_by('slug', $attribute_value, $pa);
	$arr[] = [$taxonomy->labels->singular_name => $term->name];
	endforeach;
	wp_send_json($arr);
	wp_die();
}

add_action( 'wp_ajax_delete_item', 'delete_cart_item' );
add_action( 'wp_ajax_nopriv_delete_item', 'delete_cart_item' );


function delete_cart_item() {
	$key = sanitize_text_field( $_POST['key'] );
	if ( $key ) {
		$cart = WC()->cart;
		$cart->remove_cart_item( $key );
//		$data['count']    = WC()->cart->cart_contents_count;
		echo wc_get_template( 'cart/mini-cart.php' );
		wp_die();
	}
}