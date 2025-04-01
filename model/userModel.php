<?php

include('../constant.php');
include __APPPATH__ . '/constant.php';
include __APPPATH__ . '/dbConnection.php';

class userModel
{
    public $isConnect;

    public function __construct()
    {
        $db = new database();
        $this->isConnect = $db->dbConnection();
        // var_dump($this->isConnect); exit;
        if ($this->isConnect) {
            echo "<script> console.log('Database was connected with the model.'); </script>";
        } else {
            echo "<script> console.log('*ERROR: Database was not connected with the model.'); </script>";
        }

        $this->createAuthTable();
    }

    public function authentication($email, $password)
    {

        $admin = "SELECT * FROM auth WHERE Role = 'admin'";
        $adminData = $this->isConnect->query($admin);

        // admin auth
        if ($adminData->num_rows > 0) {
            $row = $adminData->fetch_assoc();
            $varifyPassword = password_verify($password, $row['Password']);
            if ($email == $row['Email'] && $varifyPassword) {
                echo "<script> console.log('Admin fatched sucessfully!') </script>";
                header('Location: /Game1/view/adminHome.php ');
                exit;
            }
        } else {
            echo " ADMIN not found";
        }

        // now we check for the user.
        $user = " SELECT * FROM auth WHERE Role = 'user'";
        $userResult = $this->isConnect->query($user);
        $userlist = [];

        if ($userResult->num_rows > 0) {
            while ($row = $userResult->fetch_assoc()) {
                $userlist[] = [
                    'id' => $row['Id'],
                    'name' => $row['Name'],
                    'email' => $row['Email'],
                    'password' => $row['Password']
                ];
            }
        }

        foreach ($userlist as $user) {
            $varifyPassword = password_verify($password, $user['Password']);
            if ($user['email'] == $email && $varifyPassword) {
                header("Location: ./Game1/view/userHome.php ");
                exit;
            }
        }
    }

    public function createAuthTable()
    {
        $newTable = "CREATE TABLE IF NOT EXISTS auth(
            Id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(20) NOT NULL,
            Email VARCHAR(40) NOT NULL,
            Password VARCHAR(100) NOT NULL,
            Role VARCHAR(10) NOT NULL   
        )";
        if ($this->isConnect->query($newTable)) {
            // echo "<script> console.log('auth table was created sucessfully.'); </script>";
        } else {
            echo "<script> console.log('*ERROR: auth table was not created.'); </script>";
        }
    }

    // create user
    public function createUser($name, $email, $password, $role)
    {

        // check if email is present in db
        $checkDB = "SELECT * FROM auth WHERE Email = '$email'";
        $checkDBResult = $this->isConnect->query($checkDB);
        
        $row = $checkDBResult->num_rows >0;

        if (!$row) {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUser = "INSERT INTO auth (Name, Email, Password, Role) VALUES ( '$name' , '$email', '$hashPassword', '$role' ) ";
            if ($this->isConnect->query($newUser)) {
                echo "<script> console.log('user Addded into the auth table.'); </script>";
                header("Location: /Game1/view/userHome.php");
                exit;
            } else {
                echo $this->isConnect->error;
                "<script> console.log('*ERROR: user was not enter in the auth table.'); </script>";
            }
        } else {
            $_SESSION['isUserPresentAlready'] = true;
            return;
        }
    }
}


$userModelObj = new userModel();
// $userModelObj->createUser('madhav1', 'madhav1gmail.com', 'test123', 'user');
