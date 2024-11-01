<?php

/**
 * 
 * WooCommerce Newsletter SignUp Form BY CONTACTUS.COM
 * 
 * Initialization WooCommerce Form Widget Class from WP_Widget
 * @since 1.0 First time this was introduced into WooCommerce Newsletter SignUp Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2013 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140218
 **/

//Contact Subscribe Box widget extend 
class woocommerce_form_Widget extends WP_Widget {

	function woocommerce_form_Widget() {
		$widget_ops = array( 
			'description' => __('Displays WooCommerce Form by ContactUs.com', 'woocommerce_form')
		);
		$this->WP_Widget('woocommerce_form_Widget', __('WooCommerce Form', 'woocommerce_form'), $widget_ops);
	}

	function widget( $args, $instance ) {
		if (!is_array($instance)) {
			$instance = array();
		}
		cUsWoo_contactuscom_form(array_merge($args, $instance));
	}
}
/*
* Method in charge to retrive ContactUs.com user's Default Form Key and render widget
* @param array $args Widget options 
* @since 1.0
* @return string HTML into the widget area
*/
function cUsWoo_contactuscom_form($args = array()) {
    extract($args);
    $cUs_form_key = get_option('cUsWoo_settings_form_key'); //get the saved form key
    
    if(strlen($cUs_form_key)){
        $xHTML  = '<div id="cUsWoo_form_widget" style="clear:both;min-height:530px;margin:10px auto;">';
        $xHTML .= '<script type="text/javascript" src="' . cUsWOO_ENV_URL . $cUs_form_key . '/inline.js"></script>';
        $xHTML .= '</div>';
        
        echo $xHTML;
    }
}