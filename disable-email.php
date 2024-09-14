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

// Ref: ChatGPT
