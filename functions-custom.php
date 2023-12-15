<?php

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts', 9999);
add_action('wp_head', 'my_theme_enqueue_scripts', 9999);
function my_theme_enqueue_scripts()
{
	wp_enqueue_style('main-styles', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
	wp_enqueue_script('main-scripts', get_template_directory_uri() . '/main.min.js', array('jquery'));
	$translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
	wp_localize_script( 'main-scripts', 'object_name', $translation_array );
	wp_enqueue_script('cookies', 'https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js', array('jquery'));


// AJAX
	wp_register_script('ajax_scripts', get_stylesheet_directory_uri() . '/assets/js/ajax.js', array('jquery'));
	wp_localize_script('ajax_scripts', 'ajaxVar', array('ajaxurl' => admin_url('admin-ajax.php')));
	wp_enqueue_script('ajax_scripts');

}

add_action('wp_default_scripts', function ($scripts) {
	if (!empty($scripts->registered['jquery'])) {
		$scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
	}
});


add_filter('woocommerce_enqueue_styles', '__return_false');


function mytheme_add_woocommerce_support()
{
	add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


function allow_modern_images($mime_types)
{
	$mime_types['heic'] = 'image/heic';
	$mime_types['heif'] = 'image/heif';
	$mime_types['heics'] = 'image/heic-sequence';
	$mime_types['heifs'] = 'image/heif-sequence';
	$mime_types['avif'] = 'image/avif';
	$mime_types['avifs'] = 'image/avif-sequence';
	$mime_types['jpeg'] = 'image/jpeg';

	return $mime_types;
}

add_filter('upload_mimes', 'allow_modern_images');




//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter('woocommerce_product_tabs', 'my_remove_all_product_tabs', 98);
function my_remove_all_product_tabs($tabs)
{
	unset($tabs['description']);        // Remove the description tab
	unset($tabs['reviews']);       // Remove the reviews tab
	unset($tabs['additional_information']);    // Remove the additional information tab
	return $tabs;
}


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


add_filter('woocommerce_checkout_fields', 'checkout_fields_edit', 9999);

function checkout_fields_edit($fields)
{
	// and to remove the billing fields below
	unset($fields['billing']['billing_first_name']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_address_2']);


	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_postcode']);
//	unset($fields['billing']['billing_email']);
	unset($fields['billing']['billing_country']);

	$fields['billing']['billing_phone']['required'] = false;
	$fields['billing']['billing_company']['required'] = true;
	$fields['billing']['billing_email']['priority'] = 90;


	return $fields;
}

add_filter('woocommerce_enable_order_notes_field', '__return_false');

add_filter('woocommerce_cart_needs_payment', '__return_false');

//remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);


add_filter('wc_add_to_cart_message', 'custom_add_to_cart_message', 10, 2);
function custom_add_to_cart_message($message, $product_id)
{

	if ($message) {
		$product = wc_get_product($product_id);
		$html = '<div class="add-to-cart-message">Thank you for adding product ' . $product->get_title() . '</div>';
		return $html;
	}
}


add_action('init', 'custom_taxonomy_Item');
function custom_taxonomy_Item()
{
	$labelsDoor = array(
		'name' => 'Door',
		'singular_name' => 'Door',
		'menu_name' => 'Door',
		'all_items' => 'All Doors',
		'parent_item' => 'Parent Door',
		'parent_item_colon' => 'Parent Door:',
		'new_item_name' => 'New Door',
		'add_new_item' => 'Add New Door',
		'edit_item' => 'Edit Door',
		'update_item' => 'Update Door',
		'separate_items_with_commas' => 'Separate Door with commas',
		'search_items' => 'Search Door',
		'add_or_remove_items' => 'Add or remove Door',
		'choose_from_most_used' => 'Choose from the most used Door',
	);
	$argsDoor = array(
		'labels' => $labelsDoor,
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'query_var' => true,
	);


	$labelsBM = array(
		'name' => 'Box Materials',
		'singular_name' => 'Box Material',
		'menu_name' => 'Box Material',
		'all_items' => 'All Box Materials',
		'parent_item' => 'Parent Box Material',
		'parent_item_colon' => 'Parent Box Material:',
		'new_item_name' => 'New Box Material',
		'add_new_item' => 'Add New Box Material',
		'edit_item' => 'Edit Box Material',
		'update_item' => 'Update Box Material',
		'separate_items_with_commas' => 'Separate Box Material with commas',
		'search_items' => 'Search Box Material',
		'add_or_remove_items' => 'Add or remove Box Material',
		'choose_from_most_used' => 'Choose from the most used Box Material',
	);
	$argsBM = array(
		'labels' => $labelsBM,
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'query_var' => true,
	);


	$labelsDrawer = array(
		'name' => 'Drawer',
		'singular_name' => 'Drawer',
		'menu_name' => 'Drawer',
		'all_items' => 'All Drawers',
		'parent_item' => 'Parent Drawer',
		'parent_item_colon' => 'Parent Drawer:',
		'new_item_name' => 'New Drawer',
		'add_new_item' => 'Add New Drawer',
		'edit_item' => 'Edit Drawer',
		'update_item' => 'Update Drawer',
		'separate_items_with_commas' => 'Separate Drawer with commas',
		'search_items' => 'Search Drawer',
		'add_or_remove_items' => 'Add or remove Drawer',
		'choose_from_most_used' => 'Choose from the most used Drawer',
	);
	$argsDrawer = array(
		'labels' => $labelsDrawer,
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'query_var' => true,
	);

	register_taxonomy('door', 'product', $argsDoor);
	register_taxonomy_for_object_type('door', 'product');

	register_taxonomy('box_material', 'product', $argsBM);
	register_taxonomy_for_object_type('box_material', 'product');

	register_taxonomy('drawer', 'product', $argsDrawer);
	register_taxonomy_for_object_type('drawer', 'product');
}
