<?php 
/* SVN FILE: $Id$ */
/* Book Fixture generated on: 2008-08-05 13:08:13 : 1217956513*/

class BookFixture extends CakeTestFixture {
	var $name = 'Book';
	var $table = 'books';
	var $fields = array(
			'book_id' => array('type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'primary'),
			'isbn10' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
			'isbn13' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 14, 'key' => 'unique'),
			'title' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
			'author' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 75),
			'format' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 15),
			'edition' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
			'pubdate' => array('type'=>'date', 'null' => true, 'default' => NULL),
			'publisher' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
			'pages' => array('type'=>'integer', 'null' => true, 'default' => NULL),
			'image' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
			'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'book_id', 'unique' => 1), 'isbn10' => array('column' => 'isbn10', 'unique' => 1), 'isbn13' => array('column' => 'isbn13', 'unique' => 1))
			);
	var $records = array(array(
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
}
?>