<?php
class ActiveListingsController extends AppController {

	var $name = 'ActiveListings';
	var $helpers = array('Html', 'Form');
	var $uses = array('ActiveListing','Book','User','RemovedListing');

	function beforeFilter()
	{
		#$this->Auth->allow(); # No anonymous!
		parent::beforeFilter();
	}

	function index() {
		$this->redirect("/users/account"); 

		#$sess_user_id = $this->Session->read("Auth.User.user_id");
		#$this->ActiveListing->recursive = 0;
		# Should confine to just YOURS....
		#$this->set('activeListings', $this->paginate('ActiveListing',array("ActiveListing.user_id" => $sess_user_id)));
	}

	function _view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ActiveListing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('activeListing', $this->ActiveListing->read(null, $id));
	}

	function add($isbn = null) {

		if (!$isbn) { $isbn = $this->data["ActiveListing"]['isbn']; }
		if (!$isbn) { $isbn = $this->params['form']['isbn']; }
		$book_id = isset($this->data["ActiveListing"]["book_id"]) ?  $this->data["ActiveListing"]["book_id"] : "";

		error_log("ISBN_ADD=$isbn, REDIR?\n");

		if (!$isbn && !$book_id) { $this->redirect("/books/sell"); } # Need isbn number!

		$payment_email = $this->Session->read("Auth.User.payment_email");
		#print_r($this->Session->read());

		$user_id = $this->Session->read("Auth.User.user_id");

		if (!empty($this->data)) {
			# Assert book is in db, querying amazon by isbn if needed.
			# Look up book information to get book_id.

			# Ensure clicked on required checkboxes.
			if (!isset($this->params['form']['valid_isbn_verify']) ||
			 !isset($this->params['form']['condition_terminology_verify']))
			{
				$this->Session->setFlash(__('You must agree to and click on the required checkboxes', true));
				# Needs to hit 'set' code below for page to properly load....
			} else {
				$this->data["ActiveListing"]['user_id'] = $user_id;
				$this->data["ActiveListing"]['school_id'] = $this->Session->read("Auth.User.school_id");
				$this->data["ActiveListing"]['postdate'] = $this->get_timestamp();
	
				$this->ActiveListing->create();
				if ($this->ActiveListing->save($this->data)) {
					$this->Session->setFlash(__('Your Listing has been added', true));
					$this->redirect(array('controller'=>'users','action'=>'account'));
				} else {
					$this->Session->setFlash(__('The Listing could not be saved. Please, try again.', true));
				}
				return;
			}
		} 

		$this->set("conditions", $this->ActiveListing->getEnumValues('condition_id'));
		$this->set("salestats", $this->Book->get_sales_stats($isbn));
		$this->set("isbn", $isbn);
		$this->set("book", $this->Book->find("isbn13 = '$isbn'"));

		#$users = $this->ActiveListing->User->find('list');
		#$books = $this->ActiveListing->Book->find('list');
		#$this->set(compact('users', 'books'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid listing', true));
			$this->redirect(array('controller'=>'users','action'=>'account'));
		}
		if (!empty($this->data)) {
			if ($this->ActiveListing->save($this->data)) {
				$this->Session->setFlash(__('The listing has been updated', true));
				$this->redirect(array('controller'=>'users','action'=>'account'));
			} else {
				$this->Session->setFlash(__('The listing could not be updated. Please, try again.', true));
				$this->redirect(array('controller'=>'users','action'=>'account'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ActiveListing->read(null, $id);
			$isbn = $this->data["Book"]["isbn13"];
			$this->set("book", $this->data);
			$this->set("conditions", $this->ActiveListing->getEnumValues('condition_id'));
			$this->set("salestats", $this->Book->get_sales_stats($isbn));
			$payment_email = $this->Session->read("Auth.User.payment_email");
			$this->set("payment_email", $payment_email);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid listing', true));
			$this->redirect(array('action'=>'index'));
		}

		# Move to RemovedListing table...
		$listing = $this->ActiveListing->read(null, $id);
		$removedlisting = $listing['ActiveListing'];
		$removedlisting['active_listing_id'] = $id;
		unset($removedlisting['paused']);
		unset($removedlisting['hold']);
		unset($removedlisting['listing_id']);

		$this->RemovedListing->create($removedlisting);
		$this->RemovedListing->save();

		if ($this->ActiveListing->del($id)) {
			$this->Session->setFlash(__('Listing removed', true));
		} else {
			$this->Session->setFlash(__('Unable to remove listing. Please, try again.', true));
		}
		$this->redirect(array('controller'=>'users','action'=>'account'));
	}

	function admin_pause_all()
	{
		if ($this->ActiveListing->updateAll(array('paused'=>1)))
		{
			$this->Session->setFlash(__('ALL active listings are now paused. Please send an email to members to re-enable listings for sale.',true));
		} else {
			$this->Session->setFlash(__('UNABLE to pause active listings. Please, try again.',true));
		}
		$this->redirect("/admin");
	}

	function pause($listing_id)
	{
		if($listing = $this->ActiveListing->read(null, $listing_id))
		{
			$listing['ActiveListing']['paused'] = 1;
			if (!$this->ActiveListing->save($listing))
			{
				$this->Session->setFlash(__('Unable to pause listing. Please, try again.', true));
			}
		} else {
			$this->Session->setFlash(__('Unable to find listing. Please, try again.', true));
		}
		$this->redirect(array('controller'=>'users','action'=>'account'));
	}

	function unpause($listing_id)
	{
		if($listing = $this->ActiveListing->read(null, $listing_id))
		{
			$listing['ActiveListing']['paused'] = 0;
			if (!$this->ActiveListing->save($listing))
			{
				$this->Session->setFlash(__('Unable to unpause listing. Please, try again.', true));
			}
		} else {
			$this->Session->setFlash(__('Unable to find listing. Please, try again.', true));
		}
		$this->redirect(array('controller'=>'users','action'=>'account'));
	}


	function admin_index() {
		$this->ActiveListing->recursive = 0;
		$this->set('activeListings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ActiveListing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('activeListing', $this->ActiveListing->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ActiveListing->create();
			if ($this->ActiveListing->save($this->data)) {
				$this->Session->setFlash(__('The ActiveListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ActiveListing could not be saved. Please, try again.', true));
			}
		}
		$users = $this->ActiveListing->User->find('list');
		$books = $this->ActiveListing->Book->find('list');
		$this->set(compact('users', 'books'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ActiveListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ActiveListing->save($this->data)) {
				$this->Session->setFlash(__('The ActiveListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ActiveListing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ActiveListing->read(null, $id);
		}
		$users = $this->ActiveListing->User->find('list');
		$books = $this->ActiveListing->Book->find('list');
		$this->set(compact('users','books'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ActiveListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ActiveListing->del($id)) {
			$this->Session->setFlash(__('ActiveListing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
