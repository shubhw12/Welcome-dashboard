<?php
/**
 * Register document type in elementor
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Welcome Dashboard
 * @author   Display Name <username@BrainstormForce.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 *
 * @since  1.0.0
 * @return void
 */

namespace Elementor\Modules\Library\Documents;

use Elementor\TemplateLibrary\Source_Local;
use Elementor\Core\Base\Module;
use Elementor\Modules\Library\Documents\Dashboard;
use Elementor\Plugin;

require_once WD_ABSPATH . 'includes/class-dashboard.php';

Plugin::$instance->documents->register_document_type( 'Dashboard', dashboard::get_class_full_name() );
Source_Local::add_template_type( 'Dashboard' );
