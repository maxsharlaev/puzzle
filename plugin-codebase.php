<?php

namespace PuzzleCodebase;

 /**
 * Plugin Name: Puzzle Codebase
 * Author: Mechanical Pie Apps
 * Version: 0.1
 * Text Domain: puzzle-codebase
 */

use PuzzleCodebase\Puzzle\Application;

require_once('app/autoload.php');

Application::get_instance();

register_activation_hook( __FILE__, [Application::get_instance(), 'pluginActivated']);
register_deactivation_hook( __FILE__, [Application::get_instance(), 'pluginDeactivated']);
