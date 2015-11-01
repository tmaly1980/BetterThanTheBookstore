<?php
if ($session->check('Message.auth')) $session->flash('auth');


echo $this->element('login');

?>

