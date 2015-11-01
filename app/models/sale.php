<?php
class Sale extends AppModel {

	var $name = 'Sale';
	var $primaryKey = 'sale_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Book' => array('className' => 'Book',
								'foreignKey' => 'book_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasOne = array(
			'SoldListing' => array('className' => 'SoldListing',
								'foreignKey' => 'sale_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>