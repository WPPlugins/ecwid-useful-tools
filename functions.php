<?php

// Widget handler
function ecwid_random_products_widgets_init() {

	// Declared in the ecwid-useful-tools/classes/Widget.php
	register_widget('EcwidRandomProductsWidget');

}

// Activation of plugin
function ecwid_random_products_activate() {

	add_option('ecwid_random_products_use_cache', 'on', '', 'yes');
    add_option('ecwid_random_products_use_local_currency', '', '', 'yes');
    add_option('ecwid_random_products_currency_prefix', '', '', 'yes');
    add_option('ecwid_random_products_currency_suffix', '', '', 'yes');

}

// Removal of plugin
function ecwid_random_products_uninstall() {

    delete_option('ecwid_random_products_use_cache');
    delete_option('ecwid_random_products_use_local_currency');
    delete_option('ecwid_random_products_currency_prefix');
    delete_option('ecwid_random_products_currency_suffix');

}

// Registers plugins settings 
function ecwid_random_products_admin_init() {

	register_setting ('ecwid_random_products_options_page', 'ecwid_random_products_use_cache');
    register_setting ('ecwid_random_products_options_page', 'ecwid_random_products_use_local_currency');
    register_setting ('ecwid_random_products_options_page', 'ecwid_random_products_currency_prefix');
    register_setting ('ecwid_random_products_options_page', 'ecwid_random_products_currency_suffix');

	if (isset($_GET['ecwid_random_products_clear_cache'])) {

		try {

			EcwidRandomProductsCache::clearCache();
			wp_redirect(admin_url('options-general.php?page=ecwid_random_products_options_page'));

		} catch (Exception $e) {

		}

	}

}

// Creates a page with plugin's settings
function ecwid_random_products_add_menu_page() {

	add_options_page('Settings of Ecwid: Random Products', 'Ecwid: Random Products', 'manage_options', 'ecwid_random_products_options_page', 'ecwid_random_products_do_options_page');

}

/*
 Handler for ecwid_random_products_add_menu_page()
 Creates a page with settings at wp-admin/options-general.php?page=ecwid_random_products_options_page
*/
function ecwid_random_products_do_options_page() {

	$config = EcwidRandomProductsCoreSettings::getInstance();
	$currency_settings = $config->getCurrency();

?>

<div class="wrap">
	<h2>Settings of Ecwid: Random Products</h2>
	<form method="post" action="options.php">
		<?php settings_fields('ecwid_random_products_options_page'); ?>	
		<table class="form-table">
			<tr><th colspan=2><h3>Module status</h3></th></tr>

			<tr>
				<th scope="row" colspan=3><label><?php 
					if (get_ecwid_store_id() && get_ecwid_store_id() != 1003)
						echo __('Your Ecwid store ID is ') . "<strong>" . get_ecwid_store_id() . "</strong>.";
					else
						echo 'Your Ecwid store ID is not specified yet. Use <a href="http://kb.ecwid.com/Instruction-on-how-to-get-your-free-Store-ID-(for-WordPress)" target="_blank"><strong>these instructions</strong></a> in order to obtain it and then specify it on <a href="options-general.php?page=ecwid_options_page"><strong>Ecwid Shopping cart plugin</strong></a> settings page.';

			?></label></th>
			</tr>

			<?php 

			echo WPSwiftLib::showCheckboxSetting('ecwid_random_products_use_cache', $config->useCache() , __('Cache requests to Ecwid server'));

			?>
			<tr><td><a class="button-secondary" href="<?php echo admin_url('options-general.php?page=ecwid_random_products_options_page&ecwid_random_products_clear_cache'); ?>"><?php echo __('Clear Cache'); ?></a></td></tr>

			<tr><th colspan=3><h3>Currency Settings</h3></th></tr>

			<?php

			echo WPSwiftLib::showCheckboxSetting('ecwid_random_products_use_local_currency', $config->isLocalCurrency(), __('Enable usage of manually-defined currency settings'), __('<img src="//www.ecwid.com/wp-content/uploads/ecwid_wp_attention.gif" alt="">&nbsp;If ticked off, your Ecwid store\'s currency settings will be used instead. Use it if you have free Ecwid account only and/or experience troubles displaying currency properly.'));

			echo WPSwiftLib::showStringSetting('ecwid_random_products_currency_prefix', $currency_settings['local']['prefix'], __('Currency prefix'));

			echo WPSwiftLib::showStringSetting('ecwid_random_products_currency_suffix', $currency_settings['local']['suffix'], __('Currency suffix'));

			?>

		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php echo __('Save Changes') ?>" />
		</p>
	</form>
	<p><h3>Useful links</h3></p>
	<p style="margin-left: 30px;"><a href="options-general.php?page=ecwid_options_page">Settings of Ecwid Shopping cart plugin</a></p>
	<br />
	<p><h3>More Wordpress & Ecwid API services</h3></p>
	<p style="margin-left: 30px;">We are experienced Ecwid API and Wordpress developers, so if you wish to extend the functionality of this plugin or would like to deeper integrate your Wordpress with Ecwid, we will be happy to do this job for you. If you are experiencing any troubles with your existing Wordpress installation and something does not work properly, we would be glad to resolve such kind of issues as well.<br /><br />Contact us at <a href='mailto:wordpress@qtmsoft.com?subject=Wordpress and Ecwid API. Request for quote'>wordpress@qtmsoft.com</a>. Please specify the subject as <b>Wordpress and Ecwid API. Request for quote</b> and get free quote for any task!</p>
</div>
<?php
}

// Shows warnings in the header if there are any critical issues
function ecwid_random_products_admin_message() {

	if (!EcwidRandomProductsCoreSettings::getInstance()->isCorePluginActive()) {

		echo "<div id='' class='updated fade'><p>The required core <a href='http://wordpress.org/extend/plugins/ecwid-shopping-cart/'><strong>Ecwid Shopping Cart</strong></a> plugin is not installed or not activated yet. Please, make it active prior using Ecwid: Random products one.</p></div>";

	}

	try {
		EcwidRandomProductsCache::isCacheFolderAvailable(); 

	} catch (Exception $e) {

		echo "<div id='' class='updated fade'><p>The cache directory for Ecwid: Random products plugin cannot be created. Please make sure that directory WP/wp-content/plugins/ecwid-useful-tools/cache/ can be created.</p></div>";

	}
		
}

// [ecwid_random_products ..] shortcode handler
function ecwid_random_products_shortcode($atts) {

        $atts = (shortcode_atts(array(
                        'show_price' => false,
                        'show_title' => false,
                        'product_width' => 0,
                        'per_row' => 1,
                        'number' => 1,
                        'category' => 0,
                        ),
                        $atts));


        return EcwidRandomProductsProductDisplay::showProducts($atts);

}
