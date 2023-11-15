<?php

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts', 9999);
add_action('wp_head', 'my_theme_enqueue_scripts', 9999);
function my_theme_enqueue_scripts()
{
	wp_enqueue_style('main-styles', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
	wp_enqueue_script('main-scripts', get_template_directory_uri() . '/main.min.js', array('jquery'));


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
	return $mime_types;
}

add_filter('upload_mimes', 'allow_modern_images');


function handle_custom_query_var($query, $query_vars)
{

	if (!empty($query_vars['attributes'])) {
		foreach ($query_vars['attributes'] as $key => $value):
			$query['tax_query'][] = [
				'taxonomy' => 'pa_' . $key,
				'field' => 'slug',
				'terms' => esc_attr($value),
			];
		endforeach;
	}

	return $query;
}

add_filter('woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2);


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

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'woocommerce_cart_needs_payment', '__return_false' );

//remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );


add_filter('wc_add_to_cart_message', 'custom_add_to_cart_message', 10, 2);
function custom_add_to_cart_message($message, $product_id) {

	if ($message) {
		$product = wc_get_product( $product_id );
		$html = '<div class="add-to-cart-message">Thank you for adding product ' . $product->get_title() . '</div>';
		return $html;
	}
}
