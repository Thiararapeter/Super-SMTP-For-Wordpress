<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/Thiararapeter/super-smtp-pro
 * @since      3.0.2
 *
 * @package    Super_SMTP_Pro
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Perform uninstall actions here, if any.
// ...

// For example, delete options and data stored by the plugin.
delete_option('super_smtp_plugin_option1');
delete_option('super_smtp_plugin_option2');

// You may also want to drop custom database tables if any.
global $wpdb;
$custom_table_name = $wpdb->prefix . 'your_custom_table';
$wpdb->query("DROP TABLE IF EXISTS $custom_table_name");
