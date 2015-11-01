<?php 
/* SVN FILE: $Id$ */
/* Sale Test cases generated on: 2008-08-05 13:08:25 : 1217957005*/
App::import('Model', 'Sale');

class TestSale extends Sale {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class SaleTestCase extends CakeTestCase {
	var $Sale = null;
	var $fixtures = array('app.sale', 'app.user', 'app.book', 'app.sold_listing');

	function start() {
		parent::start();
		$this->Sale = new TestSale();
	}

	function testSaleInstance() {
		$this->assertTrue(is_a($this->Sale, 'Sale'));
	}

	function testSaleFind() {
		$results = $this->Sale->recursive = -1;
		$results = $this->Sale->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sale' => array(
			'sale_id'  => 1,
			'user_id'  => 1,
			'total'  => 1,
			'time'  => '2008-08-05',
			'listing_id'  => 1,
			'book_id'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>