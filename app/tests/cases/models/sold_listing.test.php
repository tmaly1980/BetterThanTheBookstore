<?php 
/* SVN FILE: $Id$ */
/* SoldListing Test cases generated on: 2008-08-14 12:08:51 : 1218732171*/
App::import('Model', 'SoldListing');

class TestSoldListing extends SoldListing {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class SoldListingTestCase extends CakeTestCase {
	var $SoldListing = null;
	var $fixtures = array('app.sold_listing', 'app.user', 'app.book', 'app.school', 'app.sale', 'app.listing_event');

	function start() {
		parent::start();
		$this->SoldListing = new TestSoldListing();
	}

	function testSoldListingInstance() {
		$this->assertTrue(is_a($this->SoldListing, 'SoldListing'));
	}

	function testSoldListingFind() {
		$results = $this->SoldListing->recursive = -1;
		$results = $this->SoldListing->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('SoldListing' => array(
			'listing_id'  => 1,
			'user_id'  => 1,
			'book_id'  => 1,
			'school_id'  => 1,
			'price'  => 1,
			'postdate'  => '2008-08-14 12:42:51',
			'comments'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'sale_id'  => 1,
			'active_listing_id'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>