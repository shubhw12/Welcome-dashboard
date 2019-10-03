<?php

namespace Elementor\Modules\Library\Documents;

use Elementor\TemplateLibrary\Source_Local;
use Elementor\Core\Base\Module;
use Elementor\Modules\Library\Documents\dashboard;
use Elementor\Plugin;

require_once WD_ABSPATH . 'includes/dashboard.php';

Plugin::$instance->documents->register_document_type( 'Dashboard', dashboard::get_class_full_name() );	
Source_Local::add_template_type( 'Dashboard' );