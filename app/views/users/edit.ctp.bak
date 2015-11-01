<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('user_id');
		echo $form->input('school_id');
		echo $form->input('school_email');
		echo $form->input('email');
		echo $form->input('password');
		echo $form->input('first');
		echo $form->input('last');
		echo $form->input('phone');
		echo $form->input('student_id');
		echo $form->input('regdate');
		echo $form->input('verified');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('User.user_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.user_id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Schools', true), array('controller'=> 'schools', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New School', true), array('controller'=> 'schools', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Active Listings', true), array('controller'=> 'active_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Active Listing', true), array('controller'=> 'active_listings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Removed Listings', true), array('controller'=> 'removed_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Removed Listing', true), array('controller'=> 'removed_listings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Sales', true), array('controller'=> 'sales', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sale', true), array('controller'=> 'sales', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Sold Listings', true), array('controller'=> 'sold_listings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sold Listing', true), array('controller'=> 'sold_listings', 'action'=>'add')); ?> </li>
	</ul>
</div>
