<?php

/**
 * Papi options functions.
 *
 * @package Papi
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Papi options.
 *
 * @since 1.0.0
 *
 * @return string
 */

function _papi_get_options() {
	$options = array(

		// Page types options

		/**
		* What sort should we use?
		* - 'name'
		* - 'sort_order'.
		*/

		'page_types.sort_by' => 'name',

		// Post types options

		/**
		* Show the standard page or not.
		* On post and page it's true by default
		*
		* Adding another post type is easy,
		* just copy page or post and replace the
		* page or post key with your post type name in lower cases.
		*/

		'post_type.page.show_standard_page' => true,
		'post_type.post.show_standard_page' => true
	);

	return apply_filters( 'papi/options', $options );
}

/**
 * Get setting value from Papi options.
 *
 * @param string $key
 * @param mixed $default The default value
 */

function _papi_get_option( $key, $default = '' ) {
	$settings = _papi_get_options();

	if ( isset( $settings[$key] ) ) {
		return $settings[$key];
	}

	return $default;
}
