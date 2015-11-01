<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['user_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('School'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($user['School']['name'], array('controller'=> 'schools', 'action'=>'view', $user['School']['school_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('School Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['school_email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['student_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Regdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['regdate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Verified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['verified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit User', true), array('action'=>'edit', $user['User']['user_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete User', true), array('action'=>'delete', $user['User']['user_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['user_id'])); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('action'=>'add')); ?> </li>
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
<div class="related">
	<h3><?php __('Related Active Listings');?></h3>
	<?php if (!empty($user['ActiveListing'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Listing Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Book Id'); ?></th>
		<th><?php __('School Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Condition Id'); ?></th>
		<th><?php __('Postdate'); ?></th>
		<th><?php __('Comments'); ?></th>
		<th><?php __('Hold'); ?></th>
		<th><?php __('Paused'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['ActiveListing'] as $activeListing):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $activeListing['listing_id'];?></td>
			<td><?php echo $activeListing['user_id'];?></td>
			<td><?php echo $activeListing['book_id'];?></td>
			<td><?php echo $activeListing['school_id'];?></td>
			<td><?php echo $activeListing['price'];?></td>
			<td><?php echo $activeListing['condition_id'];?></td>
			<td><?php echo $activeListing['postdate'];?></td>
			<td><?php echo $activeListing['comments'];?></td>
			<td><?php echo $activeListing['hold'];?></td>
			<td><?php echo $activeListing['paused'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'active_listings', 'action'=>'view', $activeListing['listing_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'active_listings', 'action'=>'edit', $activeListing['listing_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'active_listings', 'action'=>'delete', $activeListing['listing_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $activeListing['listing_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Active Listing', true), array('controller'=> 'active_listings', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Removed Listings');?></h3>
	<?php if (!empty($user['RemovedListing'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Listing Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Book Id'); ?></th>
		<th><?php __('School Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Condition Id'); ?></th>
		<th><?php __('Postdate'); ?></th>
		<th><?php __('Comments'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['RemovedListing'] as $removedListing):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $removedListing['listing_id'];?></td>
			<td><?php echo $removedListing['user_id'];?></td>
			<td><?php echo $removedListing['book_id'];?></td>
			<td><?php echo $removedListing['school_id'];?></td>
			<td><?php echo $removedListing['price'];?></td>
			<td><?php echo $removedListing['condition_id'];?></td>
			<td><?php echo $removedListing['postdate'];?></td>
			<td><?php echo $removedListing['comments'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'removed_listings', 'action'=>'view', $removedListing['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'removed_listings', 'action'=>'edit', $removedListing['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'removed_listings', 'action'=>'delete', $removedListing['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $removedListing['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Removed Listing', true), array('controller'=> 'removed_listings', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Sales');?></h3>
	<?php if (!empty($user['Sale'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Sale Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Total'); ?></th>
		<th><?php __('Time'); ?></th>
		<th><?php __('Listing Id'); ?></th>
		<th><?php __('Book Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Sale'] as $sale):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $sale['sale_id'];?></td>
			<td><?php echo $sale['user_id'];?></td>
			<td><?php echo $sale['total'];?></td>
			<td><?php echo $sale['time'];?></td>
			<td><?php echo $sale['listing_id'];?></td>
			<td><?php echo $sale['book_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'sales', 'action'=>'view', $sale['sale_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'sales', 'action'=>'edit', $sale['sale_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'sales', 'action'=>'delete', $sale['sale_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sale['sale_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Sale', true), array('controller'=> 'sales', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Sold Listings');?></h3>
	<?php if (!empty($user['SoldListing'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Listing Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Book Id'); ?></th>
		<th><?php __('School Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Condition Id'); ?></th>
		<th><?php __('Postdate'); ?></th>
		<th><?php __('Comments'); ?></th>
		<th><?php __('Sale Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['SoldListing'] as $soldListing):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $soldListing['listing_id'];?></td>
			<td><?php echo $soldListing['user_id'];?></td>
			<td><?php echo $soldListing['book_id'];?></td>
			<td><?php echo $soldListing['school_id'];?></td>
			<td><?php echo $soldListing['price'];?></td>
			<td><?php echo $soldListing['condition_id'];?></td>
			<td><?php echo $soldListing['postdate'];?></td>
			<td><?php echo $soldListing['comments'];?></td>
			<td><?php echo $soldListing['sale_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'sold_listings', 'action'=>'view', $soldListing['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'sold_listings', 'action'=>'edit', $soldListing['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'sold_listings', 'action'=>'delete', $soldListing['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $soldListing['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Sold Listing', true), array('controller'=> 'sold_listings', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
