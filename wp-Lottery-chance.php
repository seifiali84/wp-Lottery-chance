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
if(!function_exists('add_action')){
    echo "you don't have access to this file";
    exit;
}
require 'includes/db_Scores.php';
function LC_create_menu_page(){
    
}
//add_menu_page( "Lottery Chance", "Lottery Chance", "manage_options", "Lottery-Chance", "LC_create_menu_page", "dashicons-tickets-alt",5 );

function Active(){
    global $table_prefix , $wpdb;
    $table_name = $table_prefix."LC_Scores";
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
        wp_LC_create_table();   
    }
    wp_LC_Add_old_purchases_score();
}

register_activation_hook(__FILE__ , 'Active');
