<?
if (isset($show_best_price))
{
	$best_price = 0;
	if (isset($book['MySchoolActiveListing']))
	{
		foreach ($book['MySchoolActiveListing'] as $listing)
		{
			$listingprice = $listing['price'];
			if ($listingprice < $best_price || $best_price == 0)
			{
				$best_price = $listingprice;
			}
		
		}
	}
}

?>
<div class="bookdetail">
		<div class="bookcover">
			<img src="/books/cover/full/<?= $book['Book']['isbn13'] ?>">
		</div>
		<div class="bookinfo">
			<div class="infoheader">Product Details:</div>
			<div class="booktitle"><?= $book['Book']['title'] ?></div>
			<div class="author">Author: <?= $book['Book']['author'] ?></div>
			<div class="format">Format: <?= $book['Book']['format'] ?></div>
			<div class="isbn">ISBN: <?= $book['Book']['isbn13'] ?></div>
			<? if ($book["Book"]['edition']) { ?><div class="edition">Edition: <?= $book['Book']['edition'] ?></div><? } ?>
			<div class="publisher">Publisher: <?= $book['Book']['publisher'] ?></div>
			<div class="pubdate">Pub Date: <?= $time->format('m/Y', $book['Book']['pubdate']) ?></div>
			<? 
			if (isset($show_best_price))
			{
				if ($best_price > 0) 
				{ 
				  echo "<div class='bestprice'>BTTB Best Price: $" . sprintf("%.2f", $best_price) . "</div>\n";
				} else {
				  echo "<div class='bestprice'>No books available at this school</div>\n";
				}
			} 
			?>
		</div>
	</div>

	<div class="clear"></div>

