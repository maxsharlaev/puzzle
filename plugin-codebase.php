<?php namespace PuzzleCodebase;
 /**
 * Plugin Name: Puzzle Codebase
 * Author: Mechanical Pie Apps
 * Version: 0.1
 * Text Domain: puzzle-codebase
 */

use PuzzleCodebase\Framework\Controllers\Application;

require_once('app/autoload.php');

define(__NAMESPACE__.'_PLUGIN_DIR', __DIR__);
define(__NAMESPACE__.'_PLUGIN_URL', plugin_dir_url(__FILE__));

Application::inst();

register_activation_hook( __FILE__, [Application::inst(), 'pluginActivated']);
register_deactivation_hook( __FILE__, [Application::inst(), 'pluginDeactivated']);
