<?php
class ActiveListing extends AppModel {

	var $name = 'ActiveListing';
	var $primaryKey = 'listing_id';

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

}
?>