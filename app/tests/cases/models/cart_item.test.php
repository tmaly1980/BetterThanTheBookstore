<?php 
/* SVN FILE: $Id$ */
/* CartItem Test cases generated on: 2008-08-12 15:08:55 : 1218570895*/
App::import('Model', 'CartItem');

class TestCartItem extends CartItem {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class CartItemTestCase extends CakeTestCase {
	var $CartItem = null;
	var $fixtures = array('app.cart_item', 'app.user', 'app.active_listing', 'app.book');

	function start() {
		parent::start();
		$this->CartItem = new TestCartItem();
	}

	function testCartItemInstance() {
		$this->assertTrue(is_a($this->CartItem, 'CartItem'));
	}

	function testCartItemFind() {
		$results = $this->CartItem->recursive = -1;
		$results = $this->CartItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CartItem' => array(
			'item_id'  => 1,
			'user_id'  => 1,
			'listing_id'  => 1,
			'book_id'  => 1,
			'quantity'  => 1,
			'price'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>