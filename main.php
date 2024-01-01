<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/Thiararapeter
 * @since             1.0.0
 * @package           Super_Smtp
 *
 * @wordpress-plugin
 * Plugin Name:       Super SMTP
 * Plugin URI:        https://https://github.com/Thiararapeter/Super-SMTP
 * Description:       Super Mailer SMTP is an open-source WordPress plugin that empowers you to enhance email delivery reliability through SMTP. Say goodbye to email delivery issues and take control of your email notifications. Easily configure your SMTP settings, send test emails, and keep a watchful eye on your email logs—all from a user-friendly interface.
 * Version:           3.1.11
 * Author:            Thiarara
 * Author URI:        https://https://github.com/Thiararapeter/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       super-smtp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Include the configuration settings
require_once plugin_dir_path(__FILE__) . 'Includes/config.php';

// Include the menu and form-related code
require_once plugin_dir_path(__FILE__) . 'Includes/email.php';

// Include the SMTP configuration and usage
require_once plugin_dir_path(__FILE__) . 'Includes/smtp.php';

// Enqueue scripts and styles in the admin area
function super_smtp_enqueue_scripts() {
    $styles_url = plugin_dir_url(__FILE__) . 'Assets/styles.css';

    wp_enqueue_script('super-smtp-scripts', plugin_dir_url(__FILE__) . 'Assets/scripts.js', array('jquery'), null, true);
    wp_enqueue_style('super-smtp-styles', $styles_url);
}
add_action('admin_enqueue_scripts', 'super_smtp_enqueue_scripts');

require 'xtra/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/Thiararapeter/Super-SMTP',
	__FILE__,
	'Super SMTP'
);
