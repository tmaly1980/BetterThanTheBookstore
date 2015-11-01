<?php 
/* SVN FILE: $Id$ */
/* ActiveListingsController Test cases generated on: 2008-08-09 12:08:06 : 1218298146*/
App::import('Controller', 'ActiveListings');

class TestActiveListings extends ActiveListingsController {
	var $autoRender = false;
}

class ActiveListingsControllerTest extends CakeTestCase {
	var $ActiveListings = null;

	function setUp() {
		$this->ActiveListings = new TestActiveListings();
	}

	function testActiveListingsControllerInstance() {
		$this->assertTrue(is_a($this->ActiveListings, 'ActiveListingsController'));
	}

	function tearDown() {
		unset($this->ActiveListings);
	}
}
?>