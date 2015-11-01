<table width="100%">
<?
foreach ($listings as $listing)
{
	if (!$listing || empty($listing)) { continue; } # Skip odd empty entries (ie half-completed transactions)
?>
	<tr>
		<td style="width: 75px;">
			<img src="http://<?= $_SERVER['HTTP_HOST'] ?>/books/cover/thumb/<?= $listing['Book']['isbn13'] ?>">
		</td>
		<td>
			<div>
				<?= $listing['Book']['title'] ?>
			</div>
			<div>
				ISBN: <?= $listing['Book']['isbn13'] ?>
			</div>
			<div>
				Price: $<?= sprintf("%.02f", $listing['SoldListing']['price']) ?>
			</div>
			<div>
				<?= $listing['SoldListing']['condition_id'] ?> Condition
				<?
					if ($comments = $listing['SoldListing']['comments'])
					{
						echo ": $comments";
					}
				?>
			</div>
			<div>
				Sale ID: <?= $listing['SoldListing']['sale_id'] ?>
			</div>
		</td>
	</tr>
<?
}
?>
</table>
