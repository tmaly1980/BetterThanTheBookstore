<h2>BetterThanTheBookstore.com Management Office</h2>

<p>Select a task from the following list:

<form action="/admin/sold_listings/list_by_student_id" method="POST">
<table>
	<tr>
		<th colspan=2 align=left><h3>Manage/Find Sold Books:</h3></th>
	</tr>
	<tr>
		<td>By Seller's Student ID#:</td>
		<td>
			<input type=text name="seller_student_id">
		</td>
	</tr>
	<tr>
		<td>By Buyer's Student ID#:</td>
		<td>
			<input type=text name="buyer_student_id">
		</td>
	</tr>
	<tr>
		<td colspan=2 align=right>
			<input type=submit name="submit" value="Find">
		</td>
	</tr>
</table>
</form>

<h3>Other Tasks:</h3>
<ul>
	<li>
		<a href="/admin/users/masspay_report">View Payment Report</a>
	</li>
	<li>
		<a href="/admin/active_listings/pause_all" onClick="return confirm('Are you SURE you want to pause/hide ALL active listings?');">Pause all active listings</a> (pre semester)
	</li>
	<li>
		<a href="/admin/users/notify_sellers_schoolstart">Notify sellers for book drop off</a> (pre semester)
	</li>
	<li>
		<a href="/admin/users/send_email">Send Bulk Email</a>
	</li>
</ul>

