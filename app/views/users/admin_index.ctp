<div class="users index">
<h2><?php __('Users');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('school_id');?></th>
	<th><?php echo $paginator->sort('school_email');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('password');?></th>
	<th><?php echo $paginator->sort('first');?></th>
	<th><?php echo $paginator->sort('last');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('student_id');?></th>
	<th><?php echo $paginator->sort('regdate');?></th>
	<th><?php echo $paginator->sort('verified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['user_id']; ?>
		</td>
		<td>
			<?php echo $html->link($user['School']['name'], array('controller'=> 'schools', 'action'=>'view', $user['School']['school_id'])); ?>
		</td>
		<td>
			<?php echo $user['User']['school_email']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php echo $user['User']['password']; ?>
		</td>
		<td>
			<?php echo $user['User']['first']; ?>
		</td>
		<td>
			<?php echo $user['User']['last']; ?>
		</td>
		<td>
			<?php echo $user['User']['phone']; ?>
		</td>
		<td>
			<?php echo $user['User']['student_id']; ?>
		</td>
		<td>
			<?php echo $user['User']['regdate']; ?>
		</td>
		<td>
			<?php echo $user['User']['verified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $user['User']['user_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $user['User']['user_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $user['User']['user_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['user_id'])); ?>
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
		<li><?php echo $html->link(__('New User', true), array('action'=>'add')); ?></li>
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
