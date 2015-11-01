<div class="books index">
<h2><?php __('Books');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('book_id');?></th>
	<th><?php echo $paginator->sort('isbn10');?></th>
	<th><?php echo $paginator->sort('isbn13');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('author');?></th>
	<th><?php echo $paginator->sort('format');?></th>
	<th><?php echo $paginator->sort('edition');?></th>
	<th><?php echo $paginator->sort('pubdate');?></th>
	<th><?php echo $paginator->sort('publisher');?></th>
	<th><?php echo $paginator->sort('pages');?></th>
	<th><?php echo $paginator->sort('image');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($books as $book):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $book['Book']['book_id']; ?>
		</td>
		<td>
			<?php echo $book['Book']['isbn10']; ?>
		</td>
		<td>
			<?php echo $book['Book']['isbn13']; ?>
		</td>
		<td>
			<?php echo $book['Book']['title']; ?>
		</td>
		<td>
			<?php echo $book['Book']['author']; ?>
		</td>
		<td>
			<?php echo $book['Book']['format']; ?>
		</td>
		<td>
			<?php echo $book['Book']['edition']; ?>
		</td>
		<td>
			<?php echo $book['Book']['pubdate']; ?>
		</td>
		<td>
			<?php echo $book['Book']['publisher']; ?>
		</td>
		<td>
			<?php echo $book['Book']['pages']; ?>
		</td>
		<td>
			<?php echo $book['Book']['image']; ?>
		</td>
		<td>
			<?php echo $book['Book']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $book['Book']['book_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $book['Book']['book_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $book['Book']['book_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $book['Book']['book_id'])); ?>
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
		<li><?php echo $html->link(__('New Book', true), array('action'=>'add')); ?></li>
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
