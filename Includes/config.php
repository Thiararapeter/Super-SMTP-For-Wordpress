<?php

// Register and define the settings
function super_smtp_settings() {
    register_setting('super_smtp_settings', 'super_smtp_host', array(
        'type' => 'string',
        'description' => 'Enter the SMTP host address.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('super_smtp_settings', 'super_smtp_port', array(
        'type' => 'integer',
        'description' => 'Select the SMTP port number.',
        'sanitize_callback' => 'absint',
    ));

    register_setting('super_smtp_settings', 'super_smtp_username', array(
        'type' => 'string',
        'description' => 'Enter the SMTP username.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('super_smtp_settings', 'super_smtp_password', array(
        'type' => 'string',
        'description' => 'Enter the SMTP password.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('super_smtp_settings', 'super_smtp_secure', array(
        'type' => 'string',
        'description' => 'Select the security type (SSL/TLS).',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('super_smtp_settings', 'super_smtp_email', array(
        'type' => 'string',
        'description' => 'Email address for sending emails.',
        'sanitize_callback' => 'sanitize_email',
    ));

    register_setting('super_smtp_settings', 'super_smtp_website_name', array(
        'type' => 'string',
        'description' => 'Website name for outgoing emails.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add other settings as needed

    add_settings_section('super_smtp_section', 'SMTP Settings', 'super_smtp_section_callback', 'super-smtp-settings');

    add_settings_field('super_smtp_website_name', 'Website Name', 'super_smtp_website_name_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_email', 'Sender Email Address', 'super_smtp_email_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_host', 'SMTP Host', 'super_smtp_host_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_port', 'SMTP Port', 'super_smtp_port_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_username', 'SMTP Username', 'super_smtp_username_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_password', 'SMTP Password', 'super_smtp_password_callback', 'super-smtp-settings', 'super_smtp_section');
    add_settings_field('super_smtp_secure', 'SMTP Secure', 'super_smtp_secure_callback', 'super-smtp-settings', 'super_smtp_section');
}

function super_smtp_section_callback() {
    echo '<p>Enter your SMTP settings below:</p>';
}

function super_smtp_host_callback() {
    echo '<input type="text" name="super_smtp_host" value="' . esc_attr(get_option('super_smtp_host')) . '" />';
    echo '<p class="description">Host address of your SMTP server.</p>';
}

function super_smtp_port_callback() {
    $port = esc_attr(get_option('super_smtp_port'));
    $options = array('' => 'None', '587' => '587', '465' => '465', '25' => '25');
    echo '<select name="super_smtp_port">';
    foreach ($options as $value => $label) {
        echo '<option value="' . $value . '" ' . selected($port, $value, false) . '>' . $label . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Port number for your SMTP server.</p>';
}

function super_smtp_username_callback() {
    echo '<input type="text" name="super_smtp_username" value="' . esc_attr(get_option('super_smtp_username')) . '" />';
    echo '<p class="description">Username for authenticating with your SMTP server.</p>';
}

function super_smtp_password_callback() {
    $password = esc_attr(get_option('super_smtp_password'));
    echo '<input type="password" name="super_smtp_password" value="' . $password . '" id="super_smtp_password" />';
    echo '<input type="checkbox" id="show_password" onclick="togglePasswordVisibility()"> Show Password';
    echo '<p class="description">Password for authenticating with your SMTP server.</p>';
    echo '<script>
            function togglePasswordVisibility() {
                var passwordField = document.getElementById("super_smtp_password");
                var showPasswordCheckbox = document.getElementById("show_password");

                if (showPasswordCheckbox.checked) {
                    passwordField.type = "text";
                } else {
                    passwordField.type = "password";
                }
            }
          </script>';
}

function super_smtp_secure_callback() {
    $secure = esc_attr(get_option('super_smtp_secure'));
    $options = array('' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS');
    echo '<select name="super_smtp_secure">';
    foreach ($options as $value => $label) {
        echo '<option value="' . $value . '" ' . selected($secure, $value, false) . '>' . $label . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Select the security type (SSL/TLS).</p>';
}

function super_smtp_email_callback() {
    echo '<input type="text" name="super_smtp_email" value="' . esc_attr(get_option('super_smtp_email')) . '" />';
    echo '<p class="description">Email address for sending emails.</p>';
}

function super_smtp_website_name_callback() {
    echo '<input type="text" name="super_smtp_website_name" value="' . esc_attr(get_option('super_smtp_website_name')) . '" />';
    echo '<p class="description">Website name for outgoing emails.</p>';
}

add_action('admin_init', 'super_smtp_settings');