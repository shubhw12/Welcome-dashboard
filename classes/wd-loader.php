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

if ( ! class_exists( 'WD_loader' ) ) :
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
	class WD_loader {

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
			add_action( 'admin_enqueue_scripts', array( $this, 'wd_plugin_scripts' ) );
		}

		public function ppc_plugin_backend_js() {
			wp_register_style( 'ppc_backend_css', WD_PLUGIN_URL . '/assets/css/ppc-css.css', null, PPC_VERSION, false );
		}

		/**
		 * Function for adding settings page in admin area
		 *
		 * Displays our plugin settings page in the WordPress
		 *
		 * @since 1.0.0
		 */

		public function wd_render_template()
		{
			$elementor = Elementor\Plugin::$instance;
			$elementor->frontend->register_styles();
			$elementor->frontend->enqueue_styles();
			echo $elementor->frontend->get_builder_content( 14 , true );	
			$elementor->frontend->register_scripts();
			$elementor->frontend->enqueue_scripts();
			
		}

		public function wd_get_templates(){

		$args = array(
            'post_type'         => 'elementor_library',
			'posts_per_page'    => '-1',
			'post_status'		=> 'publish'
		);

		$templates = get_posts( $args );
		return $templates;

		}


		public function wd_get_roles() {

			global $wp_roles;
			$roles = $wp_roles->get_names();
			return $roles;
		}


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
	}WD_loader::get_instance();
endif;
