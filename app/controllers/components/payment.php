<?
/*
	For consolidating payment processing, etc all into one location.

*/

class PaymentComponent extends Object
{
	var $name = 'BTTBPay';
	var $components = array('Paypal');

	var $test_paypal = 1; # Test transactions...

	function startup(&$controller)
	{

	}

	function setAuthentication()
	{
	    if ($this->test_paypal)
	    {
	    	# Test buyer account: (for paypal login), for purchase simulation
		# email: scottjbecker@gmail.com
		# password: 218828700
		# or?
		# testbuyer@betterthanthebookstore.com
		# testbuyer1

		#
	    	# sandbox email login for seller (us): test@betterthanthebookstore.com
		# developer.paypal.com login:
	    	# test account:
	    	#scottjbecker@gmail.com
		#paypal46p
	    	error_log("TESTING PAYPAL SANDBOX....");
	    	$this->Paypal->setEnvironment(CAKE_COMPONENT_PAYPAL_ENVIRONMENT_SANDBOX);
	    	$this->Paypal->setUser('test_api1.betterthanthebookstore.com');
		$this->Paypal->setPassword('SJ4F9UADSJV6DPW4');
	    	$this->Paypal->setCertificate(dirname(__FILE__).'/../../paypal_sandbox.pem');
		# May need to snoop around for sandbox account info.... (if this doesnt work)
	    } else {
	    	# Production account:
	    	# BTTBsales@betterthanthebookstore.com
	    	# betterbooks123
	    	$this->Paypal->setEnvironment(CAKE_COMPONENT_PAYPAL_ENVIRONMENT_LIVE);
	    	$this->Paypal->setUser('BTTBsales_api1.betterthanthebookstore.com');
		$this->Paypal->setPassword('FSJQGLM7LJPMGREL');
	    	$this->Paypal->setCertificate(dirname(__FILE__).'/../../paypal_live.pem');
	    }
	}

	function submitCheckout($total) # May want to someday support passing items,?
	{
	    $order = array(
	        'action' => CAKE_COMPONENT_PAYPAL_ORDER_TYPE_SALE,
	        'description' => 'BetterThanTheBookstore.com Book Order',
	        'total' => $total,
	    );
	    $this->Paypal->setOrder($order);

	    $this->setAuthentication();

            // First call, user gets redirected to PayPal
    
    	    $path = "http://".$_SERVER['HTTP_HOST']."/cart_items/express_checkout";
        
            $this->Paypal->setTokenUrl("$path/pay?csid=" . session_id());
            $this->Paypal->setCancelUrl("$path/cancel?csid=" . session_id());
            
            // Save current session
            
            $this->Paypal->storeSession();
        
            // Make payment via PayPal
            
            $result = $this->Paypal->expressCheckout();

	    return $result;
	}

	function getCheckoutResponse()
	{
	        $result = $this->Paypal->expressCheckout();
		return $result;
	}

	function restoreSession($csid)
	{
	        return $this->Paypal->restoreSession($csid);
	}

	function getError()
	{
		return $this->Paypal->getError();
	}

	function submitMassPayment($sales)
	{
		# Assumes we have Book, Sales, Seller
		# Need email, note (bttb, book & isbn), amount, uniqueId, 
		$order = array();
		foreach ($sales as $sale)
		{
			$sale_total = $sale['Sales']['sale_total'];
			$bttb_profit = 0.15 * $sale_total;
			if ($bttb_profit < 3) { $bttb_profit = 3; }
			$amount = $sale_total - $bttb_profit;
			# We get 15% or $3, whichever is more.

			$order[] = array(
				'email'=>$sale['Seller']['email'],
				'note'=>"BetterThanTheBookstore.com, " . $sale['Book']['title'] . ", " . $sale['Book']['isbn13'],
				'amount'=>$amount,
				'uniqueId'=>$sale['Sales']['sale_id'],
			);
		}

		print_r($order);
		#exit(0);
		$this->Paypal->setOrder($order);

		return $this->Paypal->massPayment();
		# If failure (false), calling code can call 'getError()'
	}


}

?>
