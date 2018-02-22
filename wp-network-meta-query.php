<?php
/**
 * Network Meta Queries
 *
 * @package     NetworkMetaQueries
 * @author      Jonathan Harris
 * @copyright   2018 Jonathan Harris
 * @license     GPL-2.0+
 *
 * Plugin Name: Network Meta Queries
 * Plugin URI:  https://www.github.com/spacedmonkey/wp-network-meta-query
 * Author:      Jonathan Harris
 * Author URI:  https://www.spacedmonkey.com
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Adds meta query support to network queries
 * Version:     1.0.0
 * Text Domain: wp-network-meta-query
 * Domain Path: /assets/lang/
 * Network: true
 */
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/src/class-wp-network-meta-query.php';
require_once __DIR__ . '/src/class-wp-network-cache-clear.php';