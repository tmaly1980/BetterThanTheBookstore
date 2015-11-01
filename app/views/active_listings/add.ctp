<div class="activeListings form">
<?
	# Need to display book info... (so know what doing!)
	echo $this->element('book_info', array('book'=>$book));
?>
<?php echo $form->create('ActiveListing');?>
	<fieldset>
 		<legend><?php __('sell books');?></legend>
	<?php
		$session_user_id = $session->read("Auth.User.user_id");

		echo $form->hidden('book_id',array('value'=>$book["Book"]['book_id']));
		echo $form->hidden('isbn',array('value'=>$isbn));
		echo $form->input('condition_id',array('options'=>$conditions));
		echo $form->input('comments');
		echo $form->input('price');
	?>
		<?php if (($salestats['low_price'])) { ?>
		<div><label>Current Price Range:</label>$<?= sprintf("%.02f", $salestats['low_price']) ?> - $<?= sprintf("%.02f", $salestats['high_price']) ?></div>
		<? } ?>
		<?php if (($salestats['last_sold_price'])) { ?>
		<div><label>Last Sold Price:</label>$<?= sprintf("%.02f", $salestats['last_sold_price']) ?></div>
		<? } ?>
		<?php if (($salestats['avg_sold_price'])) { ?>
		<div><label>Average Sold Price:</label>$<?= sprintf("%.02f", $salestats['avg_sold_price']) ?></div>
		<? } ?>
		<?php if (($salestats['lowest_likenew_price'])) { ?>
		<div><label>Lowest Like New Price:</label>$<?= sprintf("%.02f", $salestats['lowest_likenew_price']) ?></div>
		<? } ?>
		<?php if (($book["Book"]['amazonRetailPrice'])) { ?>
		<div><label>Retail Price:</label>$<?= sprintf("%.02f", $book["Book"]["amazonRetailPrice"]) ?></div>
		<? } ?>
		<?php if (($book["Book"]['amazonListPrice'])) { ?>
		<div><label>Amazon List (New) Price:</label>$<?= sprintf("%.02f", $book["Book"]["amazonListPrice"]) ?></div>
		<? } ?>
		<?
			#echo $form->input("User.payment_email",array('value'=>$payment_email,'after'=>'<br/>Paypal email to send payments to'));
		?>
		<input type=checkbox name='valid_isbn_verify' value='1'> I am not knowingly listing this book under the wrong ISBN or under the wrong edition number<br/>
		<input type=checkbox name='condition_terminology_verify' value='1'> I understand the <A HREF="http://www.betterthanthebookstore.com/popups/condition.html" onClick="return popup(this,108)">Condition Terminology</A><br/>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
