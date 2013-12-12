<?php
/**
 * FollowMesh Admin
 *
 * @package		FollowMesh_Admin
 * @author		Dmytri Kleiner <dk@trick.ca>
 * @license		GPL-2.0+
 * @link			https://github.com/tricknik/followmesh
 * @copyright 2013 Automattic
 */

/**
 * @package FollowMesh_Admin
 * @author	Dmytri Kleiner <dk@trick.ca>
 */
class FollowMesh_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since		 0.1.0
	 * @var			 object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since			0.1.0
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'init', array( $this, 'create_post_type' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since			0.1.0
	 * @return		object		A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since		 0.1.0
	 */
	public function add_plugin_admin_menu() {
		add_menu_page(
			__( 'FollowMesh', 'followmesh' ),
			__( 'FollowMesh', 'followmesh' ),
			'publish_posts',
			'followmesh',
			 array( $this, 'display_feed' )
		);

		add_submenu_page(
			'followmesh',
			__( 'My Feed', 'followmesh' ),
			__( 'My Feed', 'followmesh' ),
			'publish_posts',
			'followmesh-feed',
			array( $this, 'display_feed' )
		);

		add_submenu_page(
			'followmesh',
			__( 'Following', 'followmesh' ),
			__( 'Following', 'followmesh' ),
			'publish_posts',
			'followmesh-following',
			array( $this, 'display_followings' )
		);

	}

	/**
	 * Render the followings page
	 *
	 * @since		 0.1.0
	 */
	public function display_followings() {
		if(!class_exists('FollowMesh_Followings_Table'))
			require_once( plugin_dir_path( __FILE__ ) . 'includes/class-followmesh-followings-table.php' );

		include_once( 'views/followings.php' );
	}

	/**
	 * Render the feed page
	 *
	 * @since		 0.1.0
	 */
	public function display_feed() {
		if(!class_exists('FollowMesh_Feed_Table'))
			require_once( plugin_dir_path( __FILE__ ) . 'includes/class-followmesh-feed-table.php' );

		include_once( 'views/feed.php' );
	}

	/**
	 * Register Update post type
	 *
	 * @since		 0.1.0
	 */
	public function create_post_type() {
		register_post_type( 'followmesh_update',
			array(
				'labels' => array(
					'name' => __( 'Updates' ),
					'menu_name' => __( 'Updates' ),
					'singular_name' => __( 'Update', 'followmesh' ),
					'add_new' => __( 'Post New Update' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array( 'slug' => 'updates', 'with_front' => true ),
				'show_in_menu' => 'followmesh'
			)
		);
	}

}
