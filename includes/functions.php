<?php
/**
* Functions
*
* Functions calls
*
* @package	Open-Currency-Converter
*/

/**
* Conversion Function
*
* Function call to perform and return conversion
*
* @since	1.0
*
* @param	string	$paras		Parameters
* @return	string				Output
*/

function get_conversion( $paras = '' ) {

    // Extra parameters

    $number = occ_get_parameters( $paras, 'number' );
    $from = occ_get_parameters( $paras, 'from' );
    $to = occ_get_parameters( $paras, 'to' );
    $dp = occ_get_parameters( $paras, 'dp' );

    // Perform currency conversion using supplied parameters

    return occ_convert_currency( $number, $from, $to, $dp, '' );
}
