<?php
/**
* Exchange rates
*
* View exchange rate information
*
* @package	Open-Currency-Converter
* @since	1.0
*
* @uses	ace_get_embed_paras	Get the options
*/

// Fetch information from external functions

$options = occ_get_options();
$rates_array = occ_get_rates( $options[ 'rates_cache' ] );
$codes_array = occ_get_codes( $options[ 'codes_cache' ] );

// If a currency conversion has been requested, work out the result

if ( ( !empty( $_POST ) ) && ( check_admin_referer( 'rates' , 'open_currency_converter_nonce' ) ) ) {
	$from = sanitize_text_field( $_POST[ 'occ_from' ] );
	$to = sanitize_text_field( $_POST[ 'occ_to' ] );
	$number = sanitize_text_field( $_POST[ 'occ_number' ] );
    $result = $from . ' ' . $number . ' = ' . $to . ' ' . occ_perform_conversion( $number, $from, $to, '2' );
} else {
    $result = false;
}
?>

<div class="wrap">
<h1><?php _e( 'Open Currency Converter Rates', 'artiss-currency-converter' ); ?></h1>

<?php if ( isset( $options[ 'id' ] ) && '' !== $options[ 'id' ] ) { ?>

<p><?php _e( 'Below are the current exchange rates. All rates are in relation to USD. Alternatively use the following form to perform a quick conversion.', 'artiss-currency-converter' );?></p>

<p><form method="post" action="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/tools.php?page=rates' ?>">

<?php _e( 'Amount', 'artiss-currency-converter' );?>&nbsp;<input type="text" size="8" name="occ_number" value=""/>

<?php _e( 'From', 'artiss-currency-converter' );?>&nbsp;<select name="occ_from">
<?php
foreach( $rates_array as $cc => $exchange_rate ){
    echo '<option value="' . esc_html( $cc ). '"';
    if ( isset( $options[ 'from' ] ) && $cc === $options[ 'from' ] ) { echo " selected='selected'"; }
    echo '>' . esc_html( $cc ) . '</option>';
    next( $rates_array );
}
?>
</select>

<?php _e( 'To', 'artiss-currency-converter' );?>&nbsp;<select name="occ_to">
<?php
foreach( $rates_array as $cc => $exchange_rate ){
    echo '<option value="' . esc_html( $cc ) . '"';
    if ( isset( $options[ 'to' ] ) && $options[ 'to' ] === $cc ) { echo " selected='selected'"; }
    echo '>' . esc_html( $cc ) . '</option>';
    next( $rates_array );
}
?>
</select>

<?php wp_nonce_field( 'rates', 'open_currency_converter_nonce', true, true ); ?>

<input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Convert', 'artiss-currency-converter' ); ?>"/>

<?php if ( $result !== false ) { echo '&nbsp;'. $result; } ?>

</form></p>

<table>
<tr><td></td><td><strong><?php _e( 'Currency Code', 'artiss-currency-converter' ); ?></strong></td><td><strong><?php _e( 'Currency Name', 'artiss-currency-converter' ); ?></strong></td><td><strong><?php _e( 'Exchange Rate', 'artiss-currency-converter' ); ?></strong></td></tr>
<tr><td colspan="4">&nbsp;</td></tr>
<?php
reset ($rates_array);
foreach ( $rates_array as $cc => $exchange_rate ) {
    echo '<tr><td width="26px">';

    // Output a flag, if one exists

    $flag_dir = plugins_url( 'images/flags/', dirname(__FILE__) );
    $flag_file = strtolower( $cc ) . '.png';
    $flag_name = __( 'Flag', 'artiss-currency-converter' );
    if ( '' !== $codes_array[ $cc ] ) { $flag_name = sprintf( __( 'Flag for %s', 'artiss-currency-converter' ), $codes_array[ $cc ] ); }

    echo '<img src="' . $flag_dir . $flag_file . '" alt="' . $flag_name . '" title="' . $flag_name . '" width="16px" height="11px">';

    // Now output the rest of the currency information

    echo '</td><td width="100px">' . $cc . '</td><td width="300px">' . $codes_array[ $cc ] . '</td><td>' . $exchange_rate . '</td>';
    next ( $rates_array );
    echo "</tr>\n";
}
?>
</table>

<?php } ?>
</div>
