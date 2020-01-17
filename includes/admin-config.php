<?php
/**
* Admin Menu Functions
*
* Various functions relating to the various administration screens
*
* @package	Open-Currency-Converter
*/

/**
* Show Admin Messages
*
* Display messages on the administration screen
*
* @since	1.2
*
*/

function occ_show_admin_messages() {

    $options = occ_get_options();
	$screen = get_current_screen();

    if ( ( ( !isset( $options[ 'id' ] ) ) or ( '' === $options[ 'id' ] ) ) && ( current_user_can( 'edit_posts' ) && ( $screen->id !== 'settings_page_options' ) ) ) {
        echo '<div id="message" class="error"><p>' . __( '<a href="options-general.php?page=options">A valid App ID must be specified</a> before Open Currency Converter will work.', 'artiss-currency-converter' ) . '</p></div>';
		$screen = get_current_screen();
    }
}

add_action( 'admin_notices', 'occ_show_admin_messages' );

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	1.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function occ_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'artiss-currency-converter.php' ) !== false ) {
		$settings_link = '<a href="options-general.php?page=options">' . __( 'Settings', 'artiss-currency-converter' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}
add_filter( 'plugin_action_links', 'occ_add_settings_link', 10, 2 );

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	1.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function occ_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'artiss-currency-converter.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="http://wordpress.org/support/plugin/artiss-currency-converter">' . __( 'Support', 'artiss-currency-converter' ) . '</a>' ) ); 

		$links = array_merge( $links, array( '<a href="https://github.com/dartiss/open-currency-converter">' . __( 'Github', 'artiss-currency-converter' ) . '</a>' ) );	

	}

	return $links;
}
add_filter( 'plugin_row_meta', 'occ_set_plugin_meta', 10, 2 );

/**
* Administration Menu
*
* Add a new option to the Admin menu and context menu
*
* @since	1.0
*
* @uses occ_help		Return help text
*/

function occ_menu() {

    // Add options sub-menu

    global $occ_options_hook;

	$occ_options_hook = add_submenu_page( 'options-general.php', __( 'Open Currency Converter Options', 'artiss-currency-converter' ), __( 'Open Currency', 'artiss-currency-converter' ), 'install_plugins', 'options', 'occ_options' );

    add_action( 'load-' . $occ_options_hook, 'occ_add_options_help' );

    // Add rates sub-menu

	global $occ_rates_hook;

	$occ_rates_hook = add_submenu_page( 'tools.php', __( 'Open Currency Converter Rates', 'artiss-currency-converter' ), __( 'Currency Rates', 'artiss-currency-converter' ), 'edit_posts', 'rates', 'occ_rates' );

	add_action( 'load-' . $occ_rates_hook, 'occ_add_rates_help' );

}
add_action( 'admin_menu','occ_menu' );

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	1.0
*
* @uses     occ_options_help    Return help text
*/

function occ_add_options_help() {

    global $occ_options_hook;
    $screen = get_current_screen();

    if ( $screen->id !== $occ_options_hook ) { return; }

    $screen -> add_help_tab( array( 'id' => 'options-help-tab', 'title'	=> __( '🤝 Help', 'artiss-currency-converter' ), 'content' => occ_help_screen( 'options' ) ) );

    $screen -> add_help_tab( array( 'id' => 'options-links-tab', 'title'	=> __( '🔗 Links', 'artiss-currency-converter' ), 'content' => occ_help_screen( 'options', 'links' ) ) );
}

/**
* Add Rates Help
*
* Add help tab to exchange rates screen
*
* @since	1.0
*
* @uses     occ_search_help    Return help text
*/

function occ_add_rates_help() {

    global $occ_rates_hook;
    $screen = get_current_screen();

    if ( $screen->id !== $occ_rates_hook ) { return; }

    $screen -> add_help_tab( array( 'id' => 'rates-help-tab', 'title' => __( '🤝 Help', 'artiss-currency-converter' ), 'content' => occ_help_screen( 'rates' ) ) );

    $screen -> add_help_tab( array( 'id' => 'rates-links-tab', 'title'	=> __( '🔗 Links', 'artiss-currency-converter' ), 'content' => occ_help_screen( 'rates', 'links' ) ) );
}

/**
* Options screen
*
* Define an option screen
*
* @since	1.0
*/

function occ_options() {

	include_once( plugin_dir_path( __FILE__ ) . 'options.php' );

}

/**
* Rates screen
*
* Define the exchange rates screen
*
* @since	1.0
*/

function occ_rates() {

	include_once( WP_PLUGIN_DIR . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . 'rates.php' );

}

/**
* Help Screen
*
* Return help text for options and rates screen
*
* @since	1.0
*
* @param    string 	$screen 	Which screen the text is for
* @param 	string 	$tab 		Which tab this is for 
*
* @return	string				Help Text
*/

function occ_help_screen( $screen, $tab = '' ) {

	$help_text = '';

	if ( $screen == 'options' && $tab != 'links' ) {

		$help_text .= '<p>' . __( "This screen allows you to set some default options. If, when using the shortcode or function call, you don't specify a particular parameter then the default from this screen will be used.", 'artiss-currency-converter' ) . '</p>';
		$help_text .= '<p>' . __( "Before you can begin, though, you need to specify an API Key - <a href=\"https://openexchangerates.org/signup/free\">get one here for free</a>!", 'artiss-currency-converter' ) . '</p>';
		$help_text .= '<p>' . __( 'When that\'s all done you can also set caching times - this is to limit the regularity of updates to the exchange rates and currency codes. The former is updated hourly and the latter ad-hoc, so retrieving this information everytime is not required.', 'artiss-currency-converter' ) . '</p>';
	}


	if ( $screen == 'rates' && $tab != 'links' ) {

		$help_text .= '<p>' . __( 'Use this screen to view the current exchange rates along with all the currency codes. All exchange rates are in relation to the US Dollar.', 'artiss-currency-converter' ) . '</p>';
		$help_text .= '<p>' . __( 'You can also perform a currency conversion from this screen too using the options at the very top.', 'artiss-currency-converter' ) . '</p>';
	}

	if ( $tab == 'links' ) {

		$help_text .= '<p><strong>' . __( 'For more information:', 'artiss-currency-converter' ) . '</strong></br>';
		$help_text .= '📖 <a href="https://wordpress.org/plugins/artiss-currency-converter/">' . __( 'Plugin Documentation', 'artiss-currency-converter' ) . '</a></br>';
		$help_text .= '📣 <a href="https://wordpress.org/support/plugin/artiss-currency-converter/">' . __( 'Support Forum', 'artiss-currency-converter' ) . '</a></br>';
		$help_text .= '🐞 <a href="https://github.com/dartiss/open-currency-converter/issues">' . __( 'Report an issue or suggest an enhancement', 'artiss-currency-converter' ) . '</a></p>';	

		$help_text .= '<p>💰 <a href="https://openexchangerates.org/">' . __( 'Open Exchange Rates', 'artiss-currency-converter' ) . '</a></p>';			

		$help_text .= '<p>⭐️ <a href="https://wordpress.org/support/plugin/artiss-currency-converter/reviews/#new-post">' . __( 'Write a review', 'artiss-currency-converter' ) . '</a></br>';
		$help_text .= '💳 <a href="https://artiss.blog/donate">' . __( 'Donate if you like this plugin', 'artiss-currency-converter' ) . '</a></p>';

	}

	return $help_text;
}
