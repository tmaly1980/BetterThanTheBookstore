<?php 
/* SVN FILE: $Id$ */
/* CartItem Fixture generated on: 2008-08-12 15:08:55 : 1218570895*/

class CartItemFixture extends CakeTestFixture {
	var $name = 'CartItem';
	var $table = 'cart_items';
	var $fields = array(
			'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
			'listing_id' => array('type'=>'integer', 'null' => false, 'length' => 10),
			'book_id' => array('type'=>'integer', 'null' => false, 'length' => 10),
			'quantity' => array('type'=>'integer', 'null' => false, 'default' => '1', 'length' => 10),
			'price' => array('type'=>'float', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'item_id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0))
			);
	var $records = array(array(
			'item_id'  => 1,
			'user_id'  => 1,
			'listing_id'  => 1,
			'book_id'  => 1,
			'quantity'  => 1,
			'price'  => 1
			));
}
?>