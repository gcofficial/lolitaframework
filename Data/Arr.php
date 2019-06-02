<?php

namespace LolitaFramework\Data;

/**
 * Class for working with arrays
 */
class Arr {

	/**
	 * Append item to array
	 *
	 * @usage lf::append([1, 2, 3], 4);
	 *        >> [1, 2, 3, 4]
	 *
	 * @param array $array original array.
	 * @param mixed $value new item or value to append.
	 *
	 * @return array
	 */
	public static function append( $array = array(), $value = null ) {
		$array[] = $value;
		return $array;
	}

	/**
	 * Prepend item to array
	 *
	 * @usage lf::prepend([1, 2, 3], 4);
	 *         >> [4, 1, 2, 3]
	 *
	 * @param  array $array original array.
	 * @param  mixed $value new item or value to prepend.
	 * @param  mixed $key new key of item.
	 * @return array
	 */
	public static function prepend( $array = array(), $value, $key = null ) {
		if ( is_null( $key ) ) {
			array_unshift( $array, $value );
		} else {
			$array = [ $key => $value ] + $array;
		}

		return $array;
	}

	/**
	 * Creates  an  array  with  all  falsey  values removed. The values false, null, 0, "", undefined, and NaN are all
	 * falsey.
	 *
	 * @usage __::compact([0, 1, false, 2, '', 3]);
	 *        >> [1, 2, 3]
	 *
	 * @param array $array array to compact.
	 *
	 * @return array
	 */
	public static function compact( $array = [] ) {
		return array_values(
			array_filter(
				$array,
				function( $var ) {
					return $var;
				}
			)
		);
	}

	/**
	 * Determine whether the given value is array accessible.
	 *
	 * @param  mixed $value checkin to accessible.
	 * @return bool
	 */
	public static function accessible( $value ) {
		return is_array( $value ) || $value instanceof ArrayAccess;
	}

	/**
	 * Divide an array into two arrays. One with keys and the other with values.
	 *
	 * @param  array $array array to divide.
	 * @return array
	 */
	public static function divide( $array ) {
		return array( array_keys( $array ), array_values( $array ) );
	}

	/**
	 * Set an array item to a given value using "dot" notation.
	 *
	 * If no key is given to the method, the entire array will be replaced.
	 *
	 * @param  array  $array existing array.
	 * @param  string $key path to set.
	 * @param  mixed  $value value to set.
	 * @param  string $separator separator.
	 * @return array new array.
	 */
	public static function set( $array, $key, $value, $separator = '.' ) {
		if ( is_null( $key ) ) {
			$array = $value;
			return $array;
		}

		$keys = explode( $separator, $key );
		$count_keys = count( $keys );
		$last_key = array_values( $keys )[ $count_keys - 1 ];
		$tmp_array = &$array;

		for ( $i = 0; $i < $count_keys - 1; $i++ ) {
			$k = $keys[ $i ];
			$tmp_array = &$tmp_array[ $k ];
		}
		$tmp_array[ $last_key ] = $value;
		return $array;
	}

	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param  \ArrayAccess|array $array existing array.
	 * @param  string|int         $key to check.
	 * @return bool
	 */
	public static function exists( $array, $key ) {
		if ( $array instanceof ArrayAccess ) {
			return $array->offsetExists( $key );
		}

		return array_key_exists( $key, $array );
	}

	/**
	 * Get an item from an array using "dot" notation.
	 *
	 * @param  \ArrayAccess|array $array where we want to get.
	 * @param  string             $key key with dot's.
	 * @param  mixed              $default value.
	 * @return mixed
	 */
	public static function get( $array, $key, $default = null ) {
		if ( ! static::accessible( $array ) ) {
			return $default;
		}

		if ( is_null( $key ) ) {
			return $array;
		}

		if ( static::exists( $array, $key ) ) {
			return $array[ $key ];
		}

		foreach ( explode( '.', $key ) as $segment ) {
			if ( static::accessible( $array ) && static::exists( $array, $segment ) ) {
				$array = $array[ $segment ];
			} else {
				return $default;
			}
		}

		return $array;
	}

	/**
	 * Check if an item exists in an array using "dot" notation.
	 *
	 * @param  \ArrayAccess|array $array to check.
	 * @param  string             $key keys with dot's.
	 * @return bool
	 */
	public static function has( $array, $key ) {
		if ( ! $array ) {
			return false;
		}

		if ( is_null( $key ) ) {
			return false;
		}

		if ( static::exists( $array, $key ) ) {
			return true;
		}

		foreach ( explode( '.', $key ) as $segment ) {
			if ( static::accessible( $array ) && static::exists( $array, $segment ) ) {
				$array = $array[ $segment ];
			} else {
				return false;
			}
		}

		return true;
	}

	/**
	 * Determines if an array is associative.
	 *
	 * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
	 *
	 * @param  array $array to check.
	 * @return bool
	 */
	public static function is_assoc( $array ) {
		$keys = array_keys( $array );

		return array_keys( $keys ) !== $keys;
	}

	/**
	 * Get a subset of the items from the given array.
	 *
	 * @param  array        $array to get.
	 * @param  array|string $keys to filter.
	 * @return array
	 */
	public static function only( $array, $keys ) {
		return array_intersect_key( $array, array_flip( (array) $keys ) );
	}

	/**
	 * Pluck an array of values from an array.
	 *
	 * @param  array             $array source.
	 * @param  string|array      $value values.
	 * @param  string|array|null $key keys.
	 * @return array
	 */
	public static function pluck( $array, $value, $key = null ) {
		$results = [];
		foreach ( $array as $item ) {
			$item_value = static::get( $item, $value );

			// If the key is "null", we will just append the value to the array and keep
			// looping. Otherwise we will key the array using the value of the key we
			// received from the developer. Then we'll return the final array form.
			if ( is_null( $key ) ) {
				$results[] = $item_value;
			} else {
				$item_key = static::get( $item, $key );

				$results[ $item_key ] = $item_value;
			}
		}

		return $results;
	}

	/**
	 * Remove one or many array items from a given array using "dot" notation.
	 *
	 * @param  array        $array to forget.
	 * @param  array|string $keys to exclude.
	 * @return void
	 */
	public static function forget( $array, $keys ) {
		$tmp_array = &$array;

		$keys = (array) $keys;

		if ( count( $keys ) === 0 ) {
			return;
		}

		foreach ( $keys as $key ) {
			// if the exact key exists in the top-level, remove it.
			if ( static::exists( $array, $key ) ) {
				unset( $array[ $key ] );

				continue;
			}

			$parts = explode( '.', $key );

			$count_keys = count( $parts );
			$last_key = array_values( $parts )[ $count_keys - 1 ];

			for ( $i = 0; $i < $count_keys - 1; $i++ ) {
				$k = $parts[ $i ];
				$tmp_array = &$tmp_array[ $k ];
			}
			unset( $tmp_array[ $last_key ] );
		}
		return $array;
	}
}