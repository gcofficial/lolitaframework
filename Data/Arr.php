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
	public static function append( $array = [], $value = null ) {
		$array[] = $value;
		return $array;
	}

	/**
	 * Creates  an  array  with  all  falsey  values removed. The values false, null, 0, "", undefined, and NaN are all
	 * falsey.
	 *
	 * @usage __::compact([0, 1, false, 2, '', 3]);
	 *        >> [1, 2, 3]
	 *
	 * @param array $array array to compact
	 *
	 * @return array
	 */
	public static function compact($array = [])
	{
		return array_values(
			array_filter($array, function($var) { return $var; })
		);
	}
}
