<?php
/**
 * Plugin Name: WooCommerce Custom Delivery Order Email
 * Plugin URI: #
 * Description: Custom email template for Delivery order status
 * Author: SkyVerge
 * Author URI: #
 * Version: 0.1
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *  Add a custom email to the list of emails WooCommerce should load
 *
 * @since 0.1
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 */
function add_expedited_order_woocommerce_email( $email_classes ) {

	// include our custom email class
	require_once( get_template_directory().'/inc/class-wc-expedited-order-email.php' );

	// add the email class to the list of email classes that WooCommerce loads
	$email_classes['WC_Email_Customer_Delivery_Order'] = new WC_Email_Customer_Delivery_Order();

	return $email_classes;

}
add_filter( 'woocommerce_email_classes', 'add_expedited_order_woocommerce_email' );
