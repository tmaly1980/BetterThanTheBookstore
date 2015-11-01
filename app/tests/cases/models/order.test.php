<?php 
/* SVN FILE: $Id$ */
/* Order Test cases generated on: 2008-08-13 22:08:20 : 1218682220*/
App::import('Model', 'Order');

class TestOrder extends Order {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class OrderTestCase extends CakeTestCase {
	var $Order = null;
	var $fixtures = array('app.order', 'app.sale');

	function start() {
		parent::start();
		$this->Order = new TestOrder();
	}

	function testOrderInstance() {
		$this->assertTrue(is_a($this->Order, 'Order'));
	}

	function testOrderFind() {
		$results = $this->Order->recursive = -1;
		$results = $this->Order->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Order' => array(
			'order_id'  => 1,
			'buyer_id'  => 1,
			'time'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>