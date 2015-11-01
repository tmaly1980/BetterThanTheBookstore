<div class="users form">
<?php echo $form->create("User", array('action'=>'edit')); 
$form->hidden('user_id');
?>
	<fieldset>
		<legend><?php __('Edit Account'); ?></legend>
		<table class="editform">
	<?php
		echo $html->tableCells(array(
			array(
				$form->input('first',array('label'=>'First Name')),
				$form->input('last',array('label'=>'Last Name')),
			),
			array(
				$form->input('school_id',array('options'=>$schools,'label'=>'School','disabled'=>'disabled')),
				$form->input('email',array('size'=>30,'label'=>'Valid School Email','after'=>'<br/>Verification via your school email is required for account activation.')),
			),
			array(
				#$form->input('username',array('label'=>'Desired Username','disabled'=>'disabled')),
				#$form->input('username',array('label'=>'Desired Username')),
				$form->input('payment_email',array('size'=>30,'label'=>'Paypal Email','after'=>'<br/>For receiving payments only')),
			),

			array(
				$form->input('phone',array('label'=>'Phone Number','after'=>'<br/>Numbers only, no dashes or parentheses allowed')),
				$form->input('student_id',array('label'=>'Student ID#','after'=>'<br/>Required for pickup/dropoff verification')),

			),

		));
	?>
		</table>
	</fieldset>

<?php echo $form->end("Save Account"); ?>
</div>
