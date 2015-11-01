<?php 
/* SVN FILE: $Id$ */
/* Sale Fixture generated on: 2008-08-05 13:08:25 : 1217957005*/

class SaleFixture extends CakeTestFixture {
	var $name = 'Sale';
	var $table = 'sales';
	var $fields = array(
			'sale_id' => array('type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'total' => array('type'=>'float', 'null' => true, 'default' => NULL),
			'time' => array('type'=>'date', 'null' => true, 'default' => NULL),
			'listing_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
			'book_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array('PRIMARY' => array('column' => 'sale_id', 'unique' => 1), 'listing_id' => array('column' => 'listing_id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0), 'listing_id_2' => array('column' => 'listing_id', 'unique' => 0), 'user_id_2' => array('column' => 'user_id', 'unique' => 0))
			);
	var $records = array(array(
			'sale_id'  => 1,
			'user_id'  => 1,
			'total'  => 1,
			'time'  => '2008-08-05',
			'listing_id'  => 1,
			'book_id'  => 1
			));
}
?>