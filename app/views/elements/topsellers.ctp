<h2>Top Sellers:</h2>
<div class="topseller_list">
<?php
	$topsellers = $this->requestAction("/books/topsellers");

	#print_r($topsellers);

	$i = 1;
	if (!count($topsellers))
	{
		echo "<div><b>No top seller information available for this school</b></div>";
	} else {
		foreach ($topsellers as $topseller)
		{
	?>
		<div class="topseller_item">
			<a href="/books/view/<?= $topseller['books']['book_id'] ?>" class="topseller_image">
				<img class="" src="/books/cover/thumb/<?= $topseller["books"]["isbn13"] ?>">
			</a>
			<a href="/books/view/<?= $topseller['books']['book_id'] ?>" class="topseller_title">
				<?= $topseller["books"]["title"]; ?>
			</a>
			<div class="topseller_author">
				<? $authors = split(", ", $topseller["books"]['author']); echo $authors[0]; ?>
			</div>
			<? if ($topseller[0]["lowestprice"]) { ?>
			<div class="topseller_bestprice">
			BTTB Best Price: $<?= sprintf("%.02f", $topseller[0]["lowestprice"]) ?>
			<? } ?>
			</div>
		</div>
	<?php
			if ($i > 0 && $i++ % 3 == 0) { echo "<div class='clear'></div>"; } # 3 per line
		}
	}
?>

</div>
<div class="clear"></div>
