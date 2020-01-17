<?php
/*
Plugin Name: Open Currency Converter
Plugin URI: https://github.com/dartiss/open-currency-converter
Description: Convert currencies within the text of a post or page.
Version: 1.4.5
Author: David Artiss
Author URI: https://artiss.blog
Text Domain: artiss-currency-converter
*/

/**
* Open Currency Converter
*
* Main code - include various functions
*
* @package	Open-Currency-Converter
* @since	1.0
*/

define( 'open_currency_converter_version', '1.4.5' );

/**
* Main Includes
*
* Include all the plugin's functions
*
* @since	1.0
*/

// Include all the various functions

include_once( plugin_dir_path( __FILE__ ) . 'includes/admin-config.php' );        	// Assorted admin configuration changes

include_once( plugin_dir_path( __FILE__ ) . 'includes/get-options.php' );			// Fetch/create default options

include_once( plugin_dir_path( __FILE__ ) . 'includes/shared-functions.php' );		// Shared functionality

include_once( plugin_dir_path( __FILE__ ) . 'includes/convert-currency.php' );		// Main code to perform currency conversion

include_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php' );	        // Shortcodes

include_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );	        	// PHP function calls
