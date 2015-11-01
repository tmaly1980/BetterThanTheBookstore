<div class="books form">
<?php echo $form->create('Book');?>
	<fieldset>
 		<legend><?php __('Add Book');?></legend>
	<?php
		echo $form->input('isbn10');
		echo $form->input('isbn13');
		echo $form->input('title');
		echo $form->input('author');
		echo $form->input('format');
		echo $form->input('edition');
		echo $form->input('pubdate');
		echo $form->input('publisher');
		echo $form->input('pages');
		echo $form->input('image');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Books', true), array('action'=>'index'));?></li>
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
