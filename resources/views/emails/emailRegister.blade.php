<html>
<body>

Hello <?php echo $username; ?>,<br>
<br>
You have submitted request to register an account with us.<br>
<br>
This email is a confirmation for your registration. If you think this is a mistake, please ignore the email. If not, please confirm the registration by clicking on the following link:<br>
<br>
{{$_ENV['HOST_NAME']}}/verifyEmail/<?php echo $token; ?><br>
<br>
We hope you have a pleasant experience with us and look forward to serve you in the near future.<br>
<br>
Thanks.<br>

BTCPanda Team
</body>
</html>