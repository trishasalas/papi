<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Unit tests covering property radio.
 *
 * @package Papi
 */

class Papi_Property_Radio_Test extends WP_UnitTestCase {

	/**
	 * Setup the test and.
	 *
	 * @since 1.0.0
	 */

	public function setUp() {
		parent::setUp();

		$_POST = array();

		$this->post_id = $this->factory->post->create();

		$this->property = papi_property( array(
			'type'     => 'radio',
			'title'    => 'Color',
			'slug'     => 'color',
			'settings' => array(
				'items' => array(
					'White' => '#ffffff',
					'Black' => '#000000'
				)
			)
		) );
	}

	/**
	 * Tear down test.
	 *
	 * @since 1.3.0
	 */

	public function tearDown() {
		parent::tearDown();
		$_POST = array();
		unset( $this->post_id, $this->property );
	}

	/**
	 * Test output to check if property slug exists and the property type value.
	 *
	 * @since 1.3.0
	 */

	public function test_output() {
		papi_render_property( $this->property );
		$this->expectOutputRegex( '/name=\"' . papi_get_property_type_key( $this->property->slug ) . '\"' );
		$this->expectOutputRegex( '/value=\"radio\"/' );
	}

	/**
	 * Test property options.
	 *
	 * @since 1.0.0
	 */

	public function test_property_options() {
		$this->assertEquals( 'radio', $this->property->type );
		$this->assertEquals( 'papi_color', $this->property->slug );
		$this->assertFalse( empty( $this->property->settings->items ) );
	}

	/**
	 * Test save property value.
	 *
	 * @since 1.0.0
	 */

	public function test_save_property_value() {
		$handler = new Papi_Admin_Meta_Boxes();

		// Create post data.
		$_POST = papi_test_create_property_post_data( array(
			'slug'  => $this->property->slug,
			'type'  => $this->property->type,
			'value' => '#ffffff'
		), $_POST );

		$handler->save_property( $this->post_id );

		$expected = '#ffffff';
		$actual = papi_field( $this->post_id, $this->property->slug );

		$this->assertEquals( $expected, $actual );
	}

}
