<?php
require('./constant.php');
include __APPPATH__ . '/controller/authController.php';
// include './controller/authController.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h3> Login </h3>
    <form method="post">
        <!-- <input id="role" name="role" type="text" value="user" hidden /> -->
        <!-- <lable for="name"> Name: </lable>
        <input id="name" name="name" type="text" />
        <span name='name_error' id="name_error"></span> <br /> <br /> -->

        <lable for="email"> Email: </lable>
        <input id="email" name="email" type="email" />
        <span name='email_error' id="email_error"></span> <br /> <br />

        <lable for="password"> Password: </lable>
        <input id="password" name="password" type="password" />
        <span name='password_error' id="password_error"></span> <br /> <br />

        <button name="submit_btn"> Submit </button>
    </form>
</body>

</html>