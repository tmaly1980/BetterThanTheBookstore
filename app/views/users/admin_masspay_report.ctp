<h2>Payment Reports</h2>

<h3>Pending Payments:</h3>

<? if (!empty($pending_payments)) { ?>
<table border=1 width="500">
	<tr>
		<th>Sale ID</th>
		<th>Book</th>
		<th>ISBN</th>
		<th>Buyer / Seller</th>
		<th>Sale Date</th>
		<th>Sale Amount</th>
	</tr>
	<? foreach ($pending_payments as $pending) {  # Sales, Book, Buyer, Seller ?>
	<tr>
		<td>
			<?= $pending['Sales']['sale_id'] ?>
		</td>
		<td>
			<?= $pending['Book']['title'] ?>
		</td>
		<td>
			<?= $pending['Book']['isbn13'] ?>
		</td>
		<td>
			<nobr>
			<a target="_new" href="/admin/users/view/<?= $pending['Seller']['user_id'] ?>">
			View Seller
			</a>
			<br/>
			<a target="_new" href="/admin/users/view/<?= $pending['Buyer']['user_id'] ?>">
			View Buyer
			</a>
			</nobr>
		</td>
		<td>
			<?= $pending['Sales']['time'] ?>
		</td>
		<td>
			$<?= sprintf("%.02f", $pending['Sales']['sale_total']) ?>
		</td>
	</tr>
	<? } ?>
</table>

<? } else { ?>
	No pending payments found for processing.
<? } ?>

<h3>Successfully Processed Payments:</h3>

<? if (!empty($processed_payments)) { ?>
<table border=1 width="500">
	<tr>
		<th>Sale ID</th>
		<th>Book</th>
		<th>ISBN</th>
		<th>Buyer / Seller</th>
		<th>Sale Date</th>
		<th>Sale Amount</th>
	</tr>
	<? foreach ($processed_payments as $processed) {  # Sales, Book, Buyer, Seller ?>
		<tr>
		<td>
			<?= $processed['Sales']['sale_id'] ?>
		</td>
		<td>
			<?= $processed['Book']['title'] ?>
		</td>
		<td>
			<?= $processed['Book']['isbn13'] ?>
		</td>
		<td>
			<nobr>
			<a target="_new" href="/admin/users/view/<?= $processed['Seller']['user_id'] ?>">
			View Seller
			</a>
			<br/>
			<a target="_new" href="/admin/users/view/<?= $processed['Buyer']['user_id'] ?>">
			View Buyer
			</a>
			</nobr>
		</td>
		<td>
			<?= $processed['Sales']['time'] ?>
		</td>
		<td>
			$<?= sprintf("%.02f", $processed['Sales']['sale_total']) ?>
		</td>
		</tr>
	<? } ?>
</table>

<? } else { ?>
	No processed payments found for yesterday.
<? } ?>


