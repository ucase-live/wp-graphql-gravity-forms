<?php

namespace WPGraphQLGravityForms\Data\Loader;

use GF_Query;
use GraphQL\Deferred;
use WPGraphQL\Data\Loader\AbstractDataLoader;
use WPGraphQLGravityForms\DataManipulators\EntryDataManipulator;

class EntriesLoader extends AbstractDataLoader {
	/**
	 * Loader name.
	 */
	const NAME = 'gravityFormsEntries';

	/**
	 * Given array of keys, loads and returns a map consisting of keys from `keys` array and loaded
	 * posts as the values
	 *
	 * Note that order of returned values must match exactly the order of keys.
	 * If some entry is not available for given key - it must include null for the missing key.
	 *
	 * For example:
	 * loadKeys(['a', 'b', 'c']) -> ['a' => 'value1, 'b' => null, 'c' => 'value3']
	 *
	 * @param array $keys
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function loadKeys( array $keys ) {
		if ( empty( $keys ) ) {
			return $keys;
		}

		$gf_query               = new GF_Query();
		$entries                = $gf_query->get_entries( $keys );
		$entry_data_manipulator = new EntryDataManipulator();
		$model_entry            = fn( array $entry ) : array => $entry_data_manipulator->manipulate( $entry );

		$result = array_map( $model_entry, $entries );

		return $result;
	}
}
