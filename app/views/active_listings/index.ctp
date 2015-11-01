<div class="activeListings index">
<h2><?php __('ActiveListings');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('listing_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('book_id');?></th>
	<th><?php echo $paginator->sort('school_id');?></th>
	<th><?php echo $paginator->sort('price');?></th>
	<th><?php echo $paginator->sort('condition_id');?></th>
	<th><?php echo $paginator->sort('postdate');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('hold');?></th>
	<th><?php echo $paginator->sort('paused');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($activeListings as $activeListing):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $activeListing['ActiveListing']['listing_id']; ?>
		</td>
		<td>
			<?php echo $html->link($activeListing['User']['user_id'], array('controller'=> 'users', 'action'=>'view', $activeListing['User']['user_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($activeListing['Book']['title'], array('controller'=> 'books', 'action'=>'view', $activeListing['Book']['book_id'])); ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['school_id']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['price']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['condition_id']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['postdate']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['comments']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['hold']; ?>
		</td>
		<td>
			<?php echo $activeListing['ActiveListing']['paused']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $activeListing['ActiveListing']['listing_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $activeListing['ActiveListing']['listing_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $activeListing['ActiveListing']['listing_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $activeListing['ActiveListing']['listing_id'])); ?>
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
