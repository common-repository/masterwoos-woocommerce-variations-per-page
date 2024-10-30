<?php
/**
	Plugin Name: WooCommerce Product Variations Per Page
	Plugin URI: https://masterwoos.com/products/woocommerce-product-variations-per-page
	Description: This plugin controls the number of product variations that are displayed per page while editing products in WooCommerce. Settings are located here: WooCommece> Settings> Click the Product tab then click the section link Variations Per Page.
	Version: 1.0.0
	Author: Master Woo's
	Author URI: https://masterwoos.com/
	License: GPLv2 or later
	Requires at least: 3.4.1
	Tested up to: 4.7.2
	Text Domain: masterwoos-woocommerce-product-variations-per-page
	Domain Path: languages
 
	Copyright (C) 2017  Master Woo's  info@masterwoos.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

 */
 if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
 /**
 * Check if WooCommerce is active
 **/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'masterwoos_vp_add_section' );
function masterwoos_vp_add_section( $sections ) {
	
	$sections['masterwoos-vp'] = __( 'Variations Per Page', 'text-domain' );
	return $sections;
	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'masterwoos_vp_settings', 10, 2 );
function masterwoos_vp_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'masterwoos-vp' ) {
		$settings_masterwoos_vp = array();
		// Add Title to the Settings
		$settings_masterwoos_vp[] = array( 'name' => __( 'Variation Pagination Settings', 'text-domain' ), 'type' => 'title', 'desc' => __( 'Enter the number of product variations you would like to display per page while edting varaible products.', 'text-domain' ), 'id' => 'masterwoos-vp' );

		// Adding number field option
		$settings_masterwoos_vp[] = array(
			'name'     => __( 'Variations Per Page:', 'text-domain' ),
			'desc_tip' => __( 'The value entered here will control the number of prodcut variations that are displayed in the editor.', 'text-domain' ),
			'id'       => 'masterwoos_vp_number',
			'type'     => 'number',
			'min'      => 1,
			'max'      =>5000,
			'desc'     => __( 'Entered the number of prodcut variations to display per page in the product editor.' ),
		);
		
		$settings_masterwoos_vp[] = array( 'type' => 'sectionend', 'id' => 'masterwoos-vp' );
		return $settings_masterwoos_vp;
		
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

add_filter( 'woocommerce_admin_meta_boxes_variations_per_page', 'masterwoos_variations_per_page' );
function masterwoos_variations_per_page() {
	return get_option( 'masterwoos_vp_number');
}

}