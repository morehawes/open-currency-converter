<?php
/**
* Set Default Options
*
* Allow the user to change the default options
*
* @package	Open-Currency-Converter
* @since	1.0
*
* @uses	occ_get_options Get the options
*/
?>
<div class="wrap">
<h1><?php _e( 'Open Currency Converter Options', 'artiss-currency-converter' ); ?></h1>
<?php

// If options have been updated on screen, update the database

$fetch_options = true;
if ( ( !empty( $_POST ) ) && ( check_admin_referer( 'options' , 'open_currency_converter_options_nonce' ) ) ) {

    // Check validity of App ID

    $error = __( 'The App ID is invalid.', 'artiss-currency-converter' );
	if ( isset( $_POST[ 'occ_app_id' ] ) ) {
		if ( 32 !== strlen( $_POST[ 'occ_app_id' ] ) ) {
			$fetch_options = false;
		} else {
			$file = occ_get_file( 'https://openexchangerates.org/api/latest.json?app_id=' . sanitize_text_field( $_POST[ 'occ_app_id' ] ) );
			if ( 0 !== $file[ 'rc' ] ) {
				$error = __( 'Could not validate App ID. Please try again later.', 'artiss-currency-converter' );
				$fetch_options = false;
			} else {
				if ( strpos( $file[ 'file' ], 'invalid_app_id' ) !== false ) { $fetch_options = false; }
			}
		}
	}

    // Update the options array from the form fields.

    if ( $fetch_options ) { $options[ 'id' ] = $_POST[ 'occ_app_id' ]; }

    if ( isset( $_POST[ 'occ_from' ] ) ) { $options[ 'from' ] = sanitize_text_field( $_POST[ 'occ_from' ] ); }
	if ( isset( $_POST[ 'occ_to' ] ) ) { $options[ 'to' ] = sanitize_text_field( $_POST[ 'occ_to' ] ); }
	if ( isset( $_POST[ 'occ_dp' ] ) ) { $options[ 'dp' ] = sanitize_text_field( $_POST[ 'occ_dp' ] ); }

    // Check caches and ensure they are valid

    if ( isset( $_POST[ 'occ_rates_cache' ] ) ) { $options[ 'rates_cache' ] = occ_check_cache( sanitize_text_field( $_POST[ 'occ_rates_cache' ] ), 60 ); }
    if ( isset( $_POST[ 'occ_codes_cache' ] ) ) { $options[ 'codes_cache' ] = occ_check_cache( sanitize_text_field( $_POST[ 'occ_codes_cache' ] ), 1 ); }

    // Update the options

    update_option( 'open_currency_converter', $options );

    if ( $fetch_options ) {

        echo '<div class="updated fade"><p><strong>' . __( 'Settings Saved.', 'artiss-currency-converter' ) . "</strong></p></div>\n";

    } else {

        echo '<div class="error fade"><p><strong>' . $error . "</strong></p></div>\n";
    }
}

// Fetch options and rates into an array

$options = occ_get_options();
if ( $fetch_options && isset( $_POST[ 'occ_app_id' ] ) ) { $options[ 'key' ] = $_POST[ 'occ_app_id' ]; }
$rates_array = occ_get_rates( $options[ 'rates_cache' ] );
$codes_array = occ_get_codes( $options[ 'codes_cache' ] );

if ( !isset( $options[ 'id' ] ) or $options[ 'id' ] == '' ) {
	echo '<div class="error fade"><p><strong>' . __( 'A valid App ID must be specified before Open Currency Converter will work.', 'artiss-currency-converter' ) . '</strong></p></div>' . "\n";
}
?>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/options-general.php?page=options' ?>">

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'App ID', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_app_id"><input type="text" size="32" maxlength="32" name="occ_app_id" value="<?php if ( isset( $options[ 'id' ] ) ) { echo esc_html( $options[ 'id' ] ); } ?>"/></label>
<p class="description"><?php _e( 'Your App ID. It\'s FREE - <a href="https://openexchangerates.org/signup/free">sign up here</a> if you don\'t have one.', 'artiss-currency-converter' ); ?></p></td>
</tr>

<tr>
<th scope="row"><?php _e( 'From', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_from"><select name="occ_from">
<?php
if ( is_array( $rates_array) ) {
	foreach( $rates_array as $cc => $exchange_rate ){
		echo '<option value="' . $cc . '"';
		if ( isset( $options[ 'from' ] ) && $options[ 'from' ] == $cc ) { echo " selected='selected'"; }
		echo '>' . $cc . ' - ' . $codes_array[ $cc ] . '</option>';
		next( $rates_array );
	}
}
?>
</select><?php _e( 'The currency to convert from', 'artiss-currency-converter' ); ?></label></td>
</tr>

<tr>
<th scope="row"><?php _e( 'To', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_to"><select name="occ_to">
<?php
if ( is_array( $rates_array) ) {
	foreach( $rates_array as $cc => $exchange_rate ){
		echo '<option value="' . esc_html( $cc ) . '"';
		if ( isset( $options[ 'to' ] ) && $options[ 'to' ] == $cc ) { echo " selected='selected'"; }
		echo '>' . esc_html( $cc ) . ' - ' . esc_html( $codes_array[ $cc ] ) . '</option>';
		next( $rates_array );
	}
}
?>
</select><?php _e( 'The currency to convert to', 'artiss-currency-converter' ); ?></label></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Decimal Places', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_dp"><select name="occ_dp">
<option value="0"<?php if ( $options[ 'dp' ] == '0' ) { echo " selected='selected'"; } ?>>0</option>
<option value="1"<?php if ( $options[ 'dp' ] == '1' ) { echo " selected='selected'"; } ?>>1</option>
<option value="2"<?php if ( $options[ 'dp' ] == '2' ) { echo " selected='selected'"; } ?>>2</option>
<option value="match"<?php if ( $options[ 'dp' ] == 'match' ) { echo " selected='selected'"; } ?>><?php _e ( 'Match' ); ?></option>
</select><?php _e( 'The number of decimal points that the result should be to' ); ?></label>
<p class="description"><?php _e( "'1' will cause a final 0 to be added and 'Match' will get the result to match the number given.", 'artiss-currency-converter' ); ?></p></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Exchange Rates Cache', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_rates_cache"><input type="text" size="3" maxlength="3" name="occ_rates_cache" value="<?php echo esc_html( $options[ 'rates_cache' ] ); ?>"/><?php _e( "The length of time, in minutes, to cache the exchange rates. Minimum is 60.", 'artiss-currency-converter' ); ?></label></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Currency Codes Cache', 'artiss-currency-converter' ); ?></th>
<td><label for="occ_codes_cache"><input type="text" size="3" maxlength="3" name="occ_codes_cache" value="<?php echo esc_html( $options[ 'codes_cache' ] ); ?>"/><?php _e( "The length of time, in hours, to cache the currency codes. Minimum is 1.", 'artiss-currency-converter' ); ?></label></td>
</tr>

</table>

<?php wp_nonce_field( 'options', 'open_currency_converter_options_nonce', true, true ); ?>

<br/><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'artiss-currency-converter' ); ?>"/>

</form>

</div>
