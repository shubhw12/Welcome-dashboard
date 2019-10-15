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
 * Main loader file.
 *
 * @since  1.0.0
 * @return void
 */
use Elementor\Core\Documents_Manager;
use Elementor\TemplateLibrary\Source_Local;

if ( ! class_exists( 'WD_Loader' ) ) :
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
	class WD_Loader {

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
			add_action( 'admin_init', array( $this, 'wd_display_panel' ) );
			add_action( 'wp_dashboard_setup', array( $this, 'wd_remove_all_dashboard_meta_boxes' ), 9999 );
			add_action( 'elementor/init', array( $this, 'wd_saved_template' ) );
			add_action( 'elementor/template-library/create_new_dialog_fields', array( $this, 'wd_custom_feilds' ) );
		}

		/**
		 * Register and localize the scripts.
		 *
		 * @since 1.0.0
		 */
		public function wd_plugin_scripts() {
			$wd_role = $this->wd_get_current_user_role();
			if ( is_multisite() ) {
				// used when we are dealing with multisite setup.
				$site_id = get_current_blog_id();
				$wd_post = get_blog_option( 1, 'wd_settings_data' );
				if ( isset( $wd_post['wd_hide_settings'] ) ) {
					$wd_post = get_blog_option( 1, 'wd_settings_data' );
				} else {
					$wd_post = get_blog_option( $site_id, 'wd_settings_data' );
				}
			} else {
					$wd_post = get_option( 'wd_settings_data' );
			}

			wp_register_style( 'wd_css', WD_PLUGIN_URL . '/assets/css/wd-css.css', null, SCRIPTS_VERSION, false );
			wp_register_script( 'wd_js', WD_PLUGIN_URL . '/assets/js/wd-js.js', null, SCRIPTS_VERSION, false );
			wp_localize_script(
				'wd_js',
				'template',
				array(
					'user_role'   => $wd_role,
					'wd_settings' => $wd_post,
				)
			);
		}

		/**
		 * Function for checking the hide from subsite settings and change the settings data accordingly.
		 *
		 * Change the settings data if the side from subsite settings is active.
		 *
		 * @since 1.0.0
		 */
		public function wd_settings_data() {
			if ( is_multisite() ) {
				$site_id = get_current_blog_id();
				$wd_post = get_blog_option( 1, 'wd_settings_data' );
				if ( isset( $wd_post['wd_hide_settings'] ) ) {
					$wd_post = get_blog_option( 1, 'wd_settings_data' );
				} else {
					$wd_post = get_blog_option( $site_id, 'wd_settings_data' );
				}
			} else {
				$wd_post = get_option( 'wd_settings_data' );
			}

			return $wd_post;

		}

		/**
		 * Function for getting template information
		 *
		 * Gets an wp object array containing the information about the templates created using elementor.
		 *
		 * @since 1.0.0
		 */
		public function wd_get_templates() {
			$args      = array(
				'post_type'      => 'elementor_library',
				'type'           => 'Dashboard',
				'posts_per_page' => '-1',
				'post_status'    => 'publish',
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
		 * Display our plugin settings page
		 *
		 * Adds our plugin setting page in the settings.
		 *
		 * @since 1.0.0
		 */
		public function wd_settings_page() {
			if ( is_multisite() ) {
				$wd_post = get_blog_option( 1, 'wd_settings_data' );
				$toggle  = isset( $wd_post['wd_hide_settings'] ) ? $wd_post['wd_hide_settings'] : 'no';
				if ( 1 === get_current_blog_id() ) {
					add_submenu_page(
						'options-general.php',
						'Welcome Dashboard',
						'Welcome Dashboard',
						'manage_options',
						'wd',
						array( $this, 'wd_page_html' )
					);
				}
				if ( 'no' === $toggle && 1 !== get_current_blog_id() ) {
					add_submenu_page(
						'options-general.php',
						'Welcome Dashboard',
						'Welcome Dashboard',
						'manage_options',
						'wd',
						array( $this, 'wd_page_html' )
					);
				}
			} else {
				add_submenu_page(
					'options-general.php',
					'Welcome Dashboard',
					'Welcome Dashboard',
					'manage_options',
					'wd',
					array( $this, 'wd_page_html' )
				);
			}
		}

		/**
		 * Function for saving user data from settings page
		 *
		 * Get user roles like administrator or editor , author etc.
		 *
		 * @since 1.0.0
		 */
		public function wd_save_setting_data() {
			if ( ! empty( $_POST['wd-form'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wd-form'] ) ), 'wd-form-nonce' ) ) {
				update_option( 'wd_settings_data', $_POST );
			}
		}
		/**
		 * Function for fetching user roles
		 *
		 * Get user roles like administrator or editor , author etc.
		 *
		 * @since 1.0.0
		 */
		public function wd_get_current_user_role() {
			$user       = wp_get_current_user();
			$user_roles = $user->roles;
			$wd_role    = ucfirst( $user_roles[0] );
			return $wd_role;
		}

		/**
		 * Function rendering the templates from elementor
		 *
		 * Render the templates from elementor using this function
		 *
		 * @since 1.0.0
		 */
		public function wd_render_template() {
			// check if multisite then fetch option valies respective to that particular site else directlu use get option.
			$wd_post = $this->wd_settings_data();
			$wd_role = $this->wd_get_current_user_role();
			for ( $i = 0; $i < 2; $i++ ) {
				$elementor = Elementor\Plugin::$instance;
				$elementor->frontend->register_styles();
				$elementor->frontend->enqueue_styles();
				$elementor->frontend->register_scripts();
				$elementor->frontend->enqueue_scripts();
			}

			if ( is_multisite() ) {
				// in case we hide the settings from other sub sites then we need to do changes in this block of if.
				if ( isset( $wd_post['wd_hide_settings'] ) && 'yes' === $wd_post['wd_hide_settings'] ) {
					switch_to_blog( 1 );
					echo $elementor->frontend->get_builder_content_for_display( $wd_post[ $wd_role ]['template-id'], true );
					restore_current_blog();
				} else {
					echo $elementor->frontend->get_builder_content_for_display( $wd_post[ $wd_role ]['template-id'], true );
				}
			} else {
				echo $elementor->frontend->get_builder_content_for_display( $wd_post[ $wd_role ]['template-id'], true );
			}
		}

		/**
		 * Clear dashboard widgets
		 *
		 * This function empty the array of widgets shown on dashboard thus clearing it.
		 *
		 * @since 1.0.0
		 */
		public function wd_remove_all_dashboard_meta_boxes() {
			$wd_post = $this->wd_settings_data();
			$wd_role = $this->wd_get_current_user_role();
			if ( isset( $wd_post[ $wd_role ]['clear-dasboard'] ) ) {

				global $wp_meta_boxes;
				$wp_meta_boxes['dashboard']['normal']['core'] = array();
				$wp_meta_boxes['dashboard']['side']['core']   = array();
			} else {
				return;
			}
		}
		/**
		 * Function responsible for displaying the template on dashboard
		 *
		 * Check current user and display particular template for him and clear dashboard according to settings saved.
		 *
		 * @since 1.0.0
		 */
		public function wd_display_panel() {
			global $current_screen;
			$wd_post = $this->wd_settings_data();
			$wd_role = $this->wd_get_current_user_role();
			if ( '---select---' !== $wd_post[ $wd_role ]['template-id'] ) {
				if ( ! current_user_can( 'edit_theme_options' ) ) {
					add_action( 'admin_notices', array( $this, 'wd_welcome_panel' ) );
				}
				remove_action( 'welcome_panel', 'wp_welcome_panel' );
				add_action( 'welcome_panel', array( $this, 'wd_welcome_panel' ) );
			}
		}

		/**
		 * Function which includes the welcome panel html
		 *
		 * @since 1.0.0
		 */
		public function wd_welcome_panel() {
			$ppc_screen = get_current_screen();
			if ( 'my-sites' !== $ppc_screen->base ) {
				require_once WD_ABSPATH . 'includes/wd-welcome-panel.php';
			} else {
				return;
			}
		}
		/**
		 * Fuction for adding custom template type
		 *
		 * Display our custom document type and register template type in saved template settings of the elementor.
		 *
		 * @since 1.0.0
		 */
		public function wd_saved_template() {

			require_once WD_ABSPATH . 'includes/wd-init.php';

		}
		/**
		 * Display custom input feild in the add new
		 *
		 * Fetch and display current user roles in the add new of the custom template type of dashboard.
		 *
		 * @since 1.0.0
		 */
		public function wd_custom_feilds() {

			$all_roles = $this->wd_get_roles();
			?>
			<br>
			<div id="elementor-new-template__form__template-type__wrapper" class="elementor-form-field">
				<label for="elementor-new-template__form__template-type" class="elementor-form-field__label"><?php echo esc_html_e( 'Select the user role you want to display this dashboard for', 'welcome-dashboard' ); ?></label>
				<select id="elementor-new-template__form__template-type" class="elementor-form-field__select" name="wd_user_role" required>
					<option>---select---</option>
					<?php foreach ( $all_roles as $roles ) { ?>
								<option name = <?php echo esc_attr( $roles ); ?> value = 
														<?php
														if ( isset( $template ) ) {
															echo esc_attr( $template->ID );}
														?>
								<?php
								if ( ! empty( $wd_post ) ) {
										selected( true, in_array( $template->ID, $wd_post[ $roles ], true ) );
								}
								?>
								> 
								<?php
								echo esc_attr( $roles );
								?>
								</option>
							<?php } ?>
				</select>
			</div>
			<?php

		}

		/**
		 * Settings page
		 *
		 * All the tabs are managed in the file which is included.
		 *
		 * @since 1.0.0
		 */
		public function wd_page_html() {
			require_once WD_ABSPATH . 'includes/wd-settings-page.php';
		}
	}WD_Loader::get_instance();


endif;
