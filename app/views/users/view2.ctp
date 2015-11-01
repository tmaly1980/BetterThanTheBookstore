<?php echo $this->element("member_edit_menu"); ?>
<div class="members view">

<table class="member_profile" cellpadding="0" cellspacing="0">
<tr>
	<td class="leftcol">
		<table class="member_photo_table" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2" class="member_photo_container">
					<img src="/images/sample/profile_image1.png">
				</td>
			</tr>
			<tr>
				<td align=left>
					<?= $member['Member']['firstname'] . " " . $member['Member']['lastname'] ?>
					<br/>
					<?php echo $member_years_old; ?> years old
					<br/>
					<?= $member['Member']['city'] . ", " . $member['Member']['state'] ?>
				</td>
				<td align=right align=bottom>
					<?php echo $member['Member']['member_type']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<br/>
					<br/>
					RATE THIS USER
					<br/>
					ADD TO BUDDY LIST
				</td>
				<td>
					<br/>
					<br/>
					LEAVE A MESSAGE
				</td>
			</tr>
		</table>
	</td>
	<td class="rightcol">
		<div><span class="label"><?php __('Gender:'); ?></span> <span class="value"><?php echo $member['MemberModelProfile']['gender'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Height:'); ?></span> <span class="value"><?php echo $member_height;?>&nbsp;</span></div>
		<div><span class="label"><?php __('Weight:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['weight'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Measurements:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['measurements'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Hair Color:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['hair_color'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Eye Color:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['eye_color'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Ethnicity:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['ethnicity'];?>&nbsp;</span></div>
		<div><span class="label"><?php __('Skin Tone:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['skintone'];?>&nbsp;</span></div>
		<div><br/></div>
		<div><span class="label"><?php __('Website:'); ?></span> <span class="value"> 
			<?php if ($url = $member['Member']['website']) {
				?>
				<a href="<?= $url ?>" target="_new"><?= $url ?></a>
				<?
			}
			?>
		&nbsp;</span>
		</div>
		<div><span class="label"><?php __('Member ID:'); ?></span> <span class="value"> <?php echo $member['Member']['username'];?>&nbsp;</span></div>
		<div><hr/></div>
		<div><span class="label"><?php __('Years Experience:'); ?></span> <span class="value"> <?php echo $member_years_experience;?>&nbsp;</span></div>
		<div><span class="label"><?php __('Availability:'); ?></span> <span class="value"> <?php echo $member['MemberModelProfile']['availability'];?>&nbsp;</span></div>
		<div><span class="label block"><?php __('About Me:'); ?></span> <span class="value"> <?php echo $member['Member']['about_me'];?></span></div>
	</td>
</tr>

</table>

<?php # Now show album ?>

<?= $this->element("member_album", array('member'=>$member)); ?>


</div>
