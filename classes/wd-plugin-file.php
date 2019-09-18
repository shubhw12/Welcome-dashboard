<?php
/**
 * Welcome Dashboard page setups
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Welcome Dashboard
 * @author   Display Name <username@BrainstormForce.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

/*
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */

if ( ! class_exists( 'WD_Pagesetups' ) ) :
	/**
	 * Welcome Dashboard Loader Doc 
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Welcome Dashboard
	 * @author   Display Name <username@BrainstormForce.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
	class WD_Pagesetups {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wd_settings_page' ) );
		}

		/**
		 * Function for adding settings page in admin area
		 *
		 * Displays our plugin settings page in the WordPress
		 *
		 * @since 1.0.0
		 */
		public function wd_settings_page() {
			add_submenu_page(
				'options-general.php',
				'Welcome Dashboard',
				'Welcome Dashboard',
				'manage_options',
				'wd',
				array( $this, 'wd_page_html' )
			);
		}
		/**
		 * Tabs function
		 *
		 * All the tabs are managed in the file which is included.
		 *
		 * @since 1.0.0
		 */
		public function wd_page_html() {
			require_once WD_ABSPATH . 'includes/wd-settings-page.php';
		}
	}WD_Pagesetups::get_instance();
endif;
