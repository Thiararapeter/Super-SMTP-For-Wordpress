<?php
/**
 * @package Super SMTP Plugin
 * @version 3.1.0
 *
 * Plugin Name: Super SMTP Plugin
 * Plugin URI: https://github.com/Thiararapeter/Super-SMTP
 * Description: Super Mailer SMTP is an open-source WordPress plugin that empowers you to enhance email delivery reliability through SMTP. Say goodbye to email delivery issues and take control of your email notifications. Easily configure your SMTP settings, send test emails, and keep a watchful eye on your email logs—all from a user-friendly interface.
 * Version: 3.1.0
 * Author: Thiarara
 * Author URI: https://github.com/Thiararapeter
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Support Email: contact@thiarara.co.ke
 * Requires at least: 4.9
 * Requires PHP: 5.2.4
 * 
 * About the Developer:
 * Thiarara, the developer behind Super Mailer SMTP, is a dedicated and experienced WordPress enthusiast who is passionate about improving the email communication experience for WordPress users. With a commitment to open-source development, Thiarara has made this plugin freely available for the WordPress community.
 */

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

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/Thiararapeter/Super-SMTP',
	__FILE__,
	'Super SMTP Plugin'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');