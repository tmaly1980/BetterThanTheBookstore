<?php 
/* SVN FILE: $Id$ */
/* Book Test cases generated on: 2008-08-05 13:08:13 : 1217956513*/
App::import('Model', 'Book');

class TestBook extends Book {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class BookTestCase extends CakeTestCase {
	var $Book = null;
	var $fixtures = array('app.book', 'app.active_listing', 'app.removed_listing', 'app.sale', 'app.sold_listing');

	function start() {
		parent::start();
		$this->Book = new TestBook();
	}

	function testBookInstance() {
		$this->assertTrue(is_a($this->Book, 'Book'));
	}

	function testBookFind() {
		$results = $this->Book->recursive = -1;
		$results = $this->Book->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Book' => array(
			'book_id'  => 1,
			'isbn10'  => 'Lorem ip',
			'isbn13'  => 'Lorem ipsum ',
			'title'  => 'Lorem ipsum dolor sit amet',
			'author'  => 'Lorem ipsum dolor sit amet',
			'format'  => 'Lorem ipsum d',
			'edition'  => 1,
			'pubdate'  => '2008-08-05',
			'publisher'  => 'Lorem ipsum dolor sit amet',
			'pages'  => 1,
			'image'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
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
									feugiat lacinia mauris sed, lacinia et felis.'
			));
		$this->assertEqual($results, $expected);
	}
}
?>