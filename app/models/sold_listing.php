<?php
class SoldListing extends AppModel {

	var $name = 'SoldListing';
	var $primaryKey = 'listing_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Seller' => array('className' => 'User',
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
			),
			'School' => array('className' => 'School',
								'foreignKey' => 'school_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Sale' => array('className' => 'Sale',
								'foreignKey' => 'sale_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'ListingEvent' => array('className' => 'ListingEvent',
								'foreignKey' => 'sold_listing_id',
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
