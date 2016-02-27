<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php
/**
 * @package PADMA Wordpress Plugin
 * @version 0.1
 */
 
/*
Plugin Name: PADMA Wordpress Plugin
Plugin URI: http://github.com/dwaynemac/padma-wordpress-plugin
Description: Make forms forward fields to PADMA CRM.
Author: Dwayne Macgowan
Version: 0.1
AuthorURI: http://github.com/dwaynemac
*/

define( 'PADMA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( PADMA_PLUGIN_DIR . 'includes/activation-deactivation.php' );
require_once( PADMA_PLUGIN_DIR . 'includes/options-page.php' );
require_once( PADMA_PLUGIN_DIR . 'includes/post-to-padma.php' );
require_once( PADMA_PLUGIN_DIR . 'includes/hook-into-thriveleads.php' );
require_once( PADMA_PLUGIN_DIR . 'includes/hook-into-contactform7.php' );

?>