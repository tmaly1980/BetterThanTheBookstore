<div class="cartItems index">
<h2><?php __('Items in Your Cart');?></h2>
<table cellpadding="0" cellspacing="0" class="list">
<tr>
	<th>Book</th>
	<th>ISBN</th>
	<th>Condition</th>
	<th>Price</th>
	<th class="actions"><?php __('Actions');?></th>
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
			<?php echo $html->link($cartItem['Book']['title'], array('controller'=> 'books', 'action'=>'view', $cartItem['Book']['book_id'])); ?>
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
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $cartItem['CartItem']['item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartItem['CartItem']['item_id'])); ?>
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
	<tr>
		<th colspan=3>
			
		</th>
		<th>
			<a href="/cart_items/checkout">Checkout</a>
		</th>
	</tr>
</table>
</div>
<div>
<p>
	<a href="/books/buy">Go back</a> to buy more books
</p>
<p>
</p>
</div>
