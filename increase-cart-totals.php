<?php

/**
	Plugin Name: Increase Cart Totals
	Description: Increase cart totals 
	Author: Cesar Damascena
	Version: 0.0.1
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
 
! defined( 'ICT_INIT' )                && define( 'ICT_INIT', plugin_basename( __FILE__ ) );
! defined( 'ICT_FILE' )                && define( 'ICT_FILE', __FILE__ );
! defined( 'ICT_PATH' )                && define( 'ICT_PATH', plugin_dir_path( __FILE__ ) );
! defined( 'ICT_CLASS_PATH' )          && define( 'ICT_CLASS_PATH', ICT_PATH . 'includes/' );
! defined( 'ICT_URL' )                 && define( 'ICT_URL', plugins_url( '/', __FILE__ ) );
! defined( 'ICT_ASSETS_URL' )          && define( 'ICT_ASSETS_URL', ICT_URL . 'assets/' );
! defined( 'ICT_SCRIPT_URL' )          && define( 'ICT_SCRIPT_URL', ICT_ASSETS_URL . 'js/' );
! defined( 'ICT_STYLE_URL' )           && define( 'ICT_STYLE_URL', ICT_ASSETS_URL . 'css/' );
! defined( 'ICT_TEMPLATE_PATH' )       && define( 'ICT_TEMPLATE_PATH', ICT_PATH . 'templates/' );
! defined( 'ICT_TEMPLATE_URL' )        && define( 'ICT_TEMPLATE_URL', ICT_URL . 'templates/' );



function ict_init() {
	// Includes
	require ICT_CLASS_PATH . 'class.manage-cart-totals.php';

	// Init admin 
	require ICT_TEMPLATE_PATH . '/admin/product-panel-sub-tabs.php';	
}

add_action( 'init', 'ict_init', 10 );


function write_log ( $log ) {
  if ( is_array( $log ) || is_object( $log ) ) {
    error_log( print_r( $log, true ) );
  } else {
    error_log( $log );
  }
}
