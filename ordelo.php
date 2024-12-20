<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              ordelo.app
 * @since             1.0.0
 * @package           Ordelo
 *
 * @wordpress-plugin
 * Plugin Name:       Ordelo
 * Plugin URI:        ordelo.com.br
 * Description:       Sincronize seus produtos e pedidos automaticamente com o Mercado Livre
 * Version:           1.0.0
 * Author:            Ordelo
 * Author URI:        ordelo.app
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ordelo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ORDELO_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-integ-activator.php
 */
function activate_integ()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ordelo-activator.php';
	Ordelo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-integ-deactivator.php
 */
function deactivate_integ()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ordelo-deactivator.php';
	Ordelo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_integ');
register_deactivation_hook(__FILE__, 'deactivate_integ');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ordelo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_integ()
{

	$plugin = new Ordelo();
	$plugin->run();

}

run_integ();
