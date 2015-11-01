<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Email','Session','Auth');
	var $uses = array('User','ActiveListing','SoldListing','ListingEvent');

	function beforeFilter()
	{
		if (!defined('CRON')) # Preserve acl's in app_controller if CRON ran.
		{
			$this->Auth->allow('forgot','signup','activate','index','browse','search','migratePasswords'); # Anonymous pages....
		}
		$redir = $this->Session->read('Auth.redirect');

		#error_log("REDIR=$redir");

		if ($redir == '/books/index' || $redir == '/books')
		{
			#$this->Auth->autoRedirect = false;
			error_log("REDIRECTING...");
			$this->Auth->redirect($this->Auth->loginRedirect); # Go to default redir page, not back!
		}

		parent::beforeFilter();
	}

	function index() {
		if ($sess_id)
		{
			$this->setAction("edit");
		} else {
			$this->setAction("login");
		}
		#$this->User->recursive = 0;
		#$this->set('users', $this->paginate());
	}

	function login()
	{
	}

	function logout()
	{
		$this->redirect($this->Auth->logout());
		# Not sure what this means?!?!?! but goes to '/'
	}

	function forgot()
	{
		if (!empty($this->data)) # Specified email to send new password to.
		{
			$email = $this->data['User']['email'];
			error_log("searching for email = $email");
			$user = $this->User->find("email = '$email'");

			# Somehow there's a disconnect from findByEmail to saveField...
			# (since it creates a new record!!!!)

			if ($user)
			{ # FOUND!
				error_log("FOUND!=");
				#print_r($user);
				# XXX TODO (email send, regen password)
				
				$user_id = $user["User"]["user_id"];

				$new_password = $this->User->generate_password();

				# SET...
				#$id = $this->User->user_id = $user["User"]['user_id'];
				#$id = $this->User->id = $user["User"]['user_id'];
				#error_log( "ID=$id\n");
				$enc_password = $this->Auth->password($new_password);
				$this->User->id = $user["User"]['user_id'];
				$this->User->saveField("password", $enc_password);
				
				#$user["User"]["password"] = $enc_password;
				#$this->User->save($user);
				if (! $this->sendEmail($email, "Password Change", "password_change",
					array("new_password" => $new_password, "user" => $user["User"]))
				)
				{
					$this->Session->setFlash("Unable to send email, internal error.");
				} else {
					$this->Session->setFlash("Password changed. You should recieve an email shortly.");
					$this->redirect(array('action'=>"login"));
					# HOW do we specify to go to ANOTHER page after login?
					# ie not default to current page...
				}
			
			} else { # Doesn't exist.
				$this->Session->setFlash(__('Sorry, that email does not exist.', true));
			}


		}

	}

	function change_password()
	{
		$sessid = $this->Session->read("Auth.User.user_id");
		
		if (!empty($this->data)) # Sent back...
		{
			# If user_id isn't theirs, BARF!
			$id = $this->data["User"]["user_id"];
			if ($id !== $sessid)
			{
				$this->Session->setFlash('Unauthorized. You are not this user.');
				return;
			}

			$password = $this->data["User"]["password"];
			$password2 = $this->data["User"]["password2"];
			$enc_password2 = $this->Auth->password($password2);

			$enc_password = strlen($password) > 32 ? $password : $this->Auth->password($password);
			# not sure why not encrpting! grr...
			$this->data["User"]["password"] = $enc_password;

			error_log("EP=$enc_password, P2=$password2, EP2=$enc_password2");
	
			if ($enc_password != "") # Changing...
			{
				if (strlen($password2) < 6)
				{
					$this->Session->setFlash('Password too short. Must be 6 or more characters.');
					return; # Go straight to error page
				}
				else if ($enc_password != $enc_password2) 
				{
					$this->Session->setFlash("Passwords do not match.");
					return; # Go straight to error page
				}

				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('Your password has been changed', true));
					$this->redirect(array('action'=>'account'));
				} else {
					$this->Session->setFlash(__('Your password could not be saved. Please, try again.', true));
				}
			}

		} # Else display form
		#$this->data["User"] = array();
		#$this->data["User"]["user_id"] = $sessid;
		$this->data = $this->User->read(null, $sessid);
		# All we really need anyway.
	}

	function migratePasswords()
	{
		# XXX at some point, allow admin-only access....

		header("Content-Type: text/plain");
		# pEncrypt does encryption, found in include/encryption.php
		include "encryption/encryption.php";

		$total = $this->User->find('count',array('conditions'=>'User.password IS NULL'));

		if ($total == 0) { echo "# All passwords have already been migrated. No further operations required.\n"; exit(0); }

		$perpage = 500;
		echo "# Operates in chunks of $perpage. $total remaining. Reload to perform next chunk.\n";


		$users = $this->User->find('all', 
			array(
				'fields' => array('User.old_password','User.user_id'), 
				'limit'=>$perpage,
				'conditions' => array('User.password IS NULL'),
			)
		);

		#$users = $this->User->findAll();
		foreach ($users as $user)
		{
			$old_password = $user["User"]["old_password"];
			$user_id = $user["User"]["user_id"];
			$decrypted = decrypt($old_password);
			$encrypted = $this->Auth->password($decrypted);
			echo "$user_id: $old_password => $decrypted => $encrypted\n";
			$user["User"]["password"] = $encrypted;
			$this->User->save($user);
		}

		exit(0);
	}

	function account() {
		$user_id = $this->Session->read("Auth.User.user_id");
		$this->set('user', $this->Session->read("Auth.User"));
		# Load 'ActiveListings' for user and 'SoldListings' for user. SORT SO NOTICED....
		$this->set('active_listings', $this->ActiveListing->findAll("ActiveListing.user_id = '$user_id'"));
		# 
	}

	function _add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('controller'=>'books','action'=>'home'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		$schools = $this->User->School->find('list');
		$this->set(compact('schools'));
	}

	function edit() {
		# NEEDS TO BE SELF ONLY!
		$id = $this->Session->read('Auth.User.user_id'); # Try own.

		if (!empty($this->data)) { # SAVING form values....
			if (isset($this->data["User"])) # Editing user profile...
			{
				$this->_saveUser();
			}
		}

		$user = $this->User->read(null, $id);
		$this->data["User"] = $user["User"];
		# etc for album, etc...

		$this->set('user', $user); # !!!! we need this to access !!!!
		$this->set('user_id', $id); # !!!! we need this to access !!!!
		# So we have ALL fields, even ones we cannot change....

		#$this->set("user_id", $id);
		$this->set("schools", $this->get_school_options());

	}

	function _saveUser()
	{
		# Manage password change...
		# If empty string, delete key, so dont erase.
		# Else, verify matching.
		#
		# XXX TODO

		# Need to set day for since-experience so no barfing...

		if ($this->User->save($this->data)) {
			$this->Session->setFlash(__('The account has been saved', true));
			#$this->redirect(array('action'=>'view'));
		} else {
			$this->Session->setFlash(__('Could not save account information', true));
			#$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
		}
	}

	function signup()
	{
		if (!empty($this->data))
		{
			error_log(print_r($this->data,true));
			$email = $this->data['User']['email'];

			# Make sure password matches password2, at least 6 chars.
			$enc_password = $this->data['User']['password'];
			$password2 = $this->data['User']['password2'];

			# BECAUSE the $password gets encoded, we need to check length
			# against password2 and compare with the encrypted version of password2
			$enc_password2 = $this->Auth->password($password2);

			$school_id = $this->data["User"]["school_id"];

			$school_info = $this->School->find("school_id = '$school_id'");
			$school_domain = $school_info["School"]["domain"];

			if (!preg_match("/$school_domain\$/", $email))
			{
				$this->Session->setFlash(__("Email must be a valid school email (@$school_domain)",true));
			}
			else if (strlen($password2) < 6)
			{
				$this->Session->setFlash(__('Password too short. Must be 6 or more characters.',true));
			}
			else if ($enc_password != $enc_password2) 
			{
				$this->Session->setFlash(__("Passwords do not match.",true));
			}
			else if ($this->User->hasAny(array('email' => $email)))
			# Verify email not already signed up....
			{
				$this->Session->setFlash(__('Email already in use. Choose another or <a href="/users/forgot">retrieve your password</a>.',true));
				# Hopefully this will display on THIS page, and not require a redirect.
			} else {
				# All good, do actual signup...
				$this->User->create();

				# XXX DO NOT LET LOG IN UNLESS verified = 1.

				# Set registration_code. 
				$this->data["User"]["activation_code"] = $this->User->generate_activation_code();
				$this->data["User"]["regdate"] = $this->get_timestamp();

				if ($this->User->save($this->data))
				{
					$this->Session->setFlash(__('Account created', true));
					# Send out email confirmation.... with password, email, etc.


					$sent = $this->sendEmail($this->data, "BetterThanTheBookstore.com Email Verification",
						"account_activation", array(), 'verify');
					if (!$sent)
					{
						$error = "Could not send account activation email for user=".print_r($this->data,true);
						error_log($error);
						$this->Session->setFlash(__("Could not send account activation email. Please contact us instead.",true));
					}

					# redirect to thank you page, with login form. 
					$this->set('email', $email);
					$this->action = "signup_thanks";
				} else {
					$this->setError(__("Cannot create account",true), $this->User);

				}
			}
		}

		$this->set("schools", $this->get_school_options());

	}

	function activate($email = null, $activation_code = null)
	{
		if (!$email || !$activation_code) { 
			$this->Session->setFlash(__('Invalid paramters', true)); 
		}
		$user = $this->User->find("email = '$email'");
		error_log(print_r($user,true));
		if ($user["User"]["verified"])
		{
				$this->Session->setFlash(__('Account already active.', true));
		}
		else if ($user["User"]["activation_code"] != $activation_code)
		{
				$this->Session->setFlash(__('Could not activate account. Codes do not match.', true));
		} else { # VALID!
			$user["User"]["activation_code"] = null;
			$user["User"]["verified"] = 1;
			if (!$this->User->save($user))
			{
				$this->Session->setFlash(__('Could not activate account. Internal Error.', true));
			} else {
				$this->Session->setFlash(__('Account activated. You may now log in.', true));
				$this->redirect(array('action'=>'login'));
				#$this->redirect(array('action'=>'login'), null, true);
			}
		}
	}

	function admin_notify_sellers_schoolstart() # Email all sellers with sold books when school is about to start.
	{
		#
		# Should this be ALL sellers or just ones who've already sold book?

		# Conditions: where has sold event but not 'dropped' event.
		# Get user id's.
		$listings = $this->User->query("
			SELECT User.*, Listing.*, Book.*
			FROM 
				users User,
				book Book,
				sold_listings Listing,
				listing_events sold LEFT JOIN
				listing_events dropped
				ON sold.sold_listing_id = dropped.sold_listing_id
			WHERE
				User.user_id = listing.user_id AND
				Listing.listing_id = sold.sold_listing_id AND
				Listing.book_id = Book.book_id AND
				dropped.sold_listing_id IS NULL
			");
		# Will have an entry PER BOOK!

		$users = array();
		foreach ($listings as $listing)
		{
			$user_id = $listing["User"]["user_id"];
			$users[$user_id][] = $listing;
		}

		ob_implicit_flush();
		header("Content-Type: text/plain");
		$x = count($users);
		echo "# Processing $x sellers...\n";

		$i = 0;
		foreach ($users as $user_id => $listings)
		{
			$user = $listings[0]["User"];
			$this->sendEmail($user, "Book Dropoff Reminder", "book_sale", array('user'=>$user,'listings'=>$listings));
			# May want to change content.
			$n = count($listings);
			echo "$user[email] ($n books)\n";
			if ($i++ % 25 == 0)
			{
				$j = $x - $i;
				echo "# $i processed, $j remaining...\n";
			}
		}

		echo "Done!\n";

		exit();
	}

	function admin_send_email() # Bulk emailer todo...
	{
		if (!empty($this->data))
		{
			$subject = $this->data["subject"];
			$content = $this->data["content"];
			$school_id = $this->data["school_id"];
			$from = "sales@betterthanthebookstore.com";

			$conditions = '';
			if ($school_id != '')
			{
				$conditions = "school_id = '$school_id'"; # Just ppl at certain school...
			}

			# Process.
			# send emails in bulk of 10.
			# update browser per 10
			$users = $this->User->findAll($conditions);

			ob_implicit_flush();
			header("Content-Type: text/plain");
			$x = count($users);
	
			$i = 0;
			$group = 25;
			# Group recipients into 25
			$recipient_groups = array();

			echo "# Processing $x members in groups of $group...\n";

			$g = 0;
			$x = 0;
			foreach ($users as $user)
			{
				if ($x++ % $group == 0)
				{
					$g++;
				}
				$recipient_groups[$g][] = $user['email'];
			}

			$gc = count($recipient_groups);

			echo "# Groups to process: $gc\n";

			$g = 0;
			foreach ($recipient_groups as $group)
			{
				$bcclist = "";
				foreach ($group as $user_email)
				{
					$bcclist .= "Bcc: $user_email\r\n";
				}
				# Generate email raw content!

				$headers = "From: $from\r\n";
				$headers .= $bcclist;

				mail($to, $subject, $content, $headers);

				# May want to change content.
				echo "$bcclist\n";
				$gn = $gc - $g;
				echo "# Group $g processed...$gn remaining\n";
			}
	
			echo "Done!\n";
	
			exit();
		}

		$this->set("schools", $this->get_school_options('[All Schools]'));

		# Form, with subject and content.
	}

	function _get_processed_seller_payments()
	{
		$yesterday = date('Y-m-d', time() - 24*60*60);
		$yesterday_morn = "$yesterday 00:00:00";
		$yesterday_night = "$yesterday 23:59:59";

		$payments = $this->User->query("
			SELECT 
				Sales.*,
				Book.*,
				Buyer.*,
				Listing.*,
				Seller.*
			FROM
				users Buyer,
				users Seller,
				sales Sales,
				sold_listings Listing,
				books Book,
				listing_events Paid 
			WHERE
				Paid.type = 'paid' AND
				Book.book_id = Listing.book_id AND
				Sales.buyer_id = Buyer.user_id AND
				Sales.seller_id = Seller.user_id AND
				Sales.sale_id = Listing.sale_id AND
				Listing.listing_id = Paid.sold_listing_id AND
				Paid.time BETWEEN '$yesterday_morn' AND '$yesterday_night'
		");

		return $payments;
	}

	function _get_pending_seller_payments()
	{
		# Accepted but not paid yet.
		$payments = $this->User->query("
			SELECT 
				Sales.*,
				Book.*,
				Buyer.*,
				Listing.*,
				Seller.*
			FROM
				users Buyer,
				users Seller,
				sales Sales,
				books Book,
				sold_listings Listing,
				listing_events Accepted 
			WHERE
				Book.book_id = Listing.book_id AND
				Sales.buyer_id = Buyer.user_id AND
				Sales.seller_id = Seller.user_id AND
				Sales.sale_id = Listing.sale_id AND
				Listing.listing_id = Accepted.sold_listing_id AND
				Accepted.type = 'accepted' AND
				Accepted.sold_listing_id NOT IN 
				(
					SELECT sold_listing_id FROM listing_events WHERE type = 'paid'
				)
		");

		return $payments;
	}

	function masspay_submit() # Was only stalling cuz trying to load invalid template file....
	{
		header('Content-Type: text/plain');
		ob_implicit_flush();

		$pending_payments = $this->_get_pending_seller_payments();
		if (!count($pending_payments))
		{
			echo "NO PAYMENTS TO SEND\n";
			exit(0);
		}
		#error_log("PENDING PAY1=".print_r($pending_payments,true));

		# Format so nice and simple for processing.
		$this->Payment->setAuthentication();
		if ($this->Payment->submitMassPayment($pending_payments))
		{
			error_log("PENDING PAY2=".print_r($pending_payments,true));
			echo "SUCCESS\n";

			#exit(0); # XXX REMOVE ONCE FIGURE OUT BUG PROBLEM...

			# Now add entries for 'paid', based off of payment information.
			foreach ($pending_payments as $payment)
			{
				$listing = $payment['Listing'];
				error_log("PAY=".print_r($payment,true));
				# Create 'paid' record.
				$this->ListingEvent->create(
					array(
						'sold_listing_id' => $listing['listing_id'],
						'active_listing_id' => $listing['active_listing_id'],
						'type' => 'paid',
						'time' => $this->get_timestamp()
					)
				);
				$this->ListingEvent->save();

				# Notify user? Nothing for now....
			}
		} else { # Failure! Send email out to 'BTTBsales'
			$headers = 'From: BTTBsales@betterthanthebookstore.com';
			$content = $this->Payment->getError();
			mail('BTTBsales@betterthanthebookstore.com', 'Mass Payment Failure', $content, $headers);

			echo "FAILURE:\n";
			echo $content;
		}
		exit(0);
	}

	function admin_masspay_report()
	{
		# Call same code as masspay_submit does...
		$pending_payments = $this->_get_pending_seller_payments();
		$this->set("pending_payments", $pending_payments);

		$processed_payments = $this->_get_processed_seller_payments();
		$this->set("processed_payments", $processed_payments);
	}

	function edit_alt($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$schools = $this->User->School->find('list');
		$this->set(compact('schools'));
	}

	function _delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('controller'=>'books','action'=>'home'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('controller'=>'books','action'=>'home'));
		}
	}


	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		$schools = $this->User->School->find('list');
		$this->set(compact('schools'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$schools = $this->User->School->find('list');
		$this->set(compact('schools'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
