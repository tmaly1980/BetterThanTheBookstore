<?php 
/* SVN FILE: $Id$ */
/* ActiveListing Test cases generated on: 2008-08-05 13:08:44 : 1217956544*/
App::import('Model', 'ActiveListing');

class TestActiveListing extends ActiveListing {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class ActiveListingTestCase extends CakeTestCase {
	var $ActiveListing = null;
	var $fixtures = array('app.active_listing', 'app.user', 'app.book');

	function start() {
		parent::start();
		$this->ActiveListing = new TestActiveListing();
	}

	function testActiveListingInstance() {
		$this->assertTrue(is_a($this->ActiveListing, 'ActiveListing'));
	}

	function testActiveListingFind() {
		$results = $this->ActiveListing->recursive = -1;
		$results = $this->ActiveListing->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('ActiveListing' => array(
			'listing_id'  => 1,
			'user_id'  => 1,
			'book_id'  => 1,
			'school_id'  => 1,
			'price'  => 1,
			'condition_id'  => 1,
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
			'hold'  => 1,
			'paused'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>