<?php 
/* SVN FILE: $Id$ */
/* SoldListingsController Test cases generated on: 2008-08-14 12:08:23 : 1218732203*/
App::import('Controller', 'SoldListings');

class TestSoldListings extends SoldListingsController {
	var $autoRender = false;
}

class SoldListingsControllerTest extends CakeTestCase {
	var $SoldListings = null;

	function setUp() {
		$this->SoldListings = new TestSoldListings();
	}

	function testSoldListingsControllerInstance() {
		$this->assertTrue(is_a($this->SoldListings, 'SoldListingsController'));
	}

	function tearDown() {
		unset($this->SoldListings);
	}
}
?>