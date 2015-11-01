<?php 
/* SVN FILE: $Id$ */
/* CartItemsController Test cases generated on: 2008-08-12 15:08:23 : 1218570983*/
App::import('Controller', 'CartItems');

class TestCartItems extends CartItemsController {
	var $autoRender = false;
}

class CartItemsControllerTest extends CakeTestCase {
	var $CartItems = null;

	function setUp() {
		$this->CartItems = new TestCartItems();
	}

	function testCartItemsControllerInstance() {
		$this->assertTrue(is_a($this->CartItems, 'CartItemsController'));
	}

	function tearDown() {
		unset($this->CartItems);
	}
}
?>