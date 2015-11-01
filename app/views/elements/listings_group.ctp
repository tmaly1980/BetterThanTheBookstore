<?php
	#echo "BOOK=";
	#print_r($book);
	#echo "COUNT=".count($book["MySchoolActiveListing"])."\n";
	$relevant_listings = array();

	foreach($book["MySchoolActiveListing"] as $listing)
	{
		#echo "COND=$listing[condition_id], THIS=$condition_id\n";
		if ($listing["condition_id"] == $condition_id)
		{
			array_push($relevant_listings, $listing);
		}
	}
	?>
	<div class="listings_group">
		<div class="listings_group_header">
			<?= $condition_id ?> Items:
		</div>
		<div class="listing_item">
	<?
	if (count($relevant_listings))
	{
?>
		<table cellpadding=0 cellspacing=0 class="listing_row_table">
		<tr class="listing_column_header">
			<th>ITEM</th>
			<th>CONDITION / COMMENTS</th>
			<th>PRICE</th>
		</tr>
		<?php
		$i = 0;
		foreach ($relevant_listings as $listing)
		{
			?>
			<tr class="book_listing <?= $i++ % 2 ? '' : 'altrow' ?>">
				<td class="listing_item">
					<img src="/books/cover/thumb/<?= $book['Book']['isbn13'] ?>">
				</td>
				<td class="listing_comments">
					<?= $listing['comments'] ?>
				</td>
				<td class="listing_price">
					$<?= sprintf("%.2f", $listing['price']); ?>
					<? if (!$compare_mode) { ?>
					<a class="listing_compare" href="/books/view/<?= $book['Book']['book_id']; ?>/compare">
						Compare
					</a>
					<? } ?>
					<a class="listing_addtocart" href="/cart_items/add/<?= $listing['listing_id'] ?>">
						Add To Cart
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
