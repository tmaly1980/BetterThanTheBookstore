<?php 
/* SVN FILE: $Id$ */
/* SoldListing Fixture generated on: 2008-08-14 12:08:51 : 1218732171*/

class SoldListingFixture extends CakeTestFixture {
	var $name = 'SoldListing';
	var $table = 'sold_listings';
	var $fields = array(
			'listing_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'book_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'school_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'price' => array('type'=>'float', 'null' => true, 'default' => NULL),
			'postdate' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'comments' => array('type'=>'text', 'null' => true, 'default' => NULL),
			'sale_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
			'active_listing_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
			'indexes' => array('PRIMARY' => array('column' => 'listing_id', 'unique' => 1), 'sale_id' => array('column' => 'sale_id', 'unique' => 1), 'active_listing_id' => array('column' => 'active_listing_id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'book_id' => array('column' => 'book_id', 'unique' => 0), 'sale_id_2' => array('column' => 'sale_id', 'unique' => 0))
			);
	var $records = array(array(
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
}
?>