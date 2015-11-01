<div class="cartItems view">
<h2><?php  __('CartItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cartItem['CartItem']['item_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cartItem['User']['user_id'], array('controller'=> 'users', 'action'=>'view', $cartItem['User']['user_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active Listing'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cartItem['ActiveListing']['listing_id'], array('controller'=> 'active_listings', 'action'=>'view', $cartItem['ActiveListing']['listing_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Book'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cartItem['Book']['title'], array('controller'=> 'books', 'action'=>'view', $cartItem['Book']['book_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cartItem['CartItem']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cartItem['CartItem']['price']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CartItem', true), array('action'=>'edit', $cartItem['CartItem']['item_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CartItem', true), array('action'=>'delete', $cartItem['CartItem']['item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartItem['CartItem']['item_id'])); ?> </li>
		<li><?php echo $html->link(__('List CartItems', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CartItem', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Active Listings', true), array('controller'=> 'active_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Active Listing', true), array('controller'=> 'active_listings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Books', true), array('controller'=> 'books', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book', true), array('controller'=> 'books', 'action'=>'add')); ?> </li>
	</ul>
</div>
