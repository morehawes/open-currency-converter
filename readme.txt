=== Open Currency Converter ===
Contributors: dartiss
Donate link: https://artiss.blog/donate
Tags: cash, conversion, convert, currency, money
Requires at least: 4.6
Tested up to: 5.6
Requires PHP: 5.3
Stable tag: 1.4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

💵 Convert currencies within the text of a post or page.

== Description ==

🚀 If you have a wish to convert currencies "on the fly" within the text of a post or page then this is the plugin for you! It's free to download, free to use and advert free - if you think you have to pay for something you're doing it wrong!

So, let's say you run a UK based site and will refer to currencies in GBP. However, the majority of visitors are from the US, so you may have a wish to also show the dollar equivalent. Using this plugin you can do this without having to work out the conversion and then re-visit it in future to take into account conversion changes.

Key features include...

* No need to update exchange rates yourself - data is fetched from an Open Source API
* Over 170 currencies supported
* An easy to use shortcode for embedding directly into your posts and pages
* A PHP function for those people who wish to add features in their theme
* Results can be cached, reducing resources and improving response
* Template to allow you to control how results are output
* Administration screen allowing you to define defaults and to view current exchange rates
* And much, much more!

Iconography is courtesy of the very talented [Janki Rathod](https://www.fiverr.com/jankirathore) ♥️

👉 Please visit the [Github page](https://github.com/dartiss/open-currency-converter "Github") for the latest code development, planned enhancements and known issues 👈

== Getting Started ==

🔑 **Getting Your App Key**

Open Currency Converter gets its data from the Open Exchange Rates website (which is not associated with this plugin nor the developer). This site requires an App Key to be specified for it to work. This is to prevent over-use of the exchange system and to provide premium features for users who wish to pay for them. Having a premium plan does not add any extra features to this plugin and is not a requirement.

To get your App Key...

1. [Sign up on the Open Exchange Rates site](https://openexchangerates.org/signup/free) - this link will take you to the free option but the site does require personal information.
2. You should now be at [your account screen](https://openexchangerates.org/account).
3. Click on the "App IDs" option in the side menu.
4. An App ID should be listed on the right hand side - copy this ID.
5. Head back to the admin of your website and select the Settings -> Open Currency menu.
6. Paste the App ID into the equivalent field at the top of the settings screen.
7. Click the "Save Changes" button.

**Using the Shortcode**

To add to your site simply use the `[convert]` shortcode. For example...

`[convert number=49.99 from="gbp" to="usd"]`

This would convert 49.99 GBP to USD.

⚠️ **Disclaimer**

The exchange rate data is provided for free via the [Open Source Exchange Rates](http://openexchangerates.org/ "Open Source Exchange Rates") project. Its accuracy and availability are never guaranteed, and there's no warranty provided.

== 🖥 The Options Screen ==

Once the plugin is activated two new administration screens will be present.

* **Open Currency** - This appears under "Settings" and allows you to specify default settings for any currency conversion
* **Exchange Rates** - Shown under the "Tools" menu, this displays the current exchange rates along with a list of all the valid exchange codes

Before using this plugin it is highly recommended that you review the Options screen and change any values, as appropriate. You will also need to sign up for and enter an App Key before conversions will work.

== 🗜 Using the Shortcode ==

The shortcode of '[convert]' has the following parameters that you may specify...

* **number** - The number that you wish to convert from one currency to another. This is required
* **from** - The currency code that you wish to convert from (see the admin options for a list of valid codes). If you do not specify this value then the default from the options screen will be used
* **to** - The currency code that you wish to convert to (see the admin options for a list of valid codes). If you do not specify this value then the default from the options screen will be used.
* **dp** - How many decimal places the output should be. This should be numeric or the word "match". The latter is the default and will mean that the output will match the number of decimal places that the **number** was.
* **template** - See the later section, "Using Templates", for further information

Example of use are...

`[convert number=49.99 from="gbp" to="usd"]`

This would convert 49.99 from UK pounds to US dollars and output the result to 2 decimal places.

`[convert number=50 from="usd" to="gbp"]`

This would convert 50 from US dollars to UK pounds and output the result without any decimal places.

If the conversion can't be done then an appropriate error message will be output instead. If you wish to suppress these messages then you need to use a template (see the later section on this) - in this case no output will be generated in the case of an error.

== 🧩 Using Templates ==

The template option allows you to specify other information to be output along with the conversion result. None of the template will be output if any error occurs, including any error messages, allowing you to suppress any conversion text in the case of a problem.

The template text must include `%result%` where you wish the output to appear.

Here's an example...

`The retail price is $49.99[convert number=50 from=“use” to=“gap” template=" (approx.%result%) GBP”].`

Normally, this would print a result such as...

`The retail price is $49.99 (approx. 79.11 GBP).`

However, if an error occurs then it will print as...

`The retail price is $49.99.`

You may also include the template between opening and closing shortcode tags. For example...

`The retail price is $49.99[convert number=50 from=“use” to=“gap”] (approx. %result% GBP)[/convert].`

== Using the Function Call ==

If you wish to perform a currency conversion within your theme, rather than within a post or page, then you can use a PHP function call. The function name is `get_conversion` and will return the result back.

* All of the shortcode parameters are valid, except for the template which isn't required
* The parameters are specified in any order and are separated with an ampersand
* You should not add quotes around each parameter value, as you do with the shortcode

For example...

`<?php echo get_conversion( 'number=49.99&from=gbp&to=usd' ); ?>`

== 🌍 Global conversion variables ==

For the use of developers, 2 global variables have been added which, if assigned within your site code, will override the conversion codes.

The variables are `global_convert_from` and `global_convert_to`.

This is useful if, say, you have multiple versions of the site in different languages - you can then assign these global variables depending on which site is being viewed and all currency will be converted based upon these settings.

These will only override the options screen and not specific parameters specified with a shortcode or function call.

== Installation ==

Open Currency Converter can be found and installed via the Plugin menu within WordPress administration (Plugins -> Add New). Alternatively, it can be downloaded from WordPress.org and installed manually...

1. Upload the entire `artiss-currency-converter` folder to your `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress administration.

Voila! It's ready to go.

== Screenshots ==

1. The options screen with help tab open
2. The exchange rate screen (length truncated)

== Changelog ==

I use semantic versioning, with the first release being 1.0.

= 1.4.5 =
* Enhancement: Improved the help on both admin screens
* Maintenance: Added donation links back in
* Maintenance: Added in some missing flags
* Maintenance: Improved the README instructions, based on feedback
* Maintenance: Added Github links to plugin meta
* Bug: Fixed `Use of undefined constant global_convert_from` PHP warning

= 1.4.4 =
* Maintenance: Removed donation links

= 1.4.3 =
* Enhancement: The shortcode is now loaded at all times, as loading only outside of admin didn’t add any performance improvement
* Maintenance: Updated this README to better reflect the new plugin directory format
* Maintenance: Corrected links to artiss.blog
* Maintenance: This plugin now requires a minimum WordPress level of 4.6, so changes were made to accommodate that, including the removal of various language features
* Maintenance: Added in a couple of missing country flags

= 1.4.2 =
* Maintenance: Updated API URL, including new SSL addresses

= 1.4.1 =
* Maintenance: Updated branding, inc. adding donation links

= 1.4 =
* Enhancement: Validated, sanitized and escaped the user data being sloshed around the admin screens
* Enhancement: Modified some INCLUDES so that the plugin folder wasn't hardcoded. Also replaced the deprecated WP_PLUGIN_URL with plugins_url
* Enhancement: When the API key hasn't yet been specified, the prompt will appear when in the settings screen as well
* Maintenance: Updated branding, including removal of donation links
* Maintenance: Removed the occ- prefixes from the file names
* Maintenance: Modified administration screens so that they use the same coding standard as the core screens
* Bug: Fixed some links that were not correct
* Bug: Resolved some PHP errors
* Bug: Fixed an issue with the default options when migrating from an earlier version of the plugin

= 1.3.1 =
* Maintenance: Added a text domain and domain path, as well as correcting the domain name.

= 1.3 =
* Enhancement: Added some swizzy new currency flags.
* Enhancement: Now handles commas in your provided currency amount. It even adds them in the result. Nice.
* Maintenance: New name and less advertising. We're nice like that.
* Maintenance: Removed the specific admin menu because, well, it wasn't needed. Moved the plugin options to the general Admin Options and exchange rates to Tools.
* Maintenance: Added support for WordPress 4.3 admin menu changes.
* Maintenance: Re-written the README and on-screen options to be clearer and, more importantly, make sure people realize you can get the API data for FREE!
* Bug: We've been on PHP error hunt... we're not scared.. we went and found some big ones... FIXED!

= 1.2 =
* Enhancement: Added message to admin screen if App Key not set
* Maintenance: Updated advertising engine code to latest version
* Maintenance: Updated README Parser function name
* Bug: Corrected the user permissions

= 1.1.1 =
* Bug: Error on activation when installed alongside certain other plugins which share a particular function

= 1.1 =
* Enhancement: Country flag icons, where appropriate, are now shown on the rates screen
* Enhancement: Added global variables for overriding default currencies
* Enhancement: Conversion in rates screen now shows results as 2 DP
* Maintenance: Advertisements now appear in the options screens, but implemented option to switch off if donated
* Maintenance: New App Key requirements implemented
* Maintenance: Put in place minimum values for caching - no longer able to switch off
* Bug: Fixed internationalization, including rates screens which was not being translated

= 1.0.1 =
* Fixed bug where currency output that contained a thousand separator was being interpreted as an error message!

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.4.5 =
* Minor bug fixes and maintenance changes