<?php
class ManagerController extends AppController {

	var $name = 'Manager';
	var $helpers = array('Html', 'Form');
	#var $uses = array('ActiveListing','Book','User','RemovedListing');
	var $uses = array();

	function beforeFilter()
	{
		#$this->is_admin = 1;
		# We need a way to know a page is an admin page, so we can force checking against user account settings.
		# XXX FOR NOW LET ANYONE DO!

		#$this->Auth->allow(); # No anonymous!
		#$this->Auth->allow('*');
		parent::beforeFilter();
	}

	function admin_index() 
	{
	}
}
?>
