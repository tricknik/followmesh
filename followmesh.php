<?php
/**
 * FollowMesh
 *
 * Distributed Social Media, Powered by WordPress
 *
 * @package FollowMesh
 * @author Dmytri Kleiner <dk@trick.ca>
 * @license GPL-2.0+
 * @link https://github.com/tricknik/followmesh
 * @copyright 2013 Automattic
 *
 * @wordpress-plugin
 * Plugin Name: FollowMesh
 * Plugin URI: https://github.com/tricknik/followmesh
 * Description: Distributed Social Media, Powered by WordPress
 * Version: 0.1.0
 * Author: Dmytri Kleiner
 * Author URI: http://dmytri.info
 * Text Domain: followmesh
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/tricknik/followmesh
 */

if ( ! defined( 'WPINC' ) )
	die;

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-followmesh-admin.php' );
	add_action( 'plugins_loaded', array( 'FollowMesh_Admin', 'get_instance' ) );
}

