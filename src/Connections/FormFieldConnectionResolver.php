<?php

namespace WPGraphQLGravityForms\Connections;

use GraphQLRelay\Connection\ArrayConnection;
use WPGraphQL\Data\Connection\AbstractConnectionResolver;
use WPGraphQLGravityForms\DataManipulators\FieldsDataManipulator;
use WPGraphQLGravityForms\Data\Loader\FieldsLoader;

class FormFieldConnectionResolver extends AbstractConnectionResolver {
    /**
     * @return bool Whether query should execute.
     */
    public function should_execute() : bool {
        return true;
    }

	/**
	 * Return the name of the loader to be used with the connection resolver
	 *
	 * @return string
	 */
	public function get_loader_name() {
        return FieldsLoader::NAME;
    }


    /**
     * Determine whether or not the the offset is valid, i.e the item corresponding to the offset exists.
	 * Offset is equivalent to WordPress ID (e.g post_id, term_id). So this function is equivalent
	 * to checking if the WordPress object exists for the given ID.
     *
     * @param int $offset The offset.
     *
     * @return bool Whether the offset is valid.
     */
    public function is_valid_offset( $offset ) : bool {
        return true;
    }

    /**
	 * Validates Model.
	 *
	 * If model isn't a class with a `fields` member, this function with have be overridden in
	 * the Connection class.
	 *
	 * @param array $model model.
	 *
	 * @return bool
	 */
	protected function is_valid_model( $model ) {
		return true;
	}

    /**
     * @return array Query arguments.
     */
	public function get_query_args() {
        return [];
    }

	/**
	 * The Query used to get items from the database (or even external datasource) are all
	 * different.
	 *
	 * Each connection resolver should be responsible for defining the Query object that
	 * is used to fetch items.
	 *
	 * @return mixed
	 */
	public function get_query() {
        return [];
    }

    /**
     * @return string Base-64 encoded cursor value.
     */
	protected function get_cursor_for_node( $node, $key = null ) : string {
		return base64_encode( ArrayConnection::PREFIX . $node['id'] );
	}

	/**
	 * Return an array of ids from the query
	 *
	 * Each Query class in WP and potential datasource handles this differently, so each connection
	 * resolver should handle getting the items into a uniform array of items.
	 *
	 * @return array
	 */
	public function get_ids() {
        $args = $this->args;
        return [];
    }

    /**
     * @return array The fields for this Gravity Forms entry.
     */
    // public function get_items() : array {
    //     return $this->source['fields'];
    // }
}
