<p>Dear <?=$user["first"] ?>,

<p>Welcome to BetterThanTheBookstore.com!

<p><a href="<?php echo "http://$_SERVER[HTTP_HOST]/users/activate/$user[email]/$user[activation_code]"; ?>">
Please click here to verify your email</a> or, copy this link into your browser:

<p><?php echo "http://$_SERVER[HTTP_HOST]/users/activate/$user[email]/$user[activation_code]"; ?>

<p>Thank you,

<p>BetterThanTheBookstore.com
