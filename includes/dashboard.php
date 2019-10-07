<?php
namespace Elementor\Modules\Library\Documents;
use Elementor\Modules\Library\Documents\Library_Document;

;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor section library document.
 *
 * Elementor section library document handler class is responsible for
 * handling a document of a section type.
 *
 * @since 2.0.0
 */
class dashboard extends Library_Document {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['admin_tab_group'] = 'library';
		$properties['show_in_library'] = true;
		$properties['register_type'] = true;

		return $properties;
	}

	public function get_name() {
		return 'Dashboard';
	}

	public static function get_title() {
		return __( 'Dashboard', 'welcome-dashboard' );
	}


}
