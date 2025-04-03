<?php
session_start();
require('./constant.php');
include __APPPATH__ . '/controller/authController.php';
$_SESSION['isUserPresentAlready'] = false;
$_SESSION['currentUserEmail'];
$_SESSION['isLogin'];
$_SESSION['role'];
$_SESSION['Credential_error'];

if ($_SESSION['isLogin'] == true && $_SESSION['role'] == 'admin') {
    header('Location: ./view/adminHome.php');
    exit();
} elseif ($_SESSION['isLogin'] == true && $_SESSION['role'] == 'user') {
    header("Location: ./view/userHome.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="./assets/auth.js"></script>
</head>

<body>
    <h3> Login </h3>
    <form id="loginForm" method="post">
        <lable for="email"> Email: </lable>
        <input id="email" name="email" type="email" />
        <span name='email_error' id="email_error"> <?php echo $authControllerObj->errors['email_error']; ?> </span> <br /> <br />
        
        <lable for="password"> Password: </lable>
        <input id="password" name="password" type="password" />
        <span name='password_error' id="password_error"> <?php echo $authControllerObj->errors['password_error']; ?> </span> <br /> <br />
        
        <span name='common_error' id="common_error"> <?php echo $authControllerObj->errors['general_error']; ?> </span> <br /> <br />
        <button name="submit_btn"> Submit </button>
        <a href="./view/register.php"> Register </a>
    </form>
</body>

</html>

<!-- read all the rules and add at the end of the AdminHome page. -->