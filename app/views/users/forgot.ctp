<?php 
echo __('Send new password via email', true);

echo $form->create('User', array('action'=>'forgot')); 
echo $form->input('email', array('value'=>''));
echo $form->end('Submit');
?>
