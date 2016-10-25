<?php
/**
 * Plugin Name: WooCommerce Custom Delivery Order Email
 * Plugin URI: #
 * Description: Custom email template for Delivery order status
 * Author: Jared Chu
 * Author URI: #
 * Version: 1.0
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


function add_delivery_order_woocommerce_email( $email_classes ) {

	// include our custom email class
	require_once( 'class-wc-delivery-order-email.php' );

	// add the email class to the list of email classes that WooCommerce loads
	$email_classes['WC_Email_Customer_Delivery_Order'] = new WC_Email_Customer_Delivery_Order();

	return $email_classes;

}

add_filter( 'woocommerce_email_classes', 'add_delivery_order_woocommerce_email' );

//custom order setting
function custom_wc_shipping_notification( $order_id, $checkout = null ) {
	$order_slug = get_option( 'wc_custom_order_status_for_delivery_email_id', 1 );

	global $woocommerce;

	$order = new WC_Order( $order_id );

	//error_log( $order->status );

	if ( $order->status === $order_slug ) {

		WC()->mailer()->emails['WC_Email_Customer_Delivery_Order']->trigger( $order_id );
	}

}

add_action( 'woocommerce_order_status_changed', 'custom_wc_shipping_notification' );

//add setting section
if ( is_admin() ) {
	add_filter( 'woocommerce_email_settings', 'add_text_custom_order_status_setting' );
}

function add_text_custom_order_status_setting( $settings ) {
	$updated_settings = array();

	foreach ( $settings as $section ) {


		// at the bottom of the General Options section

		if ( isset( $section['id'] ) && 'email_recipient_options' == $section['id'] &&

		     isset( $section['type'] ) && 'sectionend' == $section['type']
		) {


			$updated_settings[] = array(

				'name' => __( 'Custom order status for Delivery Email', 'wc_custom_order_status_for_delivery_email' ),

				'desc_tip' => __( '', 'wc_custom_order_status_for_delivery_email' ),

				'id' => 'wc_custom_order_status_for_delivery_email_id',

				'type' => 'text',

				'css' => 'min-width:300px;',

				'std' => 'custom-order-status-slug',  // WC < 2.0

				'default' => 'custom-order-status-slug',  // WC >= 2.0

				'desc' => __( ' Enter your custom order status slug ex delivery123', 'wc_custom_order_status_for_delivery_email' ),
			);

		}


		$updated_settings[] = $section;

	}

	return $updated_settings;

}