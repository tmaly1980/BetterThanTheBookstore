<?php
class CartItem extends AppModel {

	var $name = 'CartItem';
	var $primaryKey = 'item_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'ActiveListing' => array('className' => 'ActiveListing',
								'foreignKey' => 'listing_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Book' => array('className' => 'Book',
								'foreignKey' => 'book_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
