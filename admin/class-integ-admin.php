<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       integ.app
 * @since      1.0.0
 *
 * @package    Integ
 * @subpackage Integ/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Integ
 * @subpackage Integ/admin
 * @author     Integ <aciolyr@gmail.com>
 */
class Integ_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * The Client class to use Integ REST API
     *
     * @var Integ
     */
    private $client;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $client ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->client = $client;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Integ_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Integ_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/integ-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Integ_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Integ_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/integ-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * This function adds an input on the settings page,
     * the input is used to place the user api TOKEN.
     */
    public function add_token_configuration_start_settings($settings)
    {
        $updated_settings = [];

        foreach ($settings as $section) {
            if (
                isset($section['id']) && 'general_options' == $section['id'] &&
                isset($section['type']) && 'sectionend' == $section['type']
            ) {
                $updated_settings[] = [
                    'name'     => __('Token para integ.app', 'wc_seq_order_numbers'),
                    'desc_tip' => __('Token de requisição encontrado no painel de controle (pagina de perfil)', 'wc_seq_order_numbers'),
                    'id'       => $this->plugin_name,
                    'type'     => 'text',
                    'css'      => 'min-width:300px;',
                    'std'      => '',  // WC < 2.0
                    'default'  => '',  // WC >= 2.0
                    'desc'     => __('Exemplo: b4e58140b61cf086c82153f6c371668684f6ca71'),
                ];
            }

            $updated_settings[] = $section;
        }

        return $updated_settings;
	}

    /**
     * Hook for product update
     */
    public function on_product_update($product_id)
    {
        $product = wc_get_product($product_id);
        $this->client->products()->update($product->getSku(), $product);
	}

    /**
     * Hook for product creation
     */
    public function on_product_create($product_id)
    {
        $product = wc_get_product($product_id);
        $this->client->products()->create($product);
	}

    /**
     * Hook for product deletion
     */
    public function on_product_delete($product_id)
    {
        $product = wc_get_product($product_id);
        $this->client->products()->delete($product->getSku());
	}

    /**
     * Hook for order update
     *
     * @param $order_id string
     */
    public function on_order_update($order_id)
    {
        $order = wc_get_order($order_id);
        $this->client->orders()->update($order);
	}
}
