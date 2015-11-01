<?php 
/* SVN FILE: $Id$ */
/* BooksController Test cases generated on: 2008-08-05 13:08:50 : 1217957150*/
App::import('Controller', 'Books');

class TestBooks extends BooksController {
	var $autoRender = false;
}

class BooksControllerTest extends CakeTestCase {
	var $Books = null;

	function setUp() {
		$this->Books = new TestBooks();
	}

	function testBooksControllerInstance() {
		$this->assertTrue(is_a($this->Books, 'BooksController'));
	}

	function tearDown() {
		unset($this->Books);
	}
}
?>