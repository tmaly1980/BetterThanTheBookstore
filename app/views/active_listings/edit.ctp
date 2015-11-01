<div class="activeListings form">
<?
	# Need to display book info... (so know what doing!)
	echo $this->element('book_info', array('book'=>$book));
	$isbn = $book["Book"]['isbn13'];
?>
<?php echo $form->create('ActiveListing');?>
	<fieldset>
 		<legend><?php __('Edit Listing');?></legend>
	<?php
		$session_user_id = $session->read("Auth.User.user_id");

		echo $form->hidden('listing_id');
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
			echo $form->input("User.payment_email",array('value'=>$payment_email,'after'=>'<br/>Paypal email to send payments to'));
		?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
