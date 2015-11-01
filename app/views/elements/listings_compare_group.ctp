	<div class="listings_group">
		<div class="listings_group_header">
			Third-Party Comparison Items:
		</div>
		<div class="listing_item">
<?php
	if (count($compare_info))
	{
?>
		<table cellpadding=0 cellspacing=0 class="listing_row_table">
		<tr class="listing_column_header">
			<th>ITEM</th>
			<th>SOURCE</th>
			<th>CONDITION / COMMENTS</th>
			<th>PRICE</th>
		</tr>
		<?php
		$i = 0;
		foreach ($compare_info as $listing)
		{
			?>
			<tr class="book_listing <?= $i++ % 2 ? '' : 'altrow' ?>">
				<td class="listing_item">
					<img src="/books/cover/thumb/<?= $book['Book']['isbn13'] ?>">
				</td>
				<td class="listing_source">
					<?= $listing['name'] ?>
				</td>
				<td class="listing_comments">
					<?= $listing['condition_id'] ?>
				</td>
				<td class="listing_price">
					$<?= sprintf("%.2f", $listing['price']); ?>
					<a class="listing_addtocart" target="_new" href="<?= $listing['url'] ?>">
						Buy Now
					</a>
				</td>
			</tr>
			<?
		}
		?>
		</table>
<?
	} else {
	?>
		<div class="padded">
		Sorry, no books available for this type.
		</div>

	<?

	}
?>
		</div>
	</div>
