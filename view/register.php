<?php

require('../constant.php');
include __APPPATH__ . '/controller/authController.php';
// var_dump($GLOBALS);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="../assets/auth.js" ></script>
</head>

<body>
    <h3> Register </h3>
    <form id="registerForm" method="post">
        <input id="role" name="role" type="text" value="user" hidden />
        <lable for="name"> Name: </lable>
        <input id="name" name="name" type="text" />
        <span name='name_error' id="name_error"> <?php echo $authControllerObj->errors['name_error']; ?> </span> <br /> <br />

        <lable for="email"> Email: </lable>
        <input id="email" name="email" type="email" />
        <span name='email_error' id="email_error"> <?php echo $authControllerObj->errors['email_error']; ?> </span> <br /> <br />

        <lable for="password"> Password: </lable>
        <input id="password" name="password" type="password" />
        <span name='password_error' id="password_error"> <?php echo $authControllerObj->errors['password_error']; ?> </span> <br /> <br />
        <span> <?php echo $authControllerObj->errors['general_error']; ?> </span> <br/> <br/>
        <button name="register_btn"> Register </button>
        <a href="../index.php" > Login </a>

    </form>
</body>

</html>