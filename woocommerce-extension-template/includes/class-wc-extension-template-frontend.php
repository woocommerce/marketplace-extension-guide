<?php
/**
 * WC Extension Template Frontend Main class.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that handles frontend logic.
 *
 * @since 1.0.0
 */
class WC_Extension_Template_Frontend {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	/**
	 * Enqueues all necessary scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Styles.
		wp_register_style( 'wc_extension_template_styles', plugins_url( 'assets/css/frontend-styles.css', WC_EXTENSION_TEMPLATE_MAIN_FILE ), array(), WC_EXTENSION_TEMPLATE_VERSION );
		wp_enqueue_style( 'wc_extension_template_styles' );

		// Scripts.
		wp_register_script( 'woocommerce_extension_template_frontend', plugins_url( 'assets/js/frontend' . $suffix . '.js', WC_EXTENSION_TEMPLATE_MAIN_FILE ), array( 'jquery' ), WC_EXTENSION_TEMPLATE_VERSION, true );

		$localized_params = array(
			// Add your localized params here.
		);

		wp_localize_script( 'woocommerce_extension_template_frontend', 'wc_extension_template_params', apply_filters( 'wc_extension_template_localized_params', $localized_params ) );
	}
}
