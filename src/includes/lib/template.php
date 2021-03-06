<?php

/**
 * Papi template functions.
 *
 * @package Papi
 * @since 1.0.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Add page type class name as a css class on body.
 *
 * @param array $classes
 *
 * @since 1.0.0
 *
 * @return array
 */

function papi_body_class( $classes ) {
	global $post;

	// Check so we only change template on single and page posts.
	if ( ! is_single() && ! is_page() ) {
		return $classes;
	}

	$page_type = get_post_meta( $post->ID, PAPI_PAGE_TYPE_KEY, true );

	if ( empty( $page_type ) ) {
		return $classes;
	}

	$parts = explode( '/', $page_type );

	if ( empty( $parts ) || empty( $parts[0] ) ) {
		return $classes;
	}

	$classes[] = array_pop( $parts );

	return $classes;
}

add_filter( 'body_class', 'papi_body_class' );

/**
 * Include partial view.
 *
 * @param string $tpl_file
 * @param array $vars
 *
 * @since 1.0.0
 */

function papi_include_template( $tpl_file, $vars = array() ) {
	if ( ! is_string( $tpl_file ) ) {
		return;
	}

	$path = PAPI_PLUGIN_DIR;
	$path = rtrim( $path, '/' ) . '/';

	include $path . $tpl_file;
}

/**
 * Load a template array file and merge values with it.
 *
 * @param string $file
 * @param array $values
 * @param bool $convert_to_object
 *
 * @since 1.0.0
 *
 * @return array
 */

function papi_template( $file, $values = array(), $convert_to_object = false ) {
	if ( ! is_string( $file ) ) {
		return array();
	}

	$filepath = papi_get_file_path( $file );

	if ( empty( $filepath ) && is_file( $file ) ) {
		$filepath = $file;
	}

	if ( empty( $filepath ) ) {
		return array();
	}

	$template = require $filepath;

	$result = array_merge( (array) $template, $values );

	if ( $convert_to_object ) {
		return (object) $result;
	}

	return $result;
}

/**
 * Include template files from Papis custom page template meta field.
 *
 * @param string $original_template
 *
 * @since 1.0.0
 *
 * @return string
 */

function papi_template_include( $original_template ) {
	global $post;

	// Check so we only change template on single and page posts.
	if ( ! is_single() && ! is_page() ) {
		return $original_template;
	}

	$page_template = papi_get_page_type_template( $post->ID );

	if ( ! empty( $page_template ) ) {
		$path = get_template_directory();
		$path = trailingslashit( $path );
		$file = $path . $page_template;

		if ( file_exists( $file ) && ! is_dir( $file ) ) {
			return $file;
		}
	}

	return $original_template;
}

add_filter( 'template_include', 'papi_template_include' );
