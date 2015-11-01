<?php 
/* SVN FILE: $Id$ */
/* School Test cases generated on: 2008-08-05 13:08:58 : 1217957098*/
App::import('Model', 'School');

class TestSchool extends School {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class SchoolTestCase extends CakeTestCase {
	var $School = null;
	var $fixtures = array('app.school', 'app.active_listing', 'app.removed_listing', 'app.sold_listing', 'app.user');

	function start() {
		parent::start();
		$this->School = new TestSchool();
	}

	function testSchoolInstance() {
		$this->assertTrue(is_a($this->School, 'School'));
	}

	function testSchoolFind() {
		$results = $this->School->recursive = -1;
		$results = $this->School->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('School' => array(
			'school_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'domain'  => 'Lorem ipsum do'
			));
		$this->assertEqual($results, $expected);
	}
}
?>