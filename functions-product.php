<?php

function cfwc_create_custom_field()
{
	$args = array(
		'id' => 'product_note',
		'label' => __('Note', 'cfwc'),
		'class' => 'cfwc-custom-field',
		'desc_tip' => true,
		'description' => __('Enter the note.', 'ctwc'),
	);
	woocommerce_wp_text_input($args);
}

add_action('woocommerce_product_options_advanced', 'cfwc_create_custom_field');


//function cfwc_save_custom_field($post_id)
//{
//	$product = wc_get_product($post_id);
//	$title = isset($_POST['product_note']) ? $_POST['product_note'] : '';
//	$product->update_meta_data('product_note', sanitize_text_field($title));
//	$product->save();
//}
//
//add_action('woocommerce_process_product_meta', 'cfwc_save_custom_field');

function cfwc_display_custom_field()
{
	global $post;
	// Check for the custom field value
	$product = wc_get_product($post->ID);
	$title = $product->get_meta('product_note');
//	if( $title ) {
	// Only display our field if we've got a value for the field title
	printf(
		'<div class="product__note"><label for="product-note-field">Note:</label><input type="text" class="input-text" id="product-note-field" placeholder="You can add some notes here..." name="product-note-field" value="%s"></div>',
		esc_html($title)
	);
//	}
}

add_action('woocommerce_before_single_variation', 'cfwc_display_custom_field');


function cfwc_add_custom_field_item_data($cart_item_data)
{
	if (!empty($_POST['product-note-field'])) {
		// Add the item data
		$cart_item_data['product_note_field'] = $_POST['product-note-field'];
	}
	return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'cfwc_add_custom_field_item_data', 10, 4);


//function cfwc_cart_item_name( $name, $cart_item, $cart_item_key ) {
//	if( isset( $cart_item['product_note_field'] ) ) {
//		$name .= sprintf(
//			'<p>%s</p>',
//			esc_html( $cart_item['product_note_field'] )
//		);
//	}
//	return $name;
//}
//add_filter( 'woocommerce_mini_cart_contents', 'cfwc_cart_item_name', 10, 3 );


function cfwc_add_custom_data_to_order($item, $cart_item_key, $values, $order)
{
	foreach ($item as $cart_item_key => $values) {
		if (isset($values['product_note_field'])) {
			$item->add_meta_data(__('Note Field', 'cfwc'), $values['product_note_field'], true);
		}
	}
}

add_action('woocommerce_checkout_create_order_line_item', 'cfwc_add_custom_data_to_order', 10, 4);


function cfwc_create_custom_field_width()
{
	$args = array(
		'id' => 'product_custom_width',
		'label' => __('Custom width', 'cfwc'),
		'class' => 'cfwc-custom-field',
		'desc_tip' => true,
		'description' => __('Enter the width here.', 'ctwc'),
	);
	woocommerce_wp_text_input($args);
}

add_action('woocommerce_product_options_advanced', 'cfwc_create_custom_field_width');

//function cfwc_save_field_width($post_id)
//{
//	$product = wc_get_product($post_id);
//	$title = isset($_POST['product_custom_width']) ? $_POST['product_custom_width'] : '';
//	$product->update_meta_data('product_custom_width', sanitize_text_field($title));
//	$product->save();
//}
//
//add_action('woocommerce_process_product_meta', 'cfwc_save_field_width');


function cfwc_add_field_width_item_data($cart_item_data)
{
	if (!empty($_POST['product-custom-width-field'])) {
		// Add the item data
		$cart_item_data['product_custom_width'] = $_POST['product-custom-width-field'];
	}
	return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'cfwc_add_field_width_item_data', 10, 4);


add_filter('woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2);
function filter_dropdown_option_html($html, $args)
{
	if ($args['attribute'] === 'pa_width' && in_array('custom-width', $args['options'])) {
		echo '<input type="number" data-min="9" data-max="42" step="any" class="input-text custom-field custom-width-input" id="product-custom-width-field" placeholder="Custom width" name="product-custom-width-field">';
	}

	return $html;
}

function cfwc_add_custom_width_to_order($item, $cart_item_key, $values, $order)
{
	foreach ($item as $cart_item_key => $values) {
		if (isset($values['product_custom_width'])) {
			$item->add_meta_data(__('Custom Width Field', 'cfwc'), $values['product_custom_width'], true);
		}
	}
}

add_action('woocommerce_checkout_create_order_line_item', 'cfwc_add_custom_width_to_order', 10, 4);




function filter_woocommerce_get_item_data( $item_data, $cart_item ) {
	if (isset($cart_item['product_custom_width']) &&  $cart_item['product_custom_width'] && in_array(['key' => 'Width', 'value' => 'Custom width'],$item_data )) {
		$ind = array_search(['key' => 'Width', 'value' => 'Custom width'], $item_data);
		$item_data = array_replace($item_data, [$ind => ['key' => 'Width', 'value' => $cart_item['product_custom_width']]]);
	}
	return $item_data;
}

add_filter( 'woocommerce_get_item_data', 'filter_woocommerce_get_item_data', 10, 2 );

remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );

//
//function custom_min_max__validation($status, $product_id, $quantity, $variation_id, $variations){
//	$product = wc_get_product($variation_id);
//	$attr = $product->get_attributes();
//	$width = $attr['pa_width'];
//	if ($width === 'custom-width') {
//
//		$custom_width = get_post_meta( $product_id);
////		echo var_export($custom_width['product_custom_width'][0]);
//		echo var_export($product);
//
//	}
//		wc_add_notice('custom_min_max__validation','error');
//		$status = false;
//
//	return $status;
//}
//add_action( 'woocommerce_add_to_cart_validation', 'custom_min_max__validation', 1, 5 );
