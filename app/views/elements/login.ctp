<h1 class="title">login</h1>
<?php 
echo $form->create('User', array('type'=>'post','action'=>'login')); 
echo $form->input('email', array('value'=>''));
echo $form->input('password', array('value'=>''));
echo $form->end('Login');

echo "<p>If you do not have an account, <a href='/users/signup'>Signup Here</a></p>";
#echo "<p>If you have forgotten your password, <a href='/users/forgot'>Retrieve Your Password</a></p>";
?>
<p class="maintext"><img src="http://www.betterthanthebookstore.com/design/img/reading.jpg" alt="" width="425" height="282" /></p>
