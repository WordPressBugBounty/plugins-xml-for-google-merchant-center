<?php

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link                    https://icopydoc.ru
 * @since                   1.0.0
 * @package                 X4GMC
 *
 * @wordpress-plugin
 * Plugin Name:             XML for Google Merchant Center
 * Requires Plugins:        woocommerce
 * Plugin URI:              https://icopydoc.ru/category/documentation/xml-for-google-merchant-center/ 
 * Description:             Connect your store to Google Merchant Center and unload products, getting new customers
 * Version:                 3.0.12
 * Requires at least:       4.5
 * Requires PHP:            7.4.0
 * Author:                  Maxim Glazunov
 * Author URI:              https://icopydoc.ru/
 * License:                 GPL-2.0+
 * License URI:             http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:             xml-for-google-merchant-center
 * Domain Path:             /languages
 * Tags:                    xml, google, Google Merchant Center, export, woocommerce
 * WC requires at least:    3.0.0
 * WC tested up to:         9.6.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$not_run = false;

// Check php version
if ( version_compare( phpversion(), '7.4.0', '<' ) ) { // не совпали версии
	add_action( 'admin_notices', function () {
		warning_notice( 'notice notice-error',
			sprintf(
				'<strong style="font-weight: 700;">%1$s</strong> %2$s 7.4.0 %3$s %4$s',
				'XML for Google Merchant Center',
				__( 'plugin requires a php version of at least', 'xml-for-google-merchant-center' ),
				__( 'You have the version installed', 'xml-for-google-merchant-center' ),
				phpversion()
			)
		);
	} );
	$not_run = true;
}

// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if ( ! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', [] ) ) )
	&& ! ( is_multisite()
		&& array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', [] ) ) )
) {
	add_action( 'admin_notices', function () {
		warning_notice(
			'notice notice-error',
			sprintf(
				'<strong style="font-weight: 700;">XML for Google Merchant Center</strong> %1$s',
				__( 'requires WooCommerce installed and activated', 'xml-for-google-merchant-center' )
			)
		);
	} );
	$not_run = true;
} else {
	// add support for HPOS
	add_action( 'before_woocommerce_init', function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	} );
}

if ( ! function_exists( 'warning_notice' ) ) {
	/**
	 * Display a notice in the admin plugins page. Usually used in a @hook `admin_notices`.
	 * 
	 * @since 0.1.0
	 * 
	 * @param string $class
	 * @param string $message
	 * 
	 * @return void
	 */
	function warning_notice( $class = 'notice', $message = '' ) {
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}

// Define constants
define( 'XFGMC_PLUGIN_VERSION', '3.0.12' );

$upload_dir = wp_get_upload_dir();
// http://site.ru/wp-content/uploads
define( 'XFGMC_SITE_UPLOADS_URL', $upload_dir['baseurl'] );

// /home/site.ru/public_html/wp-content/uploads
define( 'XFGMC_SITE_UPLOADS_DIR_PATH', $upload_dir['basedir'] );

// http://site.ru/wp-content/uploads/xfgmc
define( 'XFGMC_PLUGIN_UPLOADS_DIR_URL', $upload_dir['baseurl'] . '/xfgmc' );

// /home/site.ru/public_html/wp-content/uploads/xfgmc
define( 'XFGMC_PLUGIN_UPLOADS_DIR_PATH', $upload_dir['basedir'] . '/xfgmc' );
unset( $upload_dir );

// http://site.ru/wp-content/plugins/xml-for-google-merchant-center/
define( 'XFGMC_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

// /home/p135/www/site.ru/wp-content/plugins/xml-for-google-merchant-center/
define( 'XFGMC_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

// /home/p135/www/site.ru/wp-content/plugins/xml-for-google-merchant-center/xml-for-google-merchant-center.php
define( 'XFGMC_PLUGIN_MAIN_FILE_PATH', __FILE__ );

// xml-for-google-merchant-center - псевдоним плагина
define( 'XFGMC_PLUGIN_SLUG', wp_basename( dirname( __FILE__ ) ) );

// xml-for-google-merchant-center/xml-for-google-merchant-center.php - полный псевдоним плагина (папка плагина + имя главного файла)
define( 'XFGMC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// $not_run = apply_filters('xfgmc_f_nr', $not_run);

// load translation
add_action( 'plugins_loaded', function () {
	load_plugin_textdomain( 'xml-for-google-merchant-center', false, dirname( XFGMC_PLUGIN_BASENAME ) . '/languages/' );
} );

if ( false === $not_run ) {
	unset( $not_run );

	// for wp_kses
	define( 'X4GMC_ALLOWED_HTML_ARR', [ 
		'a' => [ 
			'href' => true,
			'title' => true,
			'target' => true,
			'class' => true,
			'style' => true
		],
		'br' => [ 'class' => true ],
		'i' => [ 'class' => true ],
		'small' => [ 'class' => true ],
		'strong' => [ 'class' => true, 'style' => true ],
		'p' => [ 'class' => true, 'style' => true ],
		'kbd' => [ 'class' => true ],
		'input' => [ 
			'id' => true,
			'name' => true,
			'class' => true,
			'placeholder' => true,
			'style' => true,
			'type' => true,
			'value' => true,
			'step' => true,
			'min' => true,
			'max' => true
		],
		'textarea' => [ 
			'id' => true,
			'name' => true,
			'class' => true,
			'placeholder' => true,
			'style' => true,
			'col' => true,
			'row' => true
		],
		'select' => [ 'id' => true, 'class' => true, 'name' => true, 'style' => true, 'size' => true, 'multiple' => true ],
		'option' => [ 'id' => true, 'class' => true, 'style' => true, 'value' => true, 'selected' => true ],
		'optgroup' => [ 'label' => true ],
		'label' => [ 'id' => true, 'class' => true ],
		'tr' => [ 'id' => true, 'class' => true ],
		'th' => [ 'id' => true, 'class' => true ],
		'td' => [ 'id' => true, 'class' => true ]
	] );

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'X4GMC_PLUGIN_VERSION', '3.0.12' );

	require_once XFGMC_PLUGIN_DIR_PATH . '/packages.php';
	register_activation_hook( __FILE__, [ 'XmlforGoogleMerchantCenter', 'on_activation' ] );
	register_deactivation_hook( __FILE__, [ 'XmlforGoogleMerchantCenter', 'on_deactivation' ] );
	add_action( 'plugins_loaded', [ 'XmlforGoogleMerchantCenter', 'init' ], 10 ); // активируем плагин
	define( 'XFGMC_ACTIVE', true );
}