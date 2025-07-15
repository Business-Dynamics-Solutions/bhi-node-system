<?php
/**
 * Plugin deactivator.
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

use DEFAULT_TECHNICAL_CONTACT;

/**
 * Plugin deactivator.
 *
 * @package PRC\Platform\Node_System
 */
class Plugin_Deactivator {
	/**
	 * Deactivate the plugin.
	 */
	public static function deactivate() {
		flush_rewrite_rules();

		wp_mail(
			DEFAULT_TECHNICAL_CONTACT,
			'PRC Node System Deactivated',
			'The PRC Node System plugin has been deactivated on ' . get_site_url()
		);
	}
}
