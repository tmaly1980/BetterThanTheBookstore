<div class="pagelinksbar">
	<a href="/admin">Management Page</a>
</div>
<div class="admin sold_listings list_by_student_id">
<h3>Items for <?= $type ?>: <?= $student["User"]["first"] ?> <?= $student["User"]["last"] ?> (Student ID#<?= $student_id ?>)</h3>

<table class="admin_listings">
	<tr>
		<th>Book</th>
		<th>ISBN</th>
		<th>Price</th>
		<th>Buyer / Seller</th>
		<th>Status</th>
	</tr>
<?
	$i = 0;
	if (!count($listings))
	{
	?>
		<tr>
			<th colspan=5>
				Sorry, no items found.
			</th>
		</tr>

	<?

	}
	foreach ($listings as $listing)
	{
	?>
		<tr class=" <? $i++ % 2 == 0 ? 'altrow' : '' ?> ">
         			<td class="listing_item" align=center>
					<a href="/books/view_byisbn/<?= $listing['Book']['book_id'] ?>">
                                        	<img src="/books/cover/thumb/<?= $listing['Book']['isbn13'] ?>">
						<br/>
						<?= $listing['Book']['title'] ?>
					</a>
                                </td>
                                <td class="listing_isbn">
                                        <?= $listing['Book']['isbn13'] ?>
                                </td>
                                <td class="listing_price">
                                        $<?= sprintf("%.2f", $listing['SoldListing']['price']); ?>
                                </td>
                                <td class="">
					<nobr>
					<a target="_new" href="/admin/users/view/<?= $listing['Seller']['user_id'] ?>">
					View Seller
					</a>
					<br/>
					<a target="_new" href="/admin/users/view/<?= $listing['Buyer']['user_id'] ?>">
					View Buyer
					</a>
					</nobr>
                                </td>
				<td align=right>
					<nobr>
					<form method="POST" action="/admin/sold_listings/set_event/<?= $listing['SoldListing']['listing_id'] ?>">
						<input type=hidden name="prev_page" value="/admin/sold_listings/list_by_student_id/<?= $type ?>_student_id:<?= $student_id ?>">
					<?
						$marked_events = array();
						foreach($listing['ListingEvent'] as $event)
						{
							echo ucfirst($event['type']) . ": $event[time]<br/>\n";
							$marked_events[strtolower($event['type'])] = true;
						}
						echo "<select name='event_type'><option value=''>[Set Status]</option>\n";
						foreach ($event_types as $event_type)
						{
							if (!isset($marked_events[strtolower($event_type)]))
							{
								echo "<option value='$event_type'>$event_type</option>\n";
							}
						}
					?>
						</select>
						<input type=submit name='submit' value='Set'>
					</form>
					</nobr>
				</td>
		</tr>
	<?
	}
?>
</table>

</div>

