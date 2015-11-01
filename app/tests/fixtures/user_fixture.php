<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2008-08-05 13:08:24 : 1217956824*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
			'user_id' => array('type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'primary'),
			'school_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'school_email' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 64, 'key' => 'unique'),
			'email' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 64, 'key' => 'index'),
			'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 25),
			'first' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'last' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'phone' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
			'student_id' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
			'regdate' => array('type'=>'date', 'null' => true, 'default' => NULL),
			'verified' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 1),
			'indexes' => array('PRIMARY' => array('column' => 'user_id', 'unique' => 1), 'school_email' => array('column' => 'school_email', 'unique' => 1), 'school_id' => array('column' => 'school_id', 'unique' => 0), 'email' => array('column' => 'email', 'unique' => 0))
			);
	var $records = array(array(
			'user_id'  => 1,
			'school_id'  => 1,
			'school_email'  => 'Lorem ipsum dolor sit amet',
			'email'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit a',
			'first'  => 'Lorem ipsum dolor ',
			'last'  => 'Lorem ipsum dolor ',
			'phone'  => 'Lorem ip',
			'student_id'  => 'Lorem ip',
			'regdate'  => '2008-08-05',
			'verified'  => 1
			));
}
?>