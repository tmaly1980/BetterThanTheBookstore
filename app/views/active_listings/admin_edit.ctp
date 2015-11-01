<div class="activeListings form">
<?php echo $form->create('ActiveListing');?>
	<fieldset>
 		<legend><?php __('Edit ActiveListing');?></legend>
	<?php
		echo $form->input('listing_id');
		echo $form->input('user_id');
		echo $form->input('book_id');
		echo $form->input('school_id');
		echo $form->input('price');
		echo $form->input('condition_id');
		echo $form->input('postdate');
		echo $form->input('comments');
		echo $form->input('hold');
		echo $form->input('paused');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ActiveListing.listing_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ActiveListing.listing_id'))); ?></li>
		<li><?php echo $html->link(__('List ActiveListings', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Books', true), array('controller'=> 'books', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book', true), array('controller'=> 'books', 'action'=>'add')); ?> </li>
	</ul>
</div>
