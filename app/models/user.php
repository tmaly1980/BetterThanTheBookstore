<?php

class User extends AppModel {

	var $name = 'User';
	var $primaryKey = 'user_id';
	var $validate = array(
		#'user_id' => array('numeric'),
		'school_email' => array('email'),
		'email' => array('email'),
		'phone' => array('phone'),
		'student_id' => array('numeric'),
		#'regdate' => array('date')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'School' => array('className' => 'School',
								'foreignKey' => 'school_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'ActiveListing' => array('className' => 'ActiveListing',
								'foreignKey' => 'user_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'RemovedListing' => array('className' => 'RemovedListing',
								'foreignKey' => 'user_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Sale' => array('className' => 'Sale',
								'foreignKey' => 'buyer_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'SoldListing' => array('className' => 'SoldListing',
								'foreignKey' => 'user_id',
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

	function generate_password() # A new random one.
	{
		return $this->generate_code(8);
	}

	function generate_code($length = 8) # Random codes, whether password, registration code, etc...
	{
		$chars = array();
		for ($i = ord('a'); $i < ord('z'); $i++)
		{
			$chars[] = chr($i);
		}
		for ($i = ord('A'); $i < ord('Z'); $i++)
		{
			$chars[] = chr($i);
		}
		for ($i = ord('0'); $i < ord('9'); $i++)
		{
			$chars[] = chr($i);
		}

		shuffle($chars); # randomize.

		$code = "";
		for ($ix = 0; $ix < $length; $ix++)
		{
			$code .= $chars[ rand(0, count($chars)-1) ];
		}

		return $code;
	}

	function generate_activation_code() # For email click to verify school email validity.
	{
		return $this->generate_code(32);
	}

	function _processPayment($user_id, $total_price)
	{

		# Actual code in here... to process CC's.
		return true;
	}

	function _sendSellerPayment($seller, $listing_total)
	{
		# calculate % of listings, send that to seller
		$seller_percentage = 0.85;
		$seller_payment = $listing_total * $seller_percentage;

		return true;
	}

}
?>
