<?php

function custom_wc_shipping_notification( $order_id, $checkout=null ) {
	$order_slug = 'delivery868';

	global $woocommerce;

	$order = new WC_Order( $order_id );

	//error_log( $order->status );

	if($order->status === $order_slug ) {

		WC()->mailer()->emails['WC_Email_Customer_Delivery_Order']->trigger($order_id);
	}

}
add_action( 'woocommerce_order_status_changed', 'custom_wc_shipping_notification');