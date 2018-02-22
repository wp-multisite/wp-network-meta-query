<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Class WP_Network_Cache_Clear
 */
class WP_Network_Cache_Clear {
	function __construct() {
		add_action( 'add_site_option', array( $this, 'add_site_option' ), 10,3 );
		add_action( 'update_site_option', array( $this, 'update_site_option' ),  10, 4 );
		add_action( 'delete_site_option', array( $this, 'delete_site_option' ), 10, 2 );
		add_action( 'delete_site_meta', array( $this, 'delete_site_meta' ), 10,2 );
		add_action( 'add_site_meta', array( $this, 'add_site_meta' ), 10,1 );
		add_action( 'updated_site_meta', array( $this, 'updated_site_meta' ), 10,2 );
	}

	/**
	 * @param $option
	 * @param $value
	 * @param $network_id
	 */
	function add_site_option( $option, $value, $network_id ) {
		clean_network_cache( $network_id );
	}

	/**
	 * @param $option
	 * @param $value
	 * @param $old_value
	 * @param $network_id
	 */
	function update_site_option( $option, $value, $old_value, $network_id ) {
		clean_network_cache( $network_id );
	}

	/**
	 * @param $option
	 * @param $network_id
	 */
	function delete_site_option( $option, $network_id ) {
		clean_network_cache( $network_id );
	}

	/**
	 * @param $network_id
	 */
	function add_site_meta( $network_id ) {
		clean_network_cache( $network_id );
	}

	/**
	 * @param $meta_id
	 * @param $network_id
	 */
	function updated_site_meta( $meta_id, $network_id ) {
		clean_network_cache( $network_id );
	}

	/**
	 * @param $meta_ids
	 * @param $network_id
	 */
	function delete_site_meta( $meta_ids, $network_id ) {
		clean_network_cache( $network_id );
	}
}
new WP_Network_Cache_Clear();
