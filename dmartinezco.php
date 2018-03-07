<?php
/*
Plugin Name: dmartinez.co
Plugin URI: https://dmartinez.co
Description: Provides several pieces of functionality that enable a React-based wordpress theme
Version: 0.1.0
Author: Dave Martinez
Author URI: http://dmartinez.co
Text Domain: dmartinezco
Domain Path: /dmartinezco
*/

/**
 * WP REST CORS
 */
include 'WP-REST-Allow-All-CORS-1.0.0/plugin.php';

/**
 * Add menus to REST API
 */

function get_menu ($req) {
  $menu = wp_get_nav_menu_object($req['id']);
  $menu->items = wp_get_nav_menu_items($req['id']);
  return $menu;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'dmco', '/menu/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_menu',
  ) );
} );


?>