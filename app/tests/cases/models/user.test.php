<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2008-08-05 13:08:24 : 1217956824*/
App::import('Model', 'User');

class TestUser extends User {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user', 'app.school', 'app.active_listing', 'app.removed_listing', 'app.sale', 'app.sold_listing');

	function start() {
		parent::start();
		$this->User = new TestUser();
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$results = $this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>