<?php
/*
Plugin Name: Open Currency Converter
Plugin URI: https://wordpress.org/plugins/artiss-currency-converter/
Description: Convert currencies within the text of a post or page.
Version: 1.4.4
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

define( 'open_currency_converter_version', '1.4.4' );

/**
* Main Includes
*
* Include all the plugin's functions
*
* @since	1.0
*/

$functions_dir = plugin_dir_path( __FILE__ ) . 'includes/';

// Include all the various functions

include_once( $functions_dir . 'admin-config.php' );        	// Assorted admin configuration changes

include_once( $functions_dir . 'get-options.php' );             // Fetch/create default options

include_once( $functions_dir . 'shared-functions.php' );		// Shared functionality

include_once( $functions_dir . 'convert-currency.php' );		// Main code to perform currency conversion

include_once( $functions_dir . 'shortcodes.php' );	        	// Shortcodes

include_once( $functions_dir . 'functions.php' );	        	// PHP function calls
?>