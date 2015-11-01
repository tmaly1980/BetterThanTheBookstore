<div class="users account">
<h2><?php  __('My Account');?></h2>
	<div class="pagelinksbar">
		<a href="/users/edit">Edit Account</a> |
		<a href="/users/change_password">Change Password</a>
	</div>
	<div class="clear"></div>

	<br/>
	<br/>
	<br/>

	<table class="active_listings_list">
	<tr>
		<th colspan=6 class="table_header">My Active Listings</th>
	</tr>
	<tr>
		<th>
			Author
		</th>
		<th>
			ISBN
		</th>
		<th>
			Condition
		</th>
		<th>
			Price
		</th>
		<th>
			Actions
		</th>
	</tr>
	<?
	$i = 0;
	foreach($active_listings as $active_listing)
	{
	?>
	<tr class="<?= $i % 2 == 0 ? 'altrow' : '' ?>">
		<td colspan=5 class="<?= $active_listing['ActiveListing']['paused'] ? 'strike' : '' ?>">
			<b><?= $active_listing['Book']['title'] ?></b>
			<? if ($active_listing['ActiveListing']['paused']) { ?>
				<b>* PAUSED *</b>
			<? } ?>
		</td>
	</tr>
	<tr class="<?= $i++ % 2 == 0 ? 'altrow' : '' ?>">
		<td>
			<?= $active_listing['Book']['author'] ?>
		</td>
		<td>
			<?= $active_listing['Book']['isbn13'] ?>
		</td>
		<td>
			<?= $active_listing['ActiveListing']['condition_id'] ?>
		</td>
		<td>
			<?= sprintf("$%.02f", $active_listing['ActiveListing']['price']) ?>
		</td>
		<td style="white-space: nowrap;">
			<a href="/active_listings/edit/<?= $active_listing['ActiveListing']['listing_id'] ?>">Edit Listing</a><br/>
			<? if (!$active_listing['ActiveListing']['paused']) { ?>
				<a href="/active_listings/pause/<?= $active_listing['ActiveListing']['listing_id'] ?>">Pause/Hide</a><br/>
			<? } else { ?>
				<a href="/active_listings/unpause/<?= $active_listing['ActiveListing']['listing_id'] ?>">Unpause/Show</a><br/>
			<? } ?>
			<a href="/active_listings/delete/<?= $active_listing['ActiveListing']['listing_id'] ?>">Remove</a>
		</td>
	</tr>
	<?
	}
	?>
	</table>
	<a href="/books/sell">Add New Listing</a>

</div>

<p class="maintext"><img src="http://www.betterthanthebookstore.com/design/img/study.jpg" alt="" width="425" height="282" /></p>