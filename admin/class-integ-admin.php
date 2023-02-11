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
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version, $client ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->client      = $client;
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

	/*
	|--------------------------------------------------------------------------
	| Token Input Field
	|--------------------------------------------------------------------------
	|
	| This function adds a text input on the woocommerce settings page,
	| the input is used to place the user api TOKEN.
	|
	*/
	public function add_token_input( $settings ) {
		$updated_settings = [];

		foreach ( $settings as $section ) {
			if (
				isset( $section['id'] ) && 'general_options' == $section['id'] &&
				isset( $section['type'] ) && 'sectionend' == $section['type']
			) {
				$updated_settings[] = [
					'name'     => __( 'Token para integ.app', 'wc_seq_order_numbers' ),
					'desc_tip' => __( 'Token de requisição encontrado no painel de controle (pagina de perfil)', 'wc_seq_order_numbers' ),
					'id'       => $this->plugin_name,
					'type'     => 'password',
					'css'      => 'min-width:300px;',
					'std'      => '',  // WC < 2.0
					'default'  => '',  // WC >= 2.0
					'desc'     => __( 'Exemplo: b4e58140b61cf086c82153f6c371668684f6ca71' ),
				];
			}

			$updated_settings[] = $section;
		}

		return $updated_settings;
	}

	/*
	|--------------------------------------------------------------------------
	| Sync product attributes and categories
	|--------------------------------------------------------------------------
	|
	| This function hooks into the action of saving the request token,
	| it's mainly used to sync the product attributes and
	| categories of products, to avoid extra work
	| on our API we'll send all product and
	| categories so we can map it latter.
	|
	*/
	public function sync_attributes() {
		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'orderby'    => 'name',
				'hide_empty' => false,
			)
		);

		$categories = wp_list_pluck( $categories, 'name' );
		$attributes = wp_list_pluck( array_values( wc_get_attribute_taxonomies() ), 'attribute_name' );

		$this->client->categories()->upsert( $categories );
		$this->client->attributes()->upsert( $attributes );
	}

	/*
	|--------------------------------------------------------------------------
	| Manage product status lifecycle
	|--------------------------------------------------------------------------
	|
	| Woocommerce has a lot of hooks to manage product that doesn't work
	| the workaround to solve this issue is to manage product status
	| on every status update.
	|
	*/
	public function product_lifecycle_handler( $new_status, $old_status, $post ) {
		if ( empty( get_option( $this->plugin_name ) ) ) {
			error_log( "[integ.app] token not configured." );

			return null;
		}

		/**
		 * This status means that the product
		 * is not ready to be sold yet.
		 */
		$isNotProduct  = $post->post_type !== 'product';
		$invalidStatus = [ 'auto-draft', 'importing' ];
		if ( $isNotProduct || in_array( $new_status, $invalidStatus ) ) {
			return null;
		}

		/**
		 * These status are used to disable the product on the
		 * store catalog, we will send a request to disable
		 * the product as well.
		 */
		$disabledStatus = [ 'trash', 'draft', 'pending' ];
		if ( in_array( $new_status, $disabledStatus ) ) {
			$this->on_product_delete( $post );

			return null;
		}
	}

	/**
	 * @param $product_id string
	 *
	 * @return void
	 */
	public function on_product_delete( $product_id ) {
		$product = wc_get_product( $product_id );
		$this->client->products()->delete( $product->get_sku() );
	}

	/**
	 * @param $post WP_POST
	 *
	 * @return void
	 */
	public function on_product_update( $productID ) {
		$product = wc_get_product( $productID );
		$this->client->products()->update( $product->get_sku(), $product->get_data() );
	}

	/**
	 * @param $post WP_POST
	 *
	 * @return void
	 */
	public function on_product_create( $post ) {
		$product = wc_get_product( $post->ID );
		$this->client->products()->create( $product->get_data() );
	}

	/**
	 * @param string $order_id
	 * @param string $old_status
	 * @param string $new_status
	 *
	 * @return void
	 */
	public function on_order_update( $order_id, $old_status, $new_status ) {
		$this->client->orders()->update( $order_id, [
			'order_id'        => $order_id,
			'status'          => $new_status,
			'previous_status' => $old_status
		] );
	}
}
