<?php
/*
Plugin Name: Ecwid: Random products 
Plugin URI: http://wordpress.org/extend/plugins/ecwid-useful-tools/ 
Description: Enables tools to display random products from Ecwid store.
Author: Tony Sologubov
Version: 0.7.6
Author URI: http://www.qtmsoft.com/wordpress-services.html 
*/

// Ecwid random products' home directory
define ('RANDOM_PRODUCTS_DIR' , rtrim(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

// Initialization
require_once (RANDOM_PRODUCTS_DIR . 'init.php');

// Contains functions for hooks, actions etc that are defined below
require_once (RANDOM_PRODUCTS_DIR . 'functions.php');

// Wordpress API
register_activation_hook (__FILE__ , 'ecwid_random_products_activate');
register_uninstall_hook (__FILE__ , 'ecwid_random_products_uninstall');
add_action('widgets_init', 'ecwid_random_products_widgets_init');

if (is_admin()) {

        add_action('admin_init', 'ecwid_random_products_admin_init');
        add_action('admin_menu', 'ecwid_random_products_add_menu_page');
        add_action('admin_notices', 'ecwid_random_products_admin_message');

} else {

        add_shortcode('ecwid_random_products', 'ecwid_random_products_shortcode');

}
