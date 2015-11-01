<div class="cartItems index">
<h2><?php __('CartItems');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('item_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('listing_id');?></th>
	<th><?php echo $paginator->sort('book_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('price');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cartItems as $cartItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $cartItem['CartItem']['item_id']; ?>
		</td>
		<td>
			<?php echo $html->link($cartItem['User']['user_id'], array('controller'=> 'users', 'action'=>'view', $cartItem['User']['user_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($cartItem['ActiveListing']['listing_id'], array('controller'=> 'active_listings', 'action'=>'view', $cartItem['ActiveListing']['listing_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($cartItem['Book']['title'], array('controller'=> 'books', 'action'=>'view', $cartItem['Book']['book_id'])); ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['quantity']; ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['price']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $cartItem['CartItem']['item_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $cartItem['CartItem']['item_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $cartItem['CartItem']['item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartItem['CartItem']['item_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New CartItem', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Active Listings', true), array('controller'=> 'active_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Active Listing', true), array('controller'=> 'active_listings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Books', true), array('controller'=> 'books', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book', true), array('controller'=> 'books', 'action'=>'add')); ?> </li>
	</ul>
</div>
