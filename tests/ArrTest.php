<?php
namespace Tests;

use LolitaFramework\Data\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Testing Arr::*
 */
class ArrTest extends TestCase {

	/**
	 * Test append method
	 */
	public function test_append() {
		$this->assertEquals(
			array( 1, 2, 3, 4 ),
			Arr::append( array( 1, 2, 3 ), 4 )
		);
	}

	/**
	 * Test prepend method
	 */
	public function test_prepend() {
		$this->assertEquals(
			array( 4, 1, 2, 3 ),
			Arr::prepend( array( 1, 2, 3 ), 4 )
		);
	}

	/**
	 * Test compact method
	 */
	public function test_compact() {
		$this->assertEquals(
			array( 1, 2, 3 ),
			Arr::compact( array( 0, 1, false, 2, '', 3 ) )
		);
	}

	/**
	 * Test accessible method
	 */
	public function test_accessible() {
		$this->assertEquals(
			true,
			Arr::accessible( array() )
		);

		$this->assertEquals(
			false,
			Arr::accessible( 0 )
		);
	}

	/**
	 * Test divide method
	 */
	public function test_divide() {
		$this->assertEquals(
			array(
				array( 'a', 'b', 'c' ),
				array( '1', '2', '3' ),
			),
			Arr::divide(
				array(
					'a' => 1,
					'b' => 2,
					'c' => 3,
				)
			)
		);
	}

	/**
	 * Test set method
	 */
	public function test_set() {
		$this->assertEquals(
			array(
				'products' => array(
					'desk' => array( 'price' => 'TESTING' ),
				),
			),
			Arr::set(
				array(
					'products' => array(
						'desk' => array( 'price' => 100 ),
					),
				),
				'products.desk.price',
				'TESTING'
			)
		);
	}

	/**
	 * Test get method
	 */
	public function test_get() {
		$this->assertEquals(
			'TESTING',
			Arr::get(
				array(
					'products' => array(
						'desk' => array( 'price' => 'TESTING' ),
					),
				),
				'products.desk.price'
			)
		);
	}

	/**
	 * Test has method
	 */
	public function test_has() {
		$this->assertEquals(
			true,
			Arr::has(
				array(
					'products' => array( 'desk' => array( 'price' => 100 ) ),
				),
				'products.desk'
			)
		);

		$this->assertEquals(
			false,
			Arr::has(
				array(
					array(
						'id' => 1,
						'name' => 'John Doe',
					),
					array(
						'id' => 2,
						'name' => 'John Doe',
					),
				),
				'2.name'
			)
		);
	}

	/**
	 * Test isAssoc method
	 */
	public function test_is_assoc() {
		$this->assertEquals(
			true,
			Arr::is_assoc( array( 'key' => 'value' ) )
		);
		$this->assertEquals(
			false,
			Arr::is_assoc( array( 1, 2, 3 ) )
		);
	}

	/**
	 * Test only method
	 */
	public function test_only() {
		$this->assertEquals(
			array(
				'name' => 'Desk',
				'price' => 100,
			),
			Arr::only(
				array(
					'name' => 'Desk',
					'price' => 100,
					'orders' => 10,
				),
				array( 'name', 'price' )
			)
		);
	}

	/**
	 * Test pluck method
	 */
	public function test_pluck() {
		$this->assertEquals(
			array( 'Taylor', 'Abigail' ),
			Arr::pluck(
				array(
					array(
						'developer' => array(
							'id' => 1,
							'name' => 'Taylor',
						),
					),
					array(
						'developer' => array(
							'id' => 2,
							'name' => 'Abigail',
						),
					),
				),
				'developer.name'
			)
		);
	}

	/**
	 * Test forget method
	 */
	public function test_forget() {
		$this->assertEquals(
			array( 'products' => array() ),
			Arr::forget(
				array( 'products' => array( 'desk' => array( 'price' => 100 ) ) ),
				'products.desk'
			)
		);

		$this->assertEquals(
			array(
				array( 'name' => 'John Doe' ),
				array(
					'id' => 2,
					'name' => 'Jane Doe',
				),
			),
			Arr::forget(
				array(
					array(
						'id' => 1,
						'name' => 'John Doe',
					),
					array(
						'id' => 2,
						'name' => 'Jane Doe',
					),
				),
				'0.id'
			)
		);
	}

	/**
	 * Test where method
	 */
	public function test_where() {
		$this->assertEquals(
			array(
				0 => 100,
				2 => 200,
				4 => 300,
			),
			Arr::where(
				array( 100, '100', 200, '200', 300 ),
				function( $value ) {
					return ! is_string( $value );
				}
			)
		);
	}

	/**
	 * Test map method
	 */
	public function test_map() {
		$this->assertEquals(
			array( 0, 0 ),
			Arr::map(
				array( 1, 1 ),
				function( $el ) {
					return 0;
				}
			)
		);
	}

	/**
	 * Test arsort method
	 */
	public function test_arsort() {
		$this->assertEquals(
			array(
				'a' => 'orange',
				'd' => 'lemon',
				'b' => 'banana',
				'c' => 'apple',
			),
			Arr::arsort(
				array(
					'd' => 'lemon',
					'a' => 'orange',
					'b' => 'banana',
					'c' => 'apple',
				)
			)
		);
	}

	/**
	 * Test arsort method
	 */
	public function test_asort() {
		$this->assertEquals(
			array(
				'c' => 'apple',
				'b' => 'banana',
				'd' => 'lemon',
				'a' => 'orange',
			),
			Arr::arsort(
				array(
					'd' => 'lemon',
					'a' => 'orange',
					'b' => 'banana',
					'c' => 'apple',
				)
			)
		);
	}

	/**
	 * Test natcasesort method
	 */
	public function test_natcasesort() {
		$this->assertEquals(
			array(
				0 => 'IMG0.png',
				4 => 'img1.png',
				3 => 'img2.png',
				5 => 'IMG3.png',
				2 => 'img10.png',
				1 => 'img12.png',
			),
			Arr::natcasesort(
				array(
					'IMG0.png',
					'img12.png',
					'img10.png',
					'img2.png',
					'img1.png',
					'IMG3.png',
				)
			)
		);
	}

	/**
	 * Test krsort method
	 */
	public function test_krsort() {
		$this->assertEquals(
			array(
				'd' => 'lemon',
				'c' => 'apple',
				'b' => 'banana',
				'a' => 'orange',
			),
			Arr::krsort(
				array(
					'd' => 'lemon',
					'a' => 'orange',
					'b' => 'banana',
					'c' => 'apple',
				)
			)
		);
	}

	/**
	 * Test ksort method
	 */
	public function test_ksort() {
		$this->assertEquals(
			array(
				'a' => 'orange',
				'b' => 'banana',
				'c' => 'apple',
				'd' => 'lemon',
			),
			Arr::ksort(
				array(
					'd' => 'lemon',
					'a' => 'orange',
					'b' => 'banana',
					'c' => 'apple',
				)
			)
		);
	}

	/**
	 * Test natsort method
	 */
	public function test_natsort() {
		$this->assertEquals(
			array(
				3 => 'img1.png',
				2 => 'img2.png',
				1 => 'img10.png',
				0 => 'img12.png',
			),
			Arr::natsort(
				array(
					'img12.png',
					'img10.png',
					'img2.png',
					'img1.png',
				)
			)
		);
	}

	/**
	 * Test rsort method
	 */
	public function test_rsort() {
		$this->assertEquals(
			array(
				'0' => 'orange',
				'1' => 'lemon',
				'2' => 'banana',
				'3' => 'apple',
			),
			Arr::rsort(
				array(
					'lemon',
					'orange',
					'banana',
					'apple',
				)
			)
		);
	}

	/**
	 * Test sort method
	 */
	public function test_sort() {
		$this->assertEquals(
			array(
				'apple',
				'banana',
				'lemon',
				'orange',
			),
			Arr::sort(
				array(
					'lemon',
					'orange',
					'banana',
					'apple',
				)
			)
		);
	}
}
