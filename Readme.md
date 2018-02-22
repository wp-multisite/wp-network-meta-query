WP Network Meta Query
====================

Add support for meta query on WP_Network_Query. More detail on original trac ticket [#38025](https://core.trac.wordpress.org/ticket/38025).


# Installation

## WordPress

* Download and install using the built-in WordPress plugin installer
* Network Activate in the "Plugins" area of the network-admin of the main site of your installation (phew!)
* Optionally drop the entire `wp-network-meta-query` directory into `mu-plugins`
* No further setup or configuration is necessary

## Composer

* Add repository source : `{ "type": "vcs", "url": "https://github.com/wp-multisite/wp-network-meta-query.git" }`
* Include `"wp-multisite/wp-network-meta-query": "dev-master"` in your composer file
