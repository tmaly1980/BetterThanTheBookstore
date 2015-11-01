<h1 class="title">register</h1>
<p>Not registered yet? Registration is fast and free!</p>

<div class="users form">
<?php echo $form->create("User", array('action'=>'signup')); 
?>
	<fieldset>

<!--		<legend><?php __('User Signup'); ?></legend>  -->
	
		<table class="editform">
	<?php
		echo $html->tableCells(array(
			array(
				'<strong>First Name:</strong>',
                $form->input('first',array('size'=>30,'label'=>'')),
			),
			
			array(
				'<strong>Last Name:</strong>',
				$form->input('last',array('size'=>30,'label'=>'')),
			),
			
			array(
				'<strong>School:</strong>',
				$form->input('school_id',array('options'=>$schools,'label'=>'')),
			),
			
			array(
				'<strong>School Email:</strong>  <A HREF="http://www.betterthanthebookstore.com/popups/paypal.html" onClick="return popup(this,101)">PayPal Info</A>',
				$form->input('email',array('size'=>30,'label'=>'')),
			),

			array(
				'<strong>Student ID#:</strong> <A HREF="http://www.betterthanthebookstore.com/popups/schoolID.html" onClick="return popup(this,102)">What Is This</A>',
				$form->input('student_id',array('size'=>30,'label'=>'',)),
			),

			array(
				'<strong>Telephone:</strong> <A HREF="http://www.betterthanthebookstore.com/popups/why.html" onClick="return popup(this,103)">Why We Need This</A>',
				$form->input('phone',array('size'=>30,'label'=>'')),
			),

			array(
				'<strong>Password:</strong>',
				$form->input('password',array('size'=>30,'type'=>'password','value'=>'','label'=>'')),
			),

			array(
				'<strong>Re-Type Password:</strong>',
				$form->input('password2',array('size'=>30,'type'=>'password','value'=>'','label'=>'')),
			),

			array(
				'<strong>How Did You Hear Of Us?</strong>',
				$form->input('referral',array('size'=>30,'label'=>'')),
			),

			array(
				'<strong>Agree To <A HREF="http://www.betterthanthebookstore.com/popups/terms.html" onClick="return popup(this,104)">Terms of Service</A></strong>',
				$form->radio('TOS',array('label'=>'')),
			),

			array(
				'Take&nbsp;a&nbsp;look&nbsp;at&nbsp;our&nbsp;<A HREF="http://www.betterthanthebookstore.com/popups/privacy.html" onClick="return popup(this,105)">PayPal&nbsp;Info</A>.&nbsp;In&nbsp;short,&nbsp;we&nbsp;do not share your information with anyone. Ever.',
				'',
				),

		));
	?>
		</table>
	</fieldset>

<?php echo $form->end("Signup"); ?>
</div>
<p class="maintext"><img src="http://www.betterthanthebookstore.com/design/img/reading.jpg" alt="" width="425" height="282" /></p>