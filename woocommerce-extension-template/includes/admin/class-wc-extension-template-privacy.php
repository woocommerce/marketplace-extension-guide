<?php
/**
 * WC Extension Template Privacy main class.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that handles privacy (GDPR) logic.
 *
 * @since 1.0.0
 */
class WC_Extension_Template_Privacy extends WC_Abstract_Privacy {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct( __( 'WooCommerce Extension Template', 'woocommerce-extension-template' ) );
	}

	/**
	 * Gets the message of the privacy to display.
	 *
	 * @since 1.0.0
	 */
	public function get_privacy_message() {
		/* translators: %s - URL to document */
		return wpautop( sprintf( __( 'By using this extension, you may be storing personal data or sharing data with an external service. <a href="%s" target="_blank">Learn more about how this works, including what you may want to include in your privacy policy.</a>', 'woocommerce-extension-template' ), 'https://docs.woocommerce.com/document' ) );
	}
}

new WC_Extension_Template_Privacy();
