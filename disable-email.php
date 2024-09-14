<?php
/*
Plugin Name: Disable Email
Plugin URI: https://www.littlebizzy.com/plugins/disable-email
Description: Completely disables email sending
Version: 1.0.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
GitHub Plugin URI: https://github.com/littlebizzy/disable-email
Primary Branch: master
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Disable WordPress.org updates for this plugin
add_filter( 'gu_override_dot_org', function( $overrides ) {
    $overrides[] = 'disable-email/disable-email.php';
    return $overrides;
});

// Disable all email sending in WordPress
add_filter( 'wp_mail', function( $args ) {
    return false; // Disable all emails
});

// Disable the PHPMailer instance initialization
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->ClearAllRecipients();
    $phpmailer->ClearAttachments();
    $phpmailer->ClearCustomHeaders();
    $phpmailer->ClearReplyTos();
    $phpmailer->Subject = '';
    $phpmailer->Body = '';
    return $phpmailer; // Ensure the mailer is effectively blocked
});

// Disable email notifications for password resets
add_filter( 'retrieve_password_message', '__return_empty_string' );
add_filter( 'retrieve_password_title', '__return_empty_string' );

// Disable email notifications for new user registrations
add_filter( 'wp_new_user_notification_email', '__return_false' );

// Disable plugin and core update email notifications
add_filter( 'auto_core_update_send_email', '__return_false' );
add_filter( 'send_core_update_notification_email', '__return_false' );
add_filter( 'automatic_updates_send_debug_email', '__return_false', 1 );
add_filter( 'auto_plugin_update_send_email', '__return_false', 1 );
add_filter( 'auto_theme_update_send_email', '__return_false', 1 );

// Ref: ChatGPT
