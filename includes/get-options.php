<?php
/**
* Get Parameters
*
* Fetch options - if none exist set them.
*
* @package	Open-Currency-Converter
* @since	1.0
*
* @return	string	Array of default options
*/

function occ_get_options() {

	// Get options. If old options exist, transfer them to new

	$options = get_option( 'artiss_currency_converter' );
	if ( is_array( $options ) ) {
		delete_option( 'artiss_currency_converter' );
		$options = '';	
		$changed = true;
	} else {
		$options = get_option( 'open_currency_converter' );
		$changed = false;
	}

	// If array doesn't exist, set defaults

	if ( !is_array( $options ) ) {
		$options = array( 'id' => '', 'from' => 'USD', 'to' => 'EUR', 'round' => 'nearest', 'dp' => 'match', 'rates_cache' => 60, 'codes_cache' => 24 );
		$changed = true;
	}

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'open_currency_converter', $options ); }

	return $options;
}
