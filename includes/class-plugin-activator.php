<?php
/**
 * Plugin activator.
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

use DEFAULT_TECHNICAL_CONTACT;

/**
 * Plugin activator.
 *
 * @package PRC\Platform\Node_System
 */
class Plugin_Activator {
	/**
	 * Activate the plugin.
	 */
	public static function activate() {
		flush_rewrite_rules();

		wp_mail(
			DEFAULT_TECHNICAL_CONTACT,
			'PRC Node System Activated',
			'The PRC Node System plugin has been activated on ' . get_site_url()
		);
	}
}
