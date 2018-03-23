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

function get_menu_locations($req) {
  $menu_locations = get_nav_menu_locations();
  $menu_obj = get_term( $menu_locations[ $req['id'] ], 'nav_menu');
  $menu_obj->items = wp_get_nav_menu_items($menu_obj->term_id);
  return $menu_obj;
}

function get_front_page($req) {
  $page_id = get_option( 'page_on_front' );
  $page_obj = get_post($page_id);
  return $page_obj;
}

add_action( 'rest_api_init', function () {
  register_rest_route('dmco', '/menu/location/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_menu_locations',
  ) );

  register_rest_route( 'dmco', '/menu/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_menu',
  ) );

  register_rest_route('dmco', '/front_page', array(
    'methods' => 'GET',
    'callback' => 'get_front_page',
  ));
} );

register_nav_menus( array(
	'dmco_primary_menu' => 'React Primary Menu',
) );

?>