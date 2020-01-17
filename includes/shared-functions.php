<?php
/**
* Shared Functions Functions
*
* Various functions that are called from a number of sources
*
* @package	Open-Currency-Converter
*/

/**
* Get exchange rates
*
* Extract exchange rates and convert from JSON to an array
*
* @since	1.0
*
* @param    string  $cache      Length of time to cache results (optional, default 60 minutes)
* @return	string				Array containing exchange rates
*/

function occ_get_rates( $cache = 60 ) {

    $rates = false;
    $cache_key = 'occ_rates';

    // Check if a cached version already exists - if so, return it

    if ( 'no' !== strtolower( $cache ) ) { $rates = get_transient( $cache_key ); }

    // If cache doesn't exist use CURL to get the exchange rates

    if ( !$rates ) {

        $options = occ_get_options();

        if ( !isset( $options[ 'id' ] ) or '' === $options[ 'id' ] ) {

            $rates = '#' . __( 'No App ID has been setup - please set this in the options screen', 'artiss-currency-converter' );

        } else {

            $file = occ_get_file( 'https://openexchangerates.org/api/latest.json?app_id=' . $options[ 'id' ] );

            if ( 0 !== $file[ 'rc' ] ) {

                $rates = '#' . __( 'Could not fetch exchange rate information', 'artiss-currency-converter' );

            } else {

                $json = $file[ 'file' ];

                // Decode the JSON output to an array

                $array = json_decode( $json, true );

                // Extract out just the rates element of the array

                if ( isset( $array[ 'rates' ] ) ) { $rates = $array[ 'rates' ]; }

                // Check that something was returned

                if ( '' === $rates ) {

                    $rates = '#' . __( 'No exchange rate information returned', 'artiss-currency-converter' );

                } else {

                    // Save to cache

                    if ( 'no' !== strtolower( $cache ) ) { set_transient( $cache_key, $rates, 60 * $cache ); }
                }
            }
        }
    }

    return $rates;

}

/**
* Get currency code
*
* Extract currency codes and convert from JSON to an array
*
* @since	1.0
*
* @param    string  $cache      Length of time to cache results (optional, default 24 hours)
* @return	string				Array containing currency codes
*/

function occ_get_codes( $cache = 24 ) {

    $codes = false;
    $cache_key = 'occ_codes';

    // Check if a cached version already exists - if so, return it

    if ( 'no' !== strtolower( $cache ) ) { $codes = get_transient( $cache_key ); }
    $codes = false;

    // If cache doesn't exist use CURL to get the currency codes

    if ( !$codes ) {

        $options = occ_get_options();

		if ( isset( $options[ 'id' ] ) ) { $file = occ_get_file( 'https://openexchangerates.org/api/currencies.json?app_id=' . $options[ 'id' ] ); }

        if ( !isset( $options[ 'id' ] ) or '' === $options[ 'id' ] ) {

            $rates = '#' . __( 'No App ID has been setup - please set this in the options screen', 'artiss-currency-converter' );

        } else {

            if ( 0 !== $file[ 'rc' ] ) {

                $rates = '#' . __( 'Could not fetch currency code information', 'artiss-currency-converter' );

            } else {

                $json = $file[ 'file' ];

                // Decode the JSON output to an array

                $codes = json_decode( $json, true );

                // Check that something was returned

                if ( '' === $codes ) {

                    $rates = '#' . __( 'No currency code information returned', 'artiss-currency-converter' );

                } else {

                    // Save to cache

                    if ( 'no' !== strtolower( $cache ) ) { set_transient( $cache_key, $codes, 3600 * $cache ); }
                }
            }
        }
    }

    return $codes;
}

/**
* Check cache values
*
* Ensure cache values are valid. If not, correct
*
* @since	1.1
*
* @param	string	$cache_value	Cache value
* @param	string	$min_value		Minimum value
* @return	string				    Resulting cache value
*/

function occ_check_cache( $cache_value, $min_value ) {

    $cache_value = trim( $cache_value );

    if ( !is_numeric( $cache_value ) ) {
        $cache_value= $min_value;
    } else {
        if ( ( $cache_value < $min_value ) or ( $cache_value > 999 ) ) {
            $cache_value = $min_value;
        }
    }

    return $cache_value;
}

/**
* Fetch a file (1.6)
*
* Use WordPress API to fetch a file and check results
* RC is 0 to indicate success, -1 a failure
*
* @since	1.0
*
* @param	string	$filein		File name to fetch
* @param	string	$header		Only get headers?
* @return	string				Array containing file contents and response
*/

function occ_get_file( $filein, $header = false ) {

	$rc = 0;
	$error = '';
	if ( $header ) {
		$fileout = wp_remote_head( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Header: ' . $fileout -> get_error_message();
			$rc = -1;
		}
	} else {
		$fileout = wp_remote_get( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Body: ' . $fileout -> get_error_message();
			$rc = -1;
		} else {
			if ( isset( $fileout[ 'body' ] ) ) {
				$file_return[ 'file' ] = $fileout[ 'body' ];
			}
		}
	}

	$file_return[ 'error' ] = $error;
	$file_return[ 'rc' ] = $rc;
	if ( !is_wp_error( $fileout ) ) {
		if ( isset( $fileout[ 'response' ][ 'code' ] ) ) {
			$file_return[ 'response' ] = $fileout[ 'response' ][ 'code' ];
		}
	}

	return $file_return;
}

/**
* Extract Parameters (1.1)
*
* Function to extract parameters from an input string
*
* @since	1.0
*
* @param	$input	string	Input string
* @param	$para	string	Parameter to find
* @return			string	Parameter value
*/

function occ_get_parameters( $input, $para, $divider = '=', $seperator = '&' ) {

    $start = strpos( strtolower( $input ), $para . $divider);
    $content = '';
    if ( $start !== false ) {
        $start = $start + strlen( $para ) + 1;
        $end = strpos( strtolower( $input ), $seperator, $start );
        if ( $end !== false ) { $end = $end - 1; } else { $end = strlen( $input ); }
        $content = substr( $input, $start, $end - $start + 1 );
    }
    return $content;
}
