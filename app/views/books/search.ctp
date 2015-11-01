<div class="books index">
<h2><?php __('Books');?></h2>
<p>
<?php
#echo $paginator->counter(array(
#'format' => __('Page %page% of %pages%, showing %start% - %end%', true)
#));
?></p>
<table class="book_list" cellpadding="0" cellspacing="0" width="100%" border=1>
<tr>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('isbn13');?></th>
	<th><?php echo $paginator->sort('author');?></th>
	<th><?php echo $paginator->sort('edition');?></th>
	<th><?php echo $paginator->sort('Publish Date / Publisher', 'pubdate');?></th>
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
			<?php echo $html->link($book['Book']['title'], "view/" . $book['Book']['book_id']); ?>
		</td>
		<td>
			<?php echo $book['Book']['isbn13']; ?>
			<?php 
				if ($pages = $book['Book']['pages'])
				{
					echo "<br/><br/>" . $book['Book']['pages'] . " pages";
				}
			?>
		</td>
		<td>
			<?php echo $book['Book']['author']; ?>
		</td>
		<td>
			<?php echo $book['Book']['edition']; ?>
		</td>
		<td>
			<? if ($book['Book']['pubdate'] && $book['Book']['pubdate'] != '0000-00-00') { 
				echo $time->format(null, $book['Book']['pubdate']);
				echo "<br/>"; 
			} 
			?>
			<?php echo $book['Book']['publisher']; ?>
		</td>
	</tr>
	<tr<?php echo $class;?>>
		<td>
			<a href="/books/view/<?= $book['Book']['book_id'] ?>">
				<img src="/books/cover/thumb/<?= $book['Book']['isbn13'] ?>">
			</a>
		</td>
		<td colspan=6 valign=top>
			Description:
			<?php 
				$d = $book['Book']['description']; 
				if (strlen($d) > 100) { $d = substr($d, 0,200) . "..."; }
				echo $d;
			?>
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
