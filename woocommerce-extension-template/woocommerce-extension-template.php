<?php
/**
 * Plugin Name: WooCommerce Extension Template
 * Plugin URI: https://woocommerce.com/products/woocommerce-extension-template
 * Description: This is an example of an extension template to follow.
 * Version: 1.0.0
 * Author: WooCommerce
 * Author URI: https://woocommerce.com
 * Text Domain: woocommerce-extension-template
 * Domain Path: /languages
 * Tested up to: 5.4
 * WC tested up to: 4.0
 * WC requires at least: 3.0
 *
 * Copyright: © 2020 WooCommerce.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package woocommerce-extension-template
 *
 * Woo: xxxxxx:xxxxxxxxxxxxxxxxxxxxxxx
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 1.0.0
 */
function woocommerce_extension_template_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'WooCommerce Extension Template requires WooCommerce to be installed and active. You can download %s here.', 'woocommerce-extension-template' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

/*
 * We're registering this outside of the class as from
 * past experience, in some cases, activation does not fire.
 */
register_activation_hook( __FILE__, 'woocommerce_extension_template_activate' );

/**
 * Performs activation steps.
 *
 * @since 1.0.0
 */
function woocommerce_extension_template_activate() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'woocommerce_extension_template_missing_wc_notice' );
		return;
	}

	/*
	 * You may want to add additional information here
	 * to point users in the right direction after
	 * activation.
	 */
	$notice_html = '<strong>' . esc_html__( 'WooCommerce Extension Template has been activated!', 'woocommerce-extension-template' ) . '</strong><br><br>';

	WC_Admin_Notices::add_custom_notice( 'woocommerce_extension_template_activation', $notice_html );

	/*
	 * Do any additional activation steps here such
	 * as adding necessary endpoints and doing a flush.
	 */
}

if ( ! class_exists( 'WooCommerce_Extension_Template' ) ) :
	/*
	 * Declare all your defines here in one place.
	 * This is our preference to define essential constants
	 * globally. So that it can be accessed througout the
	 * extension without having to call the main class
	 * which can get really long.
	 */
	define( 'WC_EXTENSION_TEMPLATE_VERSION', '1.0.0' ); // WRCS: DEFINED_VERSION.
	define( 'WC_EXTENSION_TEMPLATE_DB_VERSION', '1.0.0' );
	define( 'WC_EXTENSION_TEMPLATE_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
	define( 'WC_EXTENSION_TEMPLATE_MAIN_FILE', __FILE__ );
	define( 'WC_EXTENSION_TEMPLATE_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

	/**
	 * WC Extension Template Main class.
	 * This is a "singleton" class but is not
	 * required if you want to use your own method.
	 *
	 * @since 1.0.0
	 */
	class WooCommerce_Extension_Template {
		/**
		 * The single instance of the class.
		 *
		 * @var $instance
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->includes();
			register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		}

		/**
		 * Main WooCommerce Extension Template Instance.
		 *
		 * Ensures only one instance of WooCommerce Extension Template is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @return WooCommerce_Extension_Template
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woocommerce-extension-template' ), WC_EXTENSION_TEMPLATE_VERSION );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'woocommerce-extension-template' ), WC_EXTENSION_TEMPLATE_VERSION );
		}

		/**
		 * Cleanup on plugin deactivation.
		 *
		 * @since 1.0.0
		 */
		public function deactivate() {
			WC_Admin_Notices::remove_notice( 'woocommerce_extension_template_activation' );
		}

		/**
		 * Load all necessary dependencies.
		 *
		 * @since 1.0.0
		 */
		public function includes() {
			// Admin specific dependencies.
			if ( is_admin() ) {
				require_once WC_EXTENSION_TEMPLATE_PLUGIN_PATH . '/includes/admin/class-wc-extension-template-privacy.php';
				require_once WC_EXTENSION_TEMPLATE_PLUGIN_PATH . '/includes/admin/class-wc-extension-template-admin.php';
			} else {
				require_once WC_EXTENSION_TEMPLATE_PLUGIN_PATH . '/includes/class-wc-extension-template-frontend.php';
			}
		}
	}
endif;

/*
 * We always want to load our extension when
 * plugins_loaded action is triggered.
 */
add_action( 'plugins_loaded', 'woocommerce_extension_template_init', 10 );

/**
 * Returns the class instance when plugins are
 * loaded.
 *
 * @since 1.0.0
 */
function woocommerce_extension_template_init() {
	load_plugin_textdomain( 'woocommerce-extension-template', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'woocommerce_extension_template_missing_wc_notice' );
		return;
	}

	WooCommerce_extension_template::instance();
}
