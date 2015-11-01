<?php
class CartItemsController extends AppController {

	var $name = 'CartItems';
	var $helpers = array('Html', 'Form');
	var $uses = array('CartItem','ActiveListing','SoldListing','Sale','ListingEvent','Book','Order');


	function beforeFilter() 
	{
		$this->Auth->allow('*');
		$this->Auth->deny('checkout','checkout_process'); # Require login only for checkout...
		parent::beforeFilter();
	}

	function index() {
		$this->CartItem->recursive = 0;
		$this->set("cartItems", $this->_mycartitems());
	}

	function _view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CartItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cartItem', $this->CartItem->read(null, $id));
	}

	# XXX TODO show page for cart summary (read-only) PLUS payment options (cc direct, or express checkout)

	function checkout() 
	{
		# if items in cart don't have user_id, set.
		$params = array();
		$user_id = $this->Session->read("Auth.User.user_id");
		$session_id = $this->Session->read("session_id"); # Only if session already exists!
		if ($session_id)
		{
			$items = $this->CartItem->find('all',array('conditions'=>"session_id = '$session_id'"));
			foreach ($items as $item)
			{
				$item["CartItem"]["user_id"] = $user_id;
				$item["CartItem"]["session_id"] = "";
				$this->CartItem->save($item);
			}
		}
		$this->set("cartItems", $this->_mycartitems());
	}

	function _mycartitems()
	{
		# Clear out cart so no items in it older than 15 mins.
		$this->CartItem->deleteAll("created_date IS NULL OR DATE_ADD(created_date, INTERVAL 15 MINUTE) < NOW()");

		$conditions = "";
		$anon_session_id = $this->Session->read("session_id");
		$user_id = $this->Session->read("Auth.User.user_id");
		if ($anon_session_id) { $conditions .= "session_id = '$anon_session_id'"; }
		if ($user_id) { $conditions .= ($conditions ? " OR " : "") . "CartItem.user_id = '$user_id'"; }

		error_log("CART CONDITIONS=$conditions");

		return $this->CartItem->find('all', array('conditions'=>$conditions));
	}

	function checkout_process($transaction_id = null)
	# Do actual CC processing... move items to sold_listings, create sales entry, listing_events
	{
		$user_id = $this->Session->read("Auth.User.user_id");
		$buyer = $this->Session->read("Auth.User");

		# Now get all entries with 'user_id'.
		#$items = $this->CartItem->find('all',array('conditions'=>"CartItem.user_id = '$user_id'"));
		$items = $this->_mycartitems();

		# If no items in cart, show error page...
		if (count($items) == 0)
		{
			$this->Session->setFlash(__('Sorry, there are no items in your cart to checkout.',true));
			$this->redirect(array('action'=>'index'));
		}

		#print_r($items);

		$timestamp = $this->get_timestamp();

		$total_price = 0;

		$i = 1;

		if ($total_price == 0)
		{
			$this->Session->setFlash(__('No items in cart.', true));
			$this->redirect(array('action'=>'index'));
		} else {
			# Process credit cards...

			# Create 'order' entry for all items.

			$this->Order->create();
			$this->Order->set('buyer_id', $user_id);
			$this->Order->set('time', $timestamp);
			$this->Order->save();
			$order_id = $this->Order->id;

			$listings = array();

			$total_price = 0;
			foreach ($items as $item) # Save listings to sold listings.
			{
				$listing_id = $item["CartItem"]["listing_id"];
				$cart_item_id = $item["CartItem"]['item_id'];

				$listing = $this->ActiveListing->read(null, $listing_id);
				$seller_id = $listing["ActiveListing"]["user_id"];
				$total_price += $listing["ActiveListing"]['price'];

				$seller = $this->User->read(null, $seller_id);

				# Create sales entry.... FOR EACH ITEM!
				$this->Sale->create(
					array(
						"buyer_id"=>$user_id,
						"seller_id"=>$seller_id,
						"sale_total"=>$total_price,
						"order_id"=>$order_id,
						"transaction_id"=>$transaction_id,
						"time"=>$timestamp,
					)
				);
				$this->Sale->save();
				$sale_id = $this->Sale->id;


				# Copy to 'SoldListing'...
				$soldlisting = $listing['ActiveListing']; # Not sure if need as $array['SoldListing'] or not...
				unset($soldlisting['paused']);
				unset($soldlisting['hold']);
				$soldlisting["sale_id"] = $sale_id;
				$soldlisting["active_listing_id"] = $listing_id; # Save to new field...
				unset($soldlisting["listing_id"]);

				$this->SoldListing->create($soldlisting);
				$this->SoldListing->save();
				$sold_listing_id = $this->SoldListing->id;

				# Create listing_events entry....
				$this->ListingEvent->create(
					array(
						'sold_listing_id'=>$sold_listing_id,
						'active_listing_id'=>$listing_id,
						'type'=>'sold',
						'time'=>$timestamp,
					)
				);
				$this->ListingEvent->save();

				$sold_listing = $this->SoldListing->read(null, $sold_listing_id);
				$listings[] = $sold_listing;

				$timestamp = date("m/d/Y H:i", (time() + 3*24*60*60)); # 3 days default...

				$this->sendEmail($seller, "You Sold a Book!", "book_sale", array("listings"=>array($sold_listing),"timestamp"=>$timestamp),'sales');

				# May have issue with extra fields being set.
				$this->ActiveListing->del($listing_id);

				# Finally, remove from cart.
				$this->CartItem->del($cart_item_id);
			}

			# Now send single email to buyer for all items....
			$this->sendEmail($buyer, "Order Confirmation", "order_confirm", 
				array("listings"=>$listings,"total"=>$total_price),'sales');


		}

	}

	function express_checkout($callback = null)
	{
	    $user_id = $this->Session->read("Auth.User.user_id");
	    if (!$user_id)
	    {
	    	$this->Session->setFlash(__('You need to be logged in to purchase items. Please login or create an account.',true));
		$this->redirect('/users/login');
	    }

	    if (isset($callback) && isset($_REQUEST['csid']))
	    {
	        // Restore session
	        
	        if (!$this->Payment->restoreUserSession($_REQUEST['csid']))
	        {
		    error_log("CANT RESTORE SESSION UPON PAYPAL CALLBACK!");
	            $this->redirect('/');
	            exit;
	        }
	    } else { # First time, need to have checked 'sales_process_verify'

	    	if (!isset($this->params['form']['sales_process_verify']))
		{
	    		$this->Session->setFlash(__('You must agree to understanding the Sales Process.',true));
			$this->redirect('/cart_items/checkout');
		}

	    }

	    # Load total in cart.
	    $cart_items = $this->CartItem->findAll("CartItem.user_id = '$user_id'");
	    $total = 0;
	    if (!count($cart_items))
	    {
	    	$this->Session->setFlash(__('There are no items in your cart to checkout.',true));
		$this->redirect('/cart_items');
	    }
	    foreach($cart_items as $item)
	    {
		$listing_id = $item['CartItem']['listing_id'];
		$book_id = $item['CartItem']['book_id'];
		$cart_item_id = $item['CartItem']['item_id'];
		if (!$this->ActiveListing->hasAny("listing_id = '$listing_id'")) # GONE. let them know.
		{
			# Delete from cart.
			$this->CartItem->del($cart_item_id);

			# provide link to buy page again.
			$bookinfo = $this->Book->read(null, $book_id);
			$this->set("book", $bookinfo);
			#print_r($bookinfo);
			$this->action = 'checkout_unavailablebook';
			return;
		}

	    	$total += $item['CartItem']['price'];
	    }

	    if ($total <= 0)
	    {
	    	$this->Session->setFlash(__('Items in cart do not have a price. Cannot checkout.',true));
		$this->redirect('/cart_items');
	    }

	    # Transaction information....
	    
	    // Neither buyer nor credit card information since it
	    // is handled by PayPal
	    
	    // Set up common component's parameters

	    if (!isset($callback))
	    {
	    	$result = $this->Payment->submitCheckout($total);
	        
	        if ($result === false)
	        {
	    	    $this->Session->setFlash(__('Unable to process payment: ' . $this->Payment->getError(), true));
	   	    $this->redirect("/cart_items/checkout");
	        }
	    }
	    else if ($callback == 'cancel')
	    {
	    	$this->Session->setFlash(__('Payment canceled.',true));
		$this->redirect("/cart_items");
	        #echo 'SNIFF... Why not?';
	        #exit;
	    }
	    else if ($callback == 'pay')
	    {
	        // Second call, make payment via PayPal

		$result = $this->Payment->getCheckoutResponse();
	        
	        // Check PayPal status
	        
	        if ($result === false)
	        {
	    	    $this->Session->setFlash(__('Unable to process payment: ' . $this->Payment->getError(), true));
	   	    $this->redirect("/cart_items/checkout");
	        }
	        else
	        {
		    # Save transaction_id into 'sales' so can do refund, etc...
		    $transaction_id = $result["transaction"];
		    $this->setAction('checkout_process', $transaction_id);
	        }
	    }
	}

	function add($listing_id = null) {
		if (!$listing_id) {
			$this->Session->setFlash(__('No item specified to add to cart. Please, try again.', true));
			$this->redirect("/books/buy");
		} else {
			if ($listing = $this->ActiveListing->read(null, $listing_id))
			{
				$book_id = $listing["ActiveListing"]["book_id"];

				# Make sure item isn't in anyone else's cart.
				if ($this->CartItem->hasAny("listing_id = '$listing_id'"))
				{
					$this->Session->setFlash(__("We're sorry, but this item is no longer available. Please select a different item.", true));
					$this->redirect("/books/view/$book_id");
				}
				$this->data["CartItem"]["listing_id"] = $listing_id;
				$this->data["CartItem"]["book_id"] = $book_id;
				if ($user_id = $this->Session->read("Auth.User.user_id"))
				{
					$this->data["CartItem"]["user_id"] = $user_id;
				} else {
					$this->data["CartItem"]["session_id"] = $this->get_session_id();
				}
				# May not be available if not logged in...
				$this->data["CartItem"]["price"] = $listing["ActiveListing"]["price"];
				$this->data["CartItem"]["quantity"] = 1;
				$this->data["CartItem"]["created_date"] = $this->get_timestamp();
			} else {
				$this->Session->setFlash(__('Unable to find book via listing_id. Please, try again.', true));
				$this->redirect("/books/buy");
			}
		}
		
		if (!empty($this->data)) {
			$this->CartItem->create();
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The book has been added to your cart', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The book could not be added to your cart. Please, try again.', true));
			}
		}
		$users = $this->CartItem->User->find('list');
		$activeListings = $this->CartItem->ActiveListing->find('list');
		$books = $this->CartItem->Book->find('list');
		$this->set(compact('users', 'activeListings', 'books'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The CartItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CartItem->read(null, $id);
		}
		$users = $this->CartItem->User->find('list');
		$activeListings = $this->CartItem->ActiveListing->find('list');
		$books = $this->CartItem->Book->find('list');
		$this->set(compact('users','activeListings','books'));
	}

	function delete($id = null) {
		
		$criteria = array();
		if ($user_id = $this->Session->read("Auth.User.user_id"))
		{
			$criteria[] = "CartItem.user_id = '$user_id'";
		}

		if ($sess_id = $this->Session->read("session_id"))
		{
			$criteria[] = "CartItem.session_id = '$sess_id'";
		}

		# If not own, ignore.
		if (!$id || !$this->CartItem->find(implode(" OR ", $criteria))) {
			$this->Session->setFlash(__('Invalid ID for cart item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CartItem->del($id)) {
			$this->Session->setFlash(__('Cart item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function _admin_index() {
		$this->CartItem->recursive = 0;
		$this->set('cartItems', $this->paginate());
	}

	function _admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CartItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cartItem', $this->CartItem->read(null, $id));
	}

	function _admin_add() {
		if (!empty($this->data)) {
			$this->CartItem->create();
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The CartItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
		$users = $this->CartItem->User->find('list');
		$activeListings = $this->CartItem->ActiveListing->find('list');
		$books = $this->CartItem->Book->find('list');
		$this->set(compact('users', 'activeListings', 'books'));
	}

	function _admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The CartItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CartItem->read(null, $id);
		}
		$users = $this->CartItem->User->find('list');
		$activeListings = $this->CartItem->ActiveListing->find('list');
		$books = $this->CartItem->Book->find('list');
		$this->set(compact('users','activeListings','books'));
	}

	function _admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CartItem->del($id)) {
			$this->Session->setFlash(__('CartItem deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
