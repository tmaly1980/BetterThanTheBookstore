<div class="cartItems index">
<h2><?php __('Checkout Cart');?></h2>
<table cellpadding="0" cellspacing="0" class="list">
<tr>
	<th>Book</th>
	<th>ISBN</th>
	<th>Condition</th>
	<th>Price</th>
</tr>
<?php
$i = 0;
$total_price = 0;
foreach ($cartItems as $cartItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	$total_price += $cartItem['CartItem']['price'] * $cartItem['CartItem']['quantity'];

?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $cartItem['Book']['title']; ?>
		</td>
		<td>
			<?php echo $cartItem['Book']['isbn13']; ?>
		</td>
		<td>
			<?php echo $cartItem['ActiveListing']['condition_id']; ?>
		</td>
		<td>
			$<?php echo sprintf("%.02f", $cartItem['CartItem']['price']); ?>
		</td>
	</tr>
<?php endforeach; ?>
	<tr>
		<th colspan=2>
		</th>
		<th>
			Total:
		</th>
		<th>
			$<?= sprintf("%.02f", $total_price) ?>
		</th>
	</tr>
</table>
</div>
<p>
	<!--
		url is THEIRS
		pass OUR account information?
		token to reference transaction?
	-->
	<form method='POST' action='/cart_items/express_checkout'>
	<input type=checkbox name='sales_process_verify' value='1'> I have read and understand the
	<?
		if ($is_preorder)
		{
			echo "<A HREF='http://www.betterthanthebookstore.com/popups/preorder.html' onClick='return popup(this,106)'>Pre-Order Process</A> and ";
		}
		echo "<A HREF='http://www.betterthanthebookstore.com/popups/sales.html' onClick='return popup(this,107)'>Sales Process</A>";
	?><br/>
	<input type='submit' value='Checkout' name='submit'>
	<!--<img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" align="left" style="margin-right:7px;"> -->
	</form>
</p>
