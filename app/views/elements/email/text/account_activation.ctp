Dear <?=$user["first"] ?> <?=$user["last"] ?>,

Welcome to BetterThanTheBookstore.com!

Email: <?=$user["email"] ?>

Please click below to activate your account:

<?php echo "http://$_SERVER[HTTP_HOST]/users/activate/$user[email]/$user[activation_code]"; ?>


Activation is required to login and buy/sell books.

Thanks,
TheBetterThanBookstore.com Team!
