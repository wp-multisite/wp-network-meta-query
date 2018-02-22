<?php
/**
 * Network API: WP_Network_Meta_Query class
 *
 * @package Plugins/Networks/Queries
 * @since 1.0.0
 */
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Core class used for querying by site meta.
 *
 * @since 1.0.0
 *
 * @see WP_Network_Meta_Query::__construct() for accepted arguments.
 */
class WP_Network_Meta_Query {

	/**
	 * Array of columns frow `wp_sites` to prefix
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $columns = array(
		'id',
		'domain',
		'path',
	);

	/**
	 * Pointer to WordPress Database object
	 *
	 * @since 1.0.0
	 *
	 * @var WPDB
	 */
	private $db;

	/**
	 * Setup hooks to modify WP_Network_Query
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->db = $GLOBALS['wpdb'];

		add_action( 'parse_network_query', array( $this, 'parse_network_query' ) );
		add_action( 'pre_get_networks',    array( $this, 'pre_get_networks' ) );
		add_action( 'networks_clauses',    array( $this, 'networks_clauses' ), 10, 2 );
	}

	/**
	 * Parse the network query for meta_query argument
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Network_Query $network_query
	 */
	public function parse_network_query( $network_query ) {

		// Add empty meta_query
		$network_query->query_var_defaults['meta_query'] = '';

		// Reparse the query vars with `meta_query` added
		$network_query->query_vars = wp_parse_args( $network_query->query_vars, $network_query->query_var_defaults );
	}

	/**
	 * Make sure meta_query is set in default query variables
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Network_Query $network_query
	 */
	public function pre_get_networks( $network_query ) {
		if ( ! isset( $network_query->query_var_defaults['meta_query'] ) ) {
			$network_query->query_var_defaults['meta_query'] = '';
		}
	}

	/**
	 * Maybe add where & join for meta_query clauses
	 *
	 * @since 0.1.0
	 *
	 * @global type $wpdb
	 *
	 * @param array $clauses
	 * @param WP_Network_Query $network_query
	 *
	 * @return array
	 */
	public function networks_clauses( $clauses, $network_query ) {
		global $wpdb;
		// Look out for an unset 'join' clause
		if ( ! isset( $clauses['join'] ) ) {
			$clauses['join'] = '';
		}

		// Loop for meta query
		$meta_query = $network_query->query_vars['meta_query'];
		if ( ! empty( $meta_query ) && is_array( $meta_query ) ) {
			$network_query->meta_query = new WP_Meta_Query( $meta_query );
			$meta_clauses           = $network_query->meta_query->get_sql( 'site', 's', 'id', $network_query );

			// Concatenate query clauses
			$clauses['join']  .= $meta_clauses['join'];
			if ( empty( $clauses['where'] ) ) {
				$clauses['where'] = '1 = 1';
			}
			$clauses['where'] .= $meta_clauses['where'];

			// Mutate clauses
			$clauses['join']    = $this->mutate_join( $clauses['join'] );
			$clauses['join']    = $this->mutate_columns( $clauses['join'] );
			$clauses['fields']  = $this->mutate_columns( $clauses['fields'] );
			$clauses['where']   = $this->mutate_columns( $clauses['where'] );
			$clauses['orderby'] = $this->mutate_columns( $clauses['orderby'] );
		}

		// Return possibly modified clauses
		return $clauses;
	}

	/**
	 * Add table name to join section
	 *
	 * @since 1.0.0
	 *
	 * @param string $join
	 *
	 * @return string
	 */
	public function mutate_join( $join = '' ) {
		return "s{$join}";
	}

	/**
	 * Add table name to `wp_sites` columns
	 *
	 * @since 1.0.1
	 *
	 * @param string $section
	 *
	 * @return string
	 */
	public function mutate_columns( $section = '' ) {

		// Replace full-word database table
		$section = str_replace( "{$this->db->site}", 's', $section );
		$section = str_replace( 'smeta', $this->db->sitemeta, $section );

		// Return maybe-replaced section of the database query
		return $section;
	}
}
new WP_Network_Meta_Query();
