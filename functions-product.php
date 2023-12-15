<?php

function cfwc_create_custom_field() {
	$args = array(
		'id' => 'product_note',
		'label' => __( 'Note', 'cfwc' ),
		'class' => 'cfwc-custom-field',
		'desc_tip' => true,
		'description' => __( 'Enter the note.', 'ctwc' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_advanced', 'cfwc_create_custom_field' );


function cfwc_save_custom_field( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['product_note'] ) ? $_POST['product_note'] : '';
	$product->update_meta_data( 'product_note', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_field' );

function cfwc_display_custom_field() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID );
	$title = $product->get_meta( 'product_note' );
//	if( $title ) {
		// Only display our field if we've got a value for the field title
		printf(
			'<div class="product__note"><label for="product-note-field">Note:</label><input type="text" class="input-text" id="product-note-field" name="product-note-field" value="%s"></div>',
			esc_html( $title )
		);
//	}
}
add_action( 'woocommerce_before_single_variation', 'cfwc_display_custom_field' );


function cfwc_add_custom_field_item_data( $cart_item_data ) {
	if( ! empty( $_POST['product-note-field'] ) ) {
		// Add the item data
		$cart_item_data['product_note_field'] = $_POST['product-note-field'];
	}
	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'cfwc_add_custom_field_item_data', 10, 4 );


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


function cfwc_add_custom_data_to_order( $item, $cart_item_key, $values, $order ) {
	foreach( $item as $cart_item_key=>$values ) {
		if( isset( $values['product_note_field'] ) ) {
			$item->add_meta_data( __( 'Note Field', 'cfwc' ), $values['product_note_field'], true );
		}
	}
}
add_action( 'woocommerce_checkout_create_order_line_item', 'cfwc_add_custom_data_to_order', 10, 4 );