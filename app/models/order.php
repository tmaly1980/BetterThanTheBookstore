<?php
class Order extends AppModel {

	var $name = 'Order';
	var $primaryKey = 'order_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Sale' => array('className' => 'Sale',
								'foreignKey' => 'order_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>