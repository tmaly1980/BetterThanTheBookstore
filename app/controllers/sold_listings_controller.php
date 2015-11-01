<?php
class SoldListingsController extends AppController {

	var $name = 'SoldListings';
	var $helpers = array('Html', 'Form');
	var $uses = array('SoldListing','ListingEvent');

	function _index() {
		$this->SoldListing->recursive = 0;
		$this->set('soldListings', $this->paginate());
	}

	function _view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SoldListing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('soldListing', $this->SoldListing->read(null, $id));
	}

	function _add() {
		if (!empty($this->data)) {
			$this->SoldListing->create();
			if ($this->SoldListing->save($this->data)) {
				$this->Session->setFlash(__('The SoldListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SoldListing could not be saved. Please, try again.', true));
			}
		}
		$users = $this->SoldListing->User->find('list');
		$books = $this->SoldListing->Book->find('list');
		$schools = $this->SoldListing->School->find('list');
		$sales = $this->SoldListing->Sale->find('list');
		$this->set(compact('users', 'books', 'schools', 'sales'));
	}

	function _edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SoldListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SoldListing->save($this->data)) {
				$this->Session->setFlash(__('The SoldListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SoldListing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SoldListing->read(null, $id);
		}
		$users = $this->SoldListing->User->find('list');
		$books = $this->SoldListing->Book->find('list');
		$schools = $this->SoldListing->School->find('list');
		$sales = $this->SoldListing->Sale->find('list');
		$this->set(compact('users','books','schools','sales'));
	}

	function _delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SoldListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SoldListing->del($id)) {
			$this->Session->setFlash(__('SoldListing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function _admin_index() {
		$this->SoldListing->recursive = 0;
		$this->set('soldListings', $this->paginate());
	}

	function _admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SoldListing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('soldListing', $this->SoldListing->read(null, $id));
	}

	function _admin_add() {
		if (!empty($this->data)) {
			$this->SoldListing->create();
			if ($this->SoldListing->save($this->data)) {
				$this->Session->setFlash(__('The SoldListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SoldListing could not be saved. Please, try again.', true));
			}
		}
		$users = $this->SoldListing->User->find('list');
		$books = $this->SoldListing->Book->find('list');
		$schools = $this->SoldListing->School->find('list');
		$sales = $this->SoldListing->Sale->find('list');
		$this->set(compact('users', 'books', 'schools', 'sales'));
	}

	function admin_list_by_student_id()
	{
		# query against Seller.student_id, Buyer.student_id 
		# Buyer is merged with 'Sale'
		$buyer_student_id = '';
		$seller_student_id = '';

		if (isset($this->passedArgs['buyer_student_id']))
		{
			$buyer_student_id = $this->passedArgs['buyer_student_id'];
		} else if (isset($this->params['form']['buyer_student_id'])) {
			$buyer_student_id = $this->params['form']['buyer_student_id'];
		}
		if (isset($this->passedArgs['seller_student_id']))
		{
			$seller_student_id = $this->passedArgs['seller_student_id'];
		} else if (isset($this->params['form']['seller_student_id'])) {
			$seller_student_id = $this->params['form']['seller_student_id'];
		}

		error_log("SELLER=$seller_student_id, BUYYER=$buyer_student_id");

		if ($buyer_student_id)
		{

			$who = "Buyer.student_id = '$buyer_student_id'";
			$type = 'buyer';
			$student_id = $buyer_student_id;
		} else if ($seller_student_id) {
			$who = "Seller.student_id = '$seller_student_id'";
			$student_id = $seller_student_id;
			$type = 'seller';
		} else {
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('controller'=>'admin','action'=>'index'));
		}

		# Need buyer AND seller info for viewing contact info.....(in case need contact, etc)

		$sql =
				"SELECT 
					SoldListing.*,
					Seller.*,
					Buyer.*,
					Sale.*,
					Book.*
				FROM
					sold_listings SoldListing,
					books	Book,
					sales	Sale,
					users	Seller,
					users	Buyer
				WHERE
					SoldListing.book_id = Book.book_id AND
					SoldListing.sale_id = Sale.sale_id AND
					SoldListing.user_id = Seller.user_id AND
					Sale.buyer_id = Buyer.user_id AND
					$who
				";
		error_log("SQL=$sql");
		$listings = $this->SoldListing->query($sql);
		# Now get ListingEvents for each listing...
		foreach ($listings as &$listing)
		{
			$listing["ListingEvent"] = array();
			$listing_id = $listing["SoldListing"]["listing_id"];
			$active_listing_id = $listing["SoldListing"]["active_listing_id"];
			$listing_events = $this->ListingEvent->findAll("sold_listing_id = '$listing_id' OR active_listing_id = '$active_listing_id'");
			#error_log("SOLD_LISTING_ID=$listing_id ?");

			foreach ($listing_events as $listing_event)
			{
				$listing["ListingEvent"][] = $listing_event["ListingEvent"]; # get data hash.
			}
		}

		$event_types = $this->ListingEvent->getEnumValues("type");
		$this->set("event_types", $event_types);
		$this->set("listings", $listings);
		$this->set("type", $type);
		$this->set("student_id", $student_id);
		$this->set("student", $this->User->find("student_id = '$student_id'"));

	}

	function admin_set_event($listing_id = null, $event_type = null)
	{
		# whether error or ok, we need to go back to PREVIOUS page!
		# (how the hell do we track?)
		#
		$prev_page = isset($this->params['form']['prev_page']) ? $this->params['form']['prev_page'] : '';
		if (!$prev_page) { $prev_page = "/admin"; } # Worst case scenario...

		if (!isset($event_type) && isset($this->params['form']['event_type'])) 
		{
			$event_type = $this->params['form']['event_type'];
		}
		if (!isset($listing_id) && isset($this->params['form']['listing_id'])) 
		{
			$listing_id = $this->params['form']['listing_id'];
		}

		if (!$listing_id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid listing', true));
			$this->redirect($prev_page);
		}
		if (!$event_type && empty($this->data)) {
			$this->Session->setFlash(__('Invalid status', true));
			$this->redirect($prev_page);
		}

		if ($event_type && $listing_id)
		{
			$time = $this->get_timestamp();
			$sold_listing = $this->SoldListing->read(null, $listing_id);
			$active_listing_id = $sold_listing["SoldListing"]["active_listing_id"];
			$buyer_id = $sold_listing["Sale"]["buyer_id"];
			$seller_id = $sold_listing["Sale"]["seller_id"];
			$seller = $this->User->read(null, $seller_id);
			$buyer = $this->User->read(null, $buyer_id);

			$this->ListingEvent->create();
			$this->ListingEvent->save(array(
				'type' => $event_type,
				'time'=>$time,
				'sold_listing_id' => $listing_id,
				'active_listing_id' => $active_listing_id,
			));

			$listings = array($sold_listing);
			$listing_total = 0;
			foreach ($listings as $listing)
			{
				$listing_total += $listing['SoldListing']['price'];
			}

			# There is no 'bulk' way to send an email out -- it's instantaneous, so
			# we will never realistically get more than one book mentioned per email!
			# Oh well.

			# Now we need to trigger emails, as appropriate....
			if (strtolower($event_type) == 'dropped')
			{
				$this->sendEmail($buyer, "Ready for Pick-up", "ready_pickup", array( "listings"=>$listings),'pickup');
				$this->sendEmail($seller, "Drop-off Receipt", "receipt_dropoff", array( "listings"=>$listings),'sales');

			} else if (strtolower($event_type) == 'accepted') {
				$this->sendEmail($buyer, "Pick-up Receipt", "receipt_pickup", array( "listings"=>$listings),'sales');
				$this->User->_sendSellerPayment($seller, $listing_total);

			} else if (strtolower($event_type) == 'paid') {
			} else if (strtolower($event_type) == 'canceled') {
			} else if (strtolower($event_type) == 'canceled') {
			} else if (strtolower($event_type) == 'refund') {
			} else if (strtolower($event_type) == 'returned') {
			}





			$this->redirect($prev_page);

		}
		$listing_events = $this->ListingEvent->findAll("sold_listing_id = '$listing_id'");
		foreach ($listing_events as $listing_event)
		{
			$type = $listing_event["ListingEvent"]["type"];
			$events[$type] = $listing_event;
		} # For referencing by name.
		$this->set("event_types", $this->ListingEvent->getEnumValues());
		$this->set("events", $events);
	}

	function refund($listing_id)
	# In case seller wants to cancel...
	{
		$listing = $this->SoldListing->read(null, $listing_id);
		if ($listing)
		{

			$this->Session->setFlash(__('Listing has been refunded to buyer', true));
		} else {
			$this->Session->setFlash(__('Invalid listing', true));
		}
		$this->redirect("/users/account");
	}

	function _admin_edit($id = null) {
		# So can add ListingEvents....
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SoldListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SoldListing->save($this->data)) {
				$this->Session->setFlash(__('The SoldListing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SoldListing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SoldListing->read(null, $id);
		}
		$users = $this->SoldListing->User->find('list');
		$books = $this->SoldListing->Book->find('list');
		$schools = $this->SoldListing->School->find('list');
		$sales = $this->SoldListing->Sale->find('list');
		$this->set(compact('users','books','schools','sales'));
	}

	function _admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SoldListing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SoldListing->del($id)) {
			$this->Session->setFlash(__('SoldListing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
