<?php
function super_smtp_phpmailer_init($phpmailer) {
    // Set up basic SMTP configuration
    $phpmailer->isSMTP();
    $phpmailer->Host = get_option('super_smtp_host');
    $phpmailer->Port = get_option('super_smtp_port');
    $phpmailer->Username = get_option('super_smtp_username');
    $phpmailer->Password = get_option('super_smtp_password');
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = get_option('super_smtp_secure') ? 'ssl' : '';

    // You can add more configuration options as needed
    $phpmailer->SMTPAutoTLS = false; 
    $phpmailer->SMTPDebug = 2;
}

add_action('phpmailer_init', 'super_smtp_phpmailer_init');

