<div class="cartItems form">
<?php echo $form->create('CartItem');?>
	<fieldset>
 		<legend><?php __('Edit CartItem');?></legend>
	<?php
		echo $form->input('item_id');
		echo $form->input('user_id');
		echo $form->input('listing_id');
		echo $form->input('book_id');
		echo $form->input('quantity');
		echo $form->input('price');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CartItem.item_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CartItem.item_id'))); ?></li>
		<li><?php echo $html->link(__('List CartItems', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Active Listings', true), array('controller'=> 'active_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Active Listing', true), array('controller'=> 'active_listings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Books', true), array('controller'=> 'books', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book', true), array('controller'=> 'books', 'action'=>'add')); ?> </li>
	</ul>
</div>
