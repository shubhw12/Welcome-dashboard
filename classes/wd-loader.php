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
			add_action( 'admin_init', array( $this, 'wd_save_setting_data' ) );
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
			add_action( 'welcome_panel', array( $this, 'wd_welcome_panel' ) );
		}

		public function wd_plugin_scripts() {
			wp_register_style( 'wd_css', WD_PLUGIN_URL . '/assets/css/wd-css.css', null, SCRIPTS_VERSION, false );
			wp_register_script('wd_js', WD_PLUGIN_URL. '/assets/js/wd-js.js', null , SCRIPTS_VERSION, false);
		}

		/**
		 * Function for getting template information
		 *
		 * Gets an wp object array containing the information about the templates created using elementor.
		 *
		 * @since 1.0.0
		 */
		public function wd_get_templates(){

		$args = array(
            'post_type'         => 'elementor_library',
			'posts_per_page'    => '-1',
			'post_status'		=> 'publish'
		);
		$templates = get_posts( $args );
		return $templates;

		}

		/**
		 * Function for fetching user roles
		 *
		 * Get user roles like administrator or editor , author etc.
		 *
		 * @since 1.0.0
		 */
		public function wd_get_roles() {
			global $wp_roles;
			$roles = $wp_roles->get_names();
			return $roles;
		}

		/**
		 * Function for fetching user roles
		 *
		 * Get user roles like administrator or editor , author etc.
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
		 * Function for fetching user roles
		 *
		 * Get user roles like administrator or editor , author etc.
		 *
		 * @since 1.0.0
		 */
		public function wd_save_setting_data() {
				if ( isset( $_POST['submit_radio'] ) ) {
					update_option('wd_settings_data',$_POST);
				}

				if ( ! current_user_can( 'edit_theme_options' ) ) {
					add_action( 'admin_notices', array( $this, 'wd_welcome_panel' ) );
				}
		}

		public function wd_get_current_user_role() {
			global $current_user;
			$user_roles = $current_user->roles;
			$user_role = array_shift($user_roles);
			return $user_role;
		}

		/**
		 * Function rendering the templates from elementor
		 *
		 * Render the templates from elementor using this function
		 *
		 * @since 1.0.0
		 */
		public function wd_render_template()
		{
			$wd_post = get_option('wd_settings_data');
			$wd_current_user_role = $this->wd_get_current_user_role();
			$wd_role = ucfirst($wd_current_user_role);
			for ($i=0; $i<2; $i++) {
				$elementor = Elementor\Plugin::$instance;
				$elementor->frontend->register_styles();
				$elementor->frontend->enqueue_styles();
				$elementor->frontend->register_scripts();
				$elementor->frontend->enqueue_scripts();
			}echo $elementor->frontend->get_builder_content_for_display( $wd_post[$wd_role] , true );
		}


		public function wd_welcome_panel(){
			require_once WD_ABSPATH . 'includes/wd-welcome-panel.php';
		}

		/**
		 * settings page 
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
