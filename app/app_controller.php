<?php


class AppController extends Controller
{
	var $uses = array("School","User");
	var $components = array('Auth','Security','Payment','Paypal','Email');
	var $helpers = array('Time','HTML','Form');

	function beforeFilter()
	# child controller needs to say $this->Auth->allow('*') or allow('action1','action2') ...
	{
		if (defined('CRON')) { $this->Auth->allow('*'); } # Can do anything via cron....
		error_log("CRON=".defined('CRON'));

		#error_log("BEFORE_FILT");
		#$this->Auth->allow('forgot','signup','activate','view','index','browse','search','migratePasswords'); # Anonymous pages....
		$this->Auth->userScope = array('User.verified' => 1);
                $this->Auth->loginRedirect = array('controller'=>'books','action'=>'home'); 
                $this->Auth->logoutRedirect = array('controller'=>'books','action'=>'index'); # Go to homepage
                $this->Auth->loginError = 'Unable to login. Did you <a href="/users/forgot">forget your password?</a> Did you activate your account by clicking the link in your signup email?';
		$this->Auth->authError = 'Please login or create an account to access this page.';
                $this->Auth->userModel = 'User';
		$this->Auth->fields = array('username'=>'email','password'=>'password');

		#error_log("PARAMSADMIN=".print_r($this->params,true));

		if (isset($this->params['admin']))
		{
			#$this->forceAdminSession();
			$this->checkAdminSession();
			# Not sure how to get working, no time!
			# Disable for now since no way to manage user accounts via web...
		}

		# If no school_id cookie set, and not logged in, force back to splash page...
		$school_id = $this->Session->read("school_id");
		$user_school_id = $this->Session->read("Auth.User.school_id");

		#error_log(print_r($this->params,true));
		$page = strtolower($this->params['url']['url']);
		$controller = strtolower($this->params['controller']);

		#error_log("PAGE=$page, CONT=$controller");

		if (!defined('CRON') && !$school_id && !$user_school_id && ($page != 'books/index' && $page != 'books' && !preg_match("/books\/topsellers_xml/", $page) && $controller != 'users'))
		{
			error_log("REDIRECTING TO /BOOKS $page PAGE, $controller CONTROLLER");
			$this->redirect("/books");
		}
        }

	function forceAdminSession()
	{
		$this->Security->loginOptions = array(
			'type'=>'basic',
			'realm' => 'BTTB Management Office'
		);

		$this->Security->loginUsers = array(
			'admin'=>'sqP.u/7n1wkuk',
			'tomas'=>'bttbbttb',
		);

		$this->Security->requireLogin();
	}

   	function checkAdminSession() {  
   		// if the admin session hasn't been set  
		$authorized = false;

		if (!$this->isAdminAuthorized())
		{
   			// set flash message and redirect  
			$this->Security->requireLogin();
   		}  
	}

	function isAdminAuthorized()
	{
		# Either is_admin flag set in DB (good to not have web interface so not abused), or email in list.
		$email = $this->Session->read("Auth.User.email");
		$is_admin = $this->Session->read("Auth.User.is_admin");
		if ($is_admin) { return true; }

		if (false && $email) # Disable for now....
		{
			$authorized_emails = include(APP . "config/managers_authorized.php");
			#error_log(print_r($authorized_emails,true));
	
			foreach($authorized_emails as $authemail)
			{
				# Acceptable formats (regex matching):
				# tomas@laptop.malysoft.com
				# .*@laptop.malysoft.com
				# .*@betterthanthebookstore.com
				# heather@betterthanthebookstore.com
				#
				#error_log("CAS $authemail =~ $email");
				if (preg_match("/^$authemail$/", $email))
				{
					return true;
				}
			}
		}

		return false;

   	}  

	function get_school_options($optional = '')
	{
		$options = array();
		if ($optional) { $options[] = $optional; } # Optional text.
		$schools = $this->School->findAll();
		foreach ($schools as $school)
		{
			$options[$school["School"]["school_id"]] = 
				$school["School"]["name"];
		}

		return $options;
	}

	function get_school_id()
	{
		$school_id = $this->Session->read("Auth.User.school_id");
		#error_log("SESS2=".print_r($this->Session->read(), true));
		if (!$school_id)
		{
			$school_id = $this->Session->read("school_id");
			#error_log("MANUAL SCHOOL_ID=$school_id");
		}
		return $school_id;
	}

	function beforeRender()
	{
		#error_log("CALLING BEFORE RENDER...". print_r($this->params,true));
		# We need this stuff BEFORE auth, so can show up on LOGIN page....
		if ($school_id = $this->get_school_id())
		{
			#error_log("SCHOOL IS=$school_id");
			$this->set("school_info", $this->School->find("school_id = '$school_id'"));
			$this->set("school_id", $school_id);
		}
		$this->set("is_admin", $this->isAdminAuthorized());

		# If file 'preorder' exists within 'app', set preorder flag.
		if (file_exists(dirname(__FILE__)."/PREORDER"))
		{
			$this->set("is_preorder", true);
		}
	}

	function setError($msg, $model = null)
	{
		$this->setMessage($msg, $model); # For now, do same thing.
	}

	function setMessage($msg, $model = null)
	{
		$merged_msg = $msg;
		if ($model)
		{
			$model_errors = $model->validationErrors;
			if ($model_errors && count($model_errors))
			{
				$merged_msg .= "<br/><br/>Reason: ";
				foreach($model_errors as $model_field => $model_error)
				{
					$merged_msg .= "<br/> $model_field: $model_error";
				}
			}
		}
		$this->Session->setFlash(__($merged_msg, true));
	}

	function sendEmail($user, $subject, $template, $vars = array(), $from = 'info')
	# Likely pass $this->data, $this->data["User"], or $this->data["User"]["email"] (tho cant read info in latter)
	{
		$bcc_email = 'heather@betterthanthebookstore.com'; # Where all copies go.
		
		if (is_array($user) && isset($user["User"])) { $user = $user["User"]; } # So can $user['email'], etc
		$user_email = is_array($user) ? $user["email"] : $user;
		if (!$user_email) { $this->Session->setFlash("Unable to send email. No email address found."); return false; }

		#error_log("USER=$user, SUB=$subject, TEM=$template");

		if (!preg_match('/@/', $from)) { $from = "$from@betterthanthebookstore.com"; }
		# If relative username, set to domain!

		$this->Email->reset();
		$this->Email->from = $from;
		$this->Email->to = $user_email;
		$this->Email->bcc = $bcc_email;
		$this->Email->subject = $subject;
		$this->Email->template = $template;
		$this->Email->sendAs = 'html';

		if (is_array($user)) { $this->set("user", $user); } # If we do not pass, we can't read name, act codes, etc.

		foreach ($vars as $var => $value)
		{
			$this->set($var, $value);
		}

		return $this->Email->send();
	}

	function get_timestamp($time = null)
	{
		if (!$time) { $time = time(); }
		$ts = date("Y-m-d H:i:s", $time);
		return $ts;
	}

	function get_session_id($generate = true)
	{
		$session_id = $this->Session->read("session_id");
		if (!$session_id && $generate) # Only create a new one if not set already
		{
			$session_id = $this->User->generate_code(64);
			$this->Session->write('session_id', $session_id);
		}
		return $session_id;
	}


}

?>
