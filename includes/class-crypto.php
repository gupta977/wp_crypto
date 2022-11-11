<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Crypto
 * @subpackage Crypto/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Crypto
 * @subpackage Crypto/includes
 * @author     ODude <navneet@odude.com>
 */
class Crypto
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Crypto_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('CRYPTO_VERSION')) {
			$this->version = CRYPTO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'crypto';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Crypto_Loader. Orchestrates the hooks of the plugin.
	 * - Crypto_i18n. Defines internationalization functionality.
	 * - Crypto_Admin. Defines all hooks for the admin area.
	 * - Crypto_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-crypto-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-crypto-public.php';


		//Admin Dashboard classes
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/dashboard/class-crypto-dashboard-intro.php';

		/**
		 * Flexi setting class file
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-settings.php';


		//Include common functions
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/functions.php';

		//Load Ajax refresh
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto_connect_ajax_register.php';

		$enable_addon = crypto_get_option('enable_crypto_login', 'crypto_general_login', 'metamask');
		//if ("moralis" == $enable_addon) {
		//Connect Page

		//	} else if ("web3modal" == $enable_addon) {
		//Connect Page
		//require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-connect-web3modal.php';
		//} else {
		//Connect Page
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-connect-metamask.php';
		//	}

		//Crypto Price
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-price.php';

		//Access controls
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-access-domain.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-block.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-access-nft.php';

		//Widgets
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/login.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/donation/donation.php';

		//Connect Facebook
		//require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-facebook.php';

		//Crypto Domains URL redirect
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-domain-url.php';



		//Crypto Domains search
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-crypto-domain-search.php';

		$this->loader = new Crypto_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Crypto_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Crypto_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Crypto_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu');

		//Settings
		$settings = new crypto_Admin_Settings();
		$this->loader->add_action('admin_menu', $settings, 'admin_menu');
		$this->loader->add_action('admin_init', $settings, 'admin_init');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Crypto_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Crypto_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}