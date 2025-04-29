<?php
/**
 * Shortcodes
 *
 * Shortcode functions
 *
 * @package	Open-Currency-Converter
 */

/**
 * Conversion Shortcode
 *
 * Shortcode to perform and output conversion
 *
 * @since	1.0
 *
 * @param	string	$paras		Shortcode parameters
 * @param	string	$content	Optional template
 * @return	string				Output
 */

function occ_convert_shortcode($paras = '', $content = '') {

	extract(shortcode_atts(['number' => '', 'from' => '', 'to' => '', 'dp' => '', 'template' => '', 'thousands_separator' => ''], $paras));

	// If content provided, assume this to be the template

	if ('' !== $content) {$template = $content;}

	// Perform currency conversion using supplied parameters

	// Sanitize all inputs
	return occ_convert_currency($number, $from, $to, $dp, $template, esc_attr($thousands_separator));

}
add_shortcode('convert', 'occ_convert_shortcode');
