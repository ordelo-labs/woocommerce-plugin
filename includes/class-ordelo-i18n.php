<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       ordelo.app
 * @since      1.0.0
 *
 * @package    Ordelo
 * @subpackage Ordelo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ordelo
 * @subpackage Ordelo/includes
 * @author     Ordelo <contato@ordelo.com.br>
 */
class Ordelo_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'integ',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);

	}
}
