<?php 
/* SVN FILE: $Id$ */
/* School Fixture generated on: 2008-08-05 13:08:58 : 1217957098*/

class SchoolFixture extends CakeTestFixture {
	var $name = 'School';
	var $table = 'schools';
	var $fields = array(
			'school_id' => array('type'=>'integer', 'null' => false, 'length' => 10, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32, 'key' => 'unique'),
			'domain' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 16),
			'indexes' => array('PRIMARY' => array('column' => 'school_id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1))
			);
	var $records = array(array(
			'school_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'domain'  => 'Lorem ipsum do'
			));
}
?>