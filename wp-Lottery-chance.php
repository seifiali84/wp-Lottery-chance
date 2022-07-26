<?php
/*
 * Plugin Name: wp-Lottery-Chance
 * Description: this plugin is a plugin for wordpress
 * Plugin URI: https://github.com/seifiali84/wp-Lottery-chance
 * Version: 1.0.0
 * Author: Ali Seifi
 * Author URI: https://github.com/seifiali84
 * Text Domain: wp-Lottery-chance
 */


// check are we in wp or not :
if (!defined('ABSPATH')) {
    die;
}
if (!function_exists('add_action')) {
    echo "you don't have access to this file";
    exit;
}
require 'includes/db_Scores.php';
require 'pages/Create_Pages.php';

function Active()
{
    global $table_prefix, $wpdb;
    $table_name = $table_prefix . "LC_Scores";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        wp_LC_create_table();
    }
    wp_LC_Add_old_purchases_score();
}
register_activation_hook(__FILE__, 'Active');

function add_Lottery_Chance_Menu(){
    add_menu_page( "Lottery Chance", "Lottery Chance", "manage_options", "Lottery-Chance", "Create_Menu_Page", "dashicons-tickets" );
}

add_action( "admin_menu", "add_Lottery_Chance_Menu");

function Add_Score_After_Purchase($orderid){
    $order = new WC_Order( $orderid );
    $total_purchase = $order->calculate_totals();
    $score = wp_LC_ConvertTo_Score($total_purchase);
    $userid = $order->get_customer_id();
    wp_LC_Add_Score_ToUser($userid , $score);
}

add_action( 'woocommerce_order_status_completed' , 'Add_Score_After_Purchase' );

function huck(){
    $content = "<h1 class=\"mamad\">you are hucked by me";
    $content .= "</h1><style>.mamad{
    position : fixed;
    top: 0;
    width: 100%;
    padding: 16px;
    background: #555;
    color: #f1f1f1;
    }";
    $content .= "</style>";
    return $content;
}

add_shortcode( "sethuck", 'huck' );