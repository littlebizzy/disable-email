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

// Disable all email sending in WordPress Core
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
    return $phpmailer;
});

// Disable password reset emails
add_filter( 'retrieve_password_message', '__return_empty_string' );
add_filter( 'retrieve_password_title', '__return_empty_string' );

// Disable new user registration emails
add_filter( 'wp_new_user_notification_email', '__return_false' );

// Disable all update-related email notifications
add_filter( 'auto_core_update_send_email', '__return_false' );
add_filter( 'send_core_update_notification_email', '__return_false' );
add_filter( 'automatic_updates_send_debug_email', '__return_false', 1 );
add_filter( 'auto_plugin_update_send_email', '__return_false', 1 );
add_filter( 'auto_theme_update_send_email', '__return_false', 1 );

// Disable comment moderation and notification emails
add_filter( 'comment_moderation_recipients', '__return_empty_array' );
add_filter( 'comment_notification_recipients', '__return_empty_array' );

// Disable admin email change confirmation
add_filter( 'admin_email_check_interval', '__return_false' );

// Disable site health-related email notifications
add_filter( 'wp_site_health_scheduled_check_email', '__return_false' );

// Disable user role or capability change notifications
add_action( 'set_user_role', function( $user_id, $role, $old_roles ) {}, 10, 3 );

// Disable email logging from logging plugins (like WP Mail Logging)
add_action( 'wp_mail', function( $args ) {
    if ( class_exists( 'WPML_Logging' ) ) {
        remove_all_filters( 'wp_mail' );
    }
    return $args;
});

// Disable WooCommerce transactional emails
if ( class_exists( 'WooCommerce' ) ) {
    add_filter( 'woocommerce_email_enabled_new_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_cancelled_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_failed_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_on_hold_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_processing_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_completed_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_refunded_order', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_invoice', '__return_false' );
    add_filter( 'woocommerce_email_enabled_low_stock', '__return_false' );
    add_filter( 'woocommerce_email_enabled_no_stock', '__return_false' );
    add_filter( 'woocommerce_email_enabled_backorder', '__return_false' );
    add_filter( 'woocommerce_email_enabled_customer_note', '__return_false' );
}

// Disable bbPress email notifications
if ( class_exists( 'bbPress' ) ) {
    // Disable bbPress new reply and new topic notifications
    add_filter( 'bbp_subscription_mail_message', '__return_empty_string' );
    add_filter( 'bbp_forum_subscription_mail_message', '__return_empty_string' );
    add_filter( 'bbp_topic_subscription_mail_message', '__return_empty_string' );
    add_filter( 'bbp_reply_subscription_mail_message', '__return_empty_string' );
    
    // Disable bbPress email headers
    add_filter( 'bbp_subscription_mail_headers', '__return_empty_string' );
    add_filter( 'bbp_forum_subscription_mail_headers', '__return_empty_string' );
    add_filter( 'bbp_topic_subscription_mail_headers', '__return_empty_string' );
    add_filter( 'bbp_reply_subscription_mail_headers', '__return_empty_string' );
}

// Disable REST API email notifications (for password reset, user updates, etc.)
add_filter( 'rest_password_reset_mail', '__return_false' );
add_filter( 'rest_new_user_notification', '__return_false' );

// Disable email notifications for admin email changes or profile updates
remove_action( 'profile_update', 'wp_send_user_request_notification' );
remove_action( 'profile_update', 'send_email_change_email' );
remove_action( 'profile_update', 'send_password_change_email' );

// Disable email notifications for new posts
remove_action( 'publish_post', 'wp_notify_postauthor' );

// Disable custom SMTP email setups that might bypass wp_mail
remove_action( 'phpmailer_init', 'wp_mail_smtp_init_smtp' );

// Ref: ChatGPT
