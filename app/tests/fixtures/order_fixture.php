<?php 
/* SVN FILE: $Id$ */
/* Order Fixture generated on: 2008-08-13 22:08:20 : 1218682220*/

class OrderFixture extends CakeTestFixture {
	var $name = 'Order';
	var $table = 'orders';
	var $fields = array(
			'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'buyer_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'time' => array('type'=>'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
			'indexes' => array('PRIMARY' => array('column' => 'order_id', 'unique' => 1))
			);
	var $records = array(array(
			'order_id'  => 1,
			'buyer_id'  => 1,
			'time'  => 1
			));
}
?>