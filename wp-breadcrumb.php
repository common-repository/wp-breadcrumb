<?php
/*
Plugin Name: WP-Breadcrumb
Plugin URI: http://allyourweb.ru/
Description: Create advanced breadcrumb in wordpress pages. Плагин создает "хлебные крошки" - навигацию в виде цепочки. 
Version: 1.0.1
Author: Aisha Mahan
Author URI: http://allyourweb.ru/
*/
error_reporting(0); 
ini_set("display_errors", 0);

if ( ! defined( 'WP_BREADCRUMB_FILE_BASENAME' ) )
    define( 'WP_BREADCRUMB_FILE_BASENAME', basename( __FILE__ ) );

global $wp_breadcrumb;
add_action('admin_menu', 'wp_breadcrumb_admin_menu');
if (!class_exists('wp_breadcrumb_class')) require_once( plugin_dir_path( __FILE__ ).'wp-breadcrumb.class.php');
$wp_breadcrumb = new wp_breadcrumb_class();
$wp_breadcrumb->get_options();

register_activation_hook(__FILE__, 'wp_breadcrumb_activate');
register_deactivation_hook(__FILE__, 'wp_breadcrumb_deactivate');

add_action( 'admin_init', 'wp_breadcrumb_admin_init' );
function wp_breadcrumb_admin_init()
{    
    wp_register_style( 'wp_breadcrumb_admin_style', plugins_url('css/admin_style.css', __FILE__) );    
}


function wp_breadcrumb_activate(){
    global $wp_breadcrumb;
    $wp_breadcrumb->activate();    
}

function wp_breadcrumb_deactivate(){
    global $wp_breadcrumb;
    $wp_breadcrumb->deactivate();    
}

function wp_breadcrumb_show_full() {
    global $wp_breadcrumb;
    echo $wp_breadcrumb->wp_breadcrumb_get();
}

function wp_breadcrumb_admin_menu(){
    global $wp_breadcrumb;    
    if (function_exists('add_options_page'))
    {
        
        $wp_breadcrumb_admin_page = add_options_page('WP-Breadcrumb options', 'WP-Breadcrumb', 'manage_options', basename(__FILE__), 'wp_breadcrumb_options_page');
        add_action( 'admin_print_styles-' . $wp_breadcrumb_admin_page, 'wp_breadcrumb_enqueue_admin_styles' );                           
    } 
}

function wp_breadcrumb_enqueue_admin_styles()
{
    wp_enqueue_style('wp_breadcrumb_admin_style');
}

function wp_breadcrumb_options_page()
{
    global $wp_breadcrumb;            
    $wp_breadcrumb->view_options_page();       
}

 
?>