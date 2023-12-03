<?php
/**
 * @package Minimal Admin
 * @version 1.0.2
 * Plugin Name: Minimal Administration
 * Plugin URI: https://www.minimaladmin.online
 * Description: Bring your admin panel into the 21st century with this minimalist design and give your customers a professional looking interface.
 * Author: Hartum
 * Version: 1.0.2
 * Author URI: http://hartum.net/
 * Text Domain: minimal-admin
 * License: GPLv2 or later.
 * License URI: https://www.gnu.org/licenses/gpl - 2.0.html
*/

//--- ADD LANGUAGES BY LOAD
add_action( 'plugins_loaded', 'wpdocs_load_textdomain' );
function wpdocs_load_textdomain() {
    load_plugin_textdomain( 'minimal-admin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
  }

add_action( 'admin_init', 'reset_css', 1 );
function reset_css() {
	wp_enqueue_style( 'ma_reset', plugin_dir_url( __FILE__ ).'admin/css/reset.css' );
}
//--- SELECT DARK/LIGHT THEME ---
//---Read the config file
$ma_settings =  plugin_dir_path( __FILE__ ).'admin/settings/ma_settings.json';
$jsonString = file_get_contents($ma_settings);
$jsonData = json_decode($jsonString, true);
//--- choose the theme
if($jsonData["mode"] == 'light'){
    add_action( 'admin_init', 'ligth_theme', 1 );
} else {
    add_action( 'admin_init', 'dark_theme', 1 );
}
//--- define the inclusion of the theme
function ligth_theme() {
	wp_enqueue_style( 'ma_theme', plugin_dir_url( __FILE__ ).'admin/css/light.css' );
}
function dark_theme() {
	wp_enqueue_style( 'ma_theme', plugin_dir_url( __FILE__ ).'admin/css/dark.css' );
}


//--- ADD COMMON CSS AND JS---
add_action( 'admin_init', 'common_css_and_js', 1 );
function common_css_and_js() {
	wp_enqueue_style( 'ma_base_style', plugin_dir_url( __FILE__ ).'admin/css/common.css' );
    wp_enqueue_script( 'ma_base_script',plugin_dir_url( __FILE__ ).'admin/js/common.js' );
}
add_action( 'get_attached_media', 'test' );
function test(){
    wp_enqueue_script( 'ma_base_script',plugin_dir_url( __FILE__ ).'admin/js/common.js' );
}

//--- CHECK PLUGIN UPDATES ---
$plugin_dir  = plugin_dir_path( __FILE__ );
$update_path = $plugin_dir.'admin/plugins/plugin-update-checker.php';
require $update_path;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://www.minimaladmin.online/wp-content/plugin.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'minimal-admin'
);
    


// Check if exist files for the different plugin parts
// and attach the CSS files & JS scripts
add_action( 'admin_print_scripts', 'check_files', 1 );
function check_files() {
    $plugin_dir  = plugin_dir_path( __FILE__ );
    $login       = $plugin_dir.'admin/login/css/login.css';
    $notice      = $plugin_dir.'admin/notice/css/notice.css';
    $dashboard   = $plugin_dir.'admin/dashboard/css/dashboard.css';
    $menu        = $plugin_dir.'admin/menu/css/menu.css';
    $sumo_select = $plugin_dir.'admin/css/sumoselect.css';
    $ma_settings = $plugin_dir.'admin/settings/css/ma_settings.css';
    $tables      = $plugin_dir.'admin/tables/css/tables.css';
    $themes      = $plugin_dir.'admin/themes/css/themes.css';
    $plugins     = $plugin_dir.'admin/plugins/css/plugins.css';
    $users       = $plugin_dir.'admin/users/css/users.css';
    $auth_check  = $plugin_dir.'admin/wpauthcheck/css/wpauthcheck.css';
    

    if (file_exists($login)) {
        wp_enqueue_style( 'ma_login', plugin_dir_url( __FILE__ ).'admin/login/css/login.css' );
    }
    if (file_exists($notice)) {
        wp_enqueue_style( 'ma_notice', plugin_dir_url( __FILE__ ).'admin/notice/css/notice.css' );
    }
    if (file_exists($dashboard)) {
        wp_enqueue_style( 'ma_dashboard', plugin_dir_url( __FILE__ ).'admin/dashboard/css/dashboard.css' );
    }
    if (file_exists($menu)) {
        wp_enqueue_style( 'ma_menu', plugin_dir_url( __FILE__ ).'admin/menu/css/menu.css' );
        wp_enqueue_script( 'ma_menu',plugin_dir_url( __FILE__ ).'admin/menu/js/menu.js' );
    }
    if (file_exists($sumo_select)) {
        wp_enqueue_style( 'sumo_select', plugin_dir_url( __FILE__ ).'admin/css/sumoselect.css' );
        wp_enqueue_script( 'sumo_select',plugin_dir_url( __FILE__ ).'admin/js/jquery.sumoselect.min.js' );
    }
    if (file_exists($ma_settings)) {
        wp_enqueue_style( 'ma_settings', plugin_dir_url( __FILE__ ).'admin/settings/css/ma_settings.css' );
    }
    if (file_exists($themes)) {
        wp_enqueue_style( 'ma_themes', plugin_dir_url( __FILE__ ).'admin/themes/css/themes.css' );
    }
    if (file_exists($tables)) {
        wp_enqueue_style( 'ma_tables', plugin_dir_url( __FILE__ ).'admin/tables/css/tables.css' );
    }
    if (file_exists($plugins)) {
        wp_enqueue_style( 'ma_plugins', plugin_dir_url( __FILE__ ).'admin/plugins/css/plugins.css' );
    }
    if (file_exists($users)) {
        wp_enqueue_style( 'ma_users', plugin_dir_url( __FILE__ ).'admin/users/css/users.css' );
    }
    if (file_exists($auth_check)) {
        wp_enqueue_style( 'ma_wp_auth_check', plugin_dir_url( __FILE__ ).'admin/wpauthcheck/css/wpauthcheck.css' );
    }
    
}

include plugin_dir_path( __FILE__ ).'admin/menu/menu.php';

//--- ADD OPTION TO MENU ---
function add_test_theme_page() {
	add_theme_page( 'Minimal Admin', 'Minimal Admin', 'edit_theme_options', 'minimal-admin-settings', 'plugin_settings_page', 0 );
}
add_action( 'admin_menu', 'add_test_theme_page' );

function plugin_settings_page() {
    include plugin_dir_path( __FILE__ ).'admin/settings/settings.php';
}

//--- ADD SETTINGS LINKS TO PLUGIN IN PLUGINS LIST ---
function ma_settings_link ( $links ) {
    $settings_link = array( 'settings' => '<a href="' . admin_url('admin.php?page=minimal-admin-settings' ) . '">' . __('Settings', 'minimal-admin') . '</a>');
    return array_merge( $links, $settings_link );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ma_settings_link' );



?>