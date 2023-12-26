<?php
// Add a menu item in the admin menu
    function super_smtp_menu() {
        add_menu_page(
            'Super SMTP Plugin',
            'Super SMTP',
            'manage_options',
            'super-smtp-settings',
            'super_smtp_settings_page',
            'dashicons-email-alt2', // Set the icon
            20 // Set the position (you may need to adjust this value)
        );
    }
    add_action('admin_menu', 'super_smtp_menu');

// Create the SMTP settings page
function super_smtp_settings_page() {
    ?>
    
    <style>
        .super-tab-content {
            display: none;
            border: 1px solid #ddd; /* Add border to tab content */
            padding: 20px; /* Add padding to tab content */
            margin-top: 10px; /* Add margin to separate tabs */
        }

        .super-tab-content.active {
            display: block;
        }

        .tab-container {
            max-width: 600px; /* Set maximum width for the tab container */
        }

        .tab-container label {
            display: block;
            margin-top: 5%; /* Add margin between form elements */
        }

        #super-test-email-message {
            height: 200px; /* Adjust the height of the custom message input field */
        }
    </style>

    <div class="wrap">
        <h1 class="nav-tab-wrapper">
            <a href="#super-smtp-settings" class="nav-tab nav-tab-active">SMTP Settings</a>
            <a href="#super-test-email" class="nav-tab">Test Email</a>
            <a href="#super-email-log" class="nav-tab">Email Log</a>
        </h1>

        <div id="super-smtp-settings" class="super-tab-content">
            <form method="post" action="options.php">
                <?php
                settings_fields('super_smtp_settings');
                do_settings_sections('super-smtp-settings');
                submit_button();
                ?>
            </form>
        </div>

        <div id="super-test-email" class="super-tab-content">
    <div class="tab-container">
        <h2>Test Email</h2>

        <?php
        if (isset($_POST['super_test_email'])) {
            // Check if all required fields are filled
            $required_fields = array('super_test_email_to', 'super_test_email_subject', 'super_test_email_message');

            $all_fields_filled = true;
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $all_fields_filled = false;
                    echo '<div class="notice notice-error is-dismissible"><p>All fields are required. Please fill in all fields before sending the test email.</p></div>';
                    break;
                }
            }

            if ($all_fields_filled) {
                // Proceed with sending the test email
                check_admin_referer('super_test_email_nonce', 'super_test_email_nonce');

                $to = sanitize_email($_POST['super_test_email_to']);
                $subject = sanitize_text_field($_POST['super_test_email_subject']);
                $message = sanitize_text_field($_POST['super_test_email_message']);
                $headers = 'From: ' . get_option('admin_email');

                $result = wp_mail($to, $subject, $message, $headers);

                // Log the email
                $log_entry = array(
                    'date'    => current_time('mysql'),
                    'to'      => $to,
                    'subject' => $subject,
                    'status'  => $result ? 'Sent' : 'Failed',
                );

                $logs = get_option('super_smtp_email_logs', array());
                $logs[] = $log_entry;
                update_option('super_smtp_email_logs', $logs);

                if ($result) {
                    echo '<div class="notice notice-success is-dismissible"><p>Test email sent successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error is-dismissible"><p>Failed to send test email. Please check your SMTP settings.</p></div>';
                }
            }
        }

                    // Inside the function super_smtp_settings_page
            if (isset($_POST['clear_email_logs'])) {
                check_admin_referer('clear_email_logs_nonce', 'clear_email_logs_nonce');

                // Clear the email logs
                update_option('super_smtp_email_logs', array());

                echo '<div class="notice notice-success is-dismissible"><p>Email logs cleared successfully!</p></div>';
            }
        ?>

        <form method="post" action="">
            <?php wp_nonce_field('super_test_email_nonce', 'super_test_email_nonce'); ?>
            <label for="super_test_email_to">Recipient Email:</label>
            <input type="email" name="super_test_email_to" id="super_test_email_to" value="<?php echo esc_attr(get_option('admin_email')); ?>" required>
            <label for="super_test_email_subject">Subject:</label>
            <input type="text" name="super_test_email_subject" id="super_test_email_subject" value="Test Email from Super SMTP Plugin" required>
            <label for="super_test_email_message">Message:</label>
            <textarea name="super_test_email_message" id="super_test_email_message" required></textarea>
            <input type="submit" class="button button-primary" name="super_test_email" value="Send Test Email">
        </form>
    </div>
</div>

<div id="super-email-log" class="super-tab-content">
    <h2>Email Log</h2>

    <?php
    // Display logs here
    $logs = get_option('super_smtp_email_logs', array());
    ?>
    <table class="widefat">
        <thead>
            <tr>
                <th>Date</th>
                <th>To</th>
                <th>Subject</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td><?php echo esc_html($log['date']); ?></td>
                    <td><?php echo esc_html($log['to']); ?></td>
                    <td><?php echo esc_html($log['subject']); ?></td>
                    <td><?php echo esc_html($log['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="post" action="">
        <?php wp_nonce_field('clear_email_logs_nonce', 'clear_email_logs_nonce'); ?>
        <?php if (!empty($logs)) : ?>
            <p><input type="submit" class="button button-primary" name="clear_email_logs" value="Clear Logs"></p>
        <?php endif; ?>
    </form>
</div>
</div>

<?php
}
?>