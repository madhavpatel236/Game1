<?php
session_start();
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
            // echo "<script> console.log('Database was connected with the model.'); </script>";
        } else {
            echo "<script> console.log('*ERROR: Database was not connected with the model.'); </script>";
        }

        $this->createAuthTable();
        $this->createRulesTable();
        $this->createUserDataTable();
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
            $varifyPassword = password_verify($password, $user['password']);
            var_dump($varifyPassword);
            if ($user['email'] == $email && $varifyPassword) {
                $_SESSION['currentUserEmail'] = $email;
                header("Location: /Game1/view/userHome.php ");
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

    public function createRulesTable()
    {
        $table = "CREATE TABLE IF NOT EXISTS rules(
            Id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            NumberOfPlayers INT(5) ,
            Points INT(5) 
        )";
        if ($this->isConnect->query($table)) {
            // echo "<script> console.log(' rules table was created.'); </script> ";
        } else {
            echo "<script> console.log('*ERROR: rules table was not created.'); </script> ";
        }
    }

    public function createUserDataTable()
    {
        $table = "CREATE TABLE IF NOT EXISTS userData(
        Ranking INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        Email VARCHAR(40),
        Points VARCHAR(10)
        )";
        if ($this->isConnect->query($table)) {
            echo "<script> console.log('table was not created.'); </script> ";
        } else {
            echo $this->isConnect->error;
            "<script> console.log('*ERROR: userData table was not created.'); </script> ";
        }
    }

    // create user
    public function createUser($name, $email, $password, $role)
    {

        // check if email is present in db
        $checkDB = "SELECT * FROM auth WHERE Email = '$email'";
        $checkDBResult = $this->isConnect->query($checkDB);

        $row = $checkDBResult->num_rows > 0;

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

    public function insertRulesData($userNumber, $points)
    {
        foreach ($userNumber as $key => $value) {
            $point = $points[$key];
            $insert = "INSERT INTO rules (NumberOfPlayers, Points) VALUES ($value, $point)";
            if ($this->isConnect->query($insert)) {
                echo " <script> consol.log(' Rules are added in the table(rules-table)'); </script> ";
            } else {
                echo  "<script> consol.log('*ERROR: Rules was not be added in the table(rules-table)'); </script> ";
            }
        }
        // $insert = "INSERT INTO rules (NumberOfPlayers, Points) VALUES ($userNumber, $points)";
    }

    public function getAllRules()
    {
        $rules = "SELECT * FROM rules";
        $rulesResult = $this->isConnect->query($rules);

        $responseArray = [];

        if ($rulesResult->num_rows > 0) {
            while ($row = $rulesResult->fetch_assoc()) {
                $responseArray[] = [
                    'Id' => $row['Id'],
                    'PlayerNumber' => $row['NumberOfPlayers'],
                    'Points' => $row['Points']
                ];
            }
        }
        // print_r($responseArray);
        return $responseArray;
    }

    public function deleteRules($id)
    {
        $delete = " DELETE FROM rules WHERE Id = '$id'";
        if ($this->isConnect->query($delete)) {
            // echo '<script> console.log(" Delete the rule sucessfully!! "); </script>';
        } else {
            echo '<script> console.log("*ERROR: Does not Delete the rule  "); </script>';
        }
    }

    public function editRule($id)
    {
        $userData = "SELECT * FROM rules WHERE Id = '$id'";
        $userDataResult = $this->isConnect->query($userData);

        $userDataArray = [];

        if ($userDataResult->num_rows > 0) {
            while ($row = $userDataResult->fetch_assoc()) {
                $userDataArray[] = [
                    'Id' => $row['Id'],
                    'NumberOfPlayers' => $row['NumberOfPlayers'],
                    'Points' => $row['Points']
                ];
            }
        }
        return $userDataArray;
    }

    public function updateRule($numberOfPlayers, $points, $id)
    {
        $update = "UPDATE rules SET NumberOfPlayers = '$numberOfPlayers', Points = '$points' WHERE Id = '$id'";
        $isUpdate = $this->isConnect->query($update);
        if ($isUpdate) {
        } else {
            echo '<script> console.log("*ERROR: Does not update the rule."); </script>';
        }
    }

    public function InsertUserData()
    // TODO: unset the SESSION['currentUserEmail'] because other email was not taken.
    {
        $email = $_SESSION['currentUserEmail'];
        echo __LINE__ ; var_dump($email); echo "<br/>";

        // varify that if already email present in db
        $varify = "SELECT Email FROM userData WHERE Email = '$email'";
        $varifiedEmail = $this->isConnect->query($varify);
        $varifiedEmailRow = $varifiedEmail->fetch_assoc();
        echo __LINE__;
        var_dump($varifiedEmailRow);
        echo "<br/>";

        if (!$varifiedEmailRow) {
            // insert a email in the userData db. 
            $insert = "INSERT INTO userData (Email) VALUES ('$email')";
            if ($this->isConnect->query($insert)) {
                echo " <script> console.log('Data was inserted into the userData database'); </script> ";
            } else {
                echo __LINE__ . $this->isConnect->error;
                " <script> console.log('*ERROR: Data was not inserted into the userData database'); </script> ";
            }
        }

        // find the rank of the user.
        $rankOfUser = "SELECT Ranking FROM userData WHERE Email = '$email'";
        $rankOfUserResult = $this->isConnect->query($rankOfUser);
        $fetch = $rankOfUserResult->fetch_assoc(); // here we get a rank of the user.
        $fetchedRank = $fetch['Ranking'];
        echo __LINE__; var_dump($fetchedRank); echo "<br/>";
        if ($rankOfUserResult) {
            echo " <script> console.log('sucessfully find the rank of the user.'); </script> ";
        } else {
            echo __LINE__ . $this->isConnect->error;
            " <script> console.log('*ERROR: Does not find the rank of the user.'); </script> ";
        }

        // select the rules row based on the user rank. // 
        // SELECT * FROM `rules` WHERE `NumberOfPlayers` >= 19 
        // TODO: solve the '$fetchedRank' issue fetchedRank does not work (condition not matched).
        $row = "SELECT * FROM rules WHERE NumberOfPlayers >= '$fetchedRank' ORDER BY NumberOfPlayers LIMIT 1 ";
        $rowResult = $this->isConnect->query($row);
        $fetchRowFromRules = $rowResult->fetch_assoc(); // here we get a row from the rules table like ([NumberOfPlayers] => '' , [Points] => '')
        echo __LINE__; var_dump($fetchRowFromRules); echo "<br/>";
        if ($rowResult) {
            echo " <script> console.log('select a row from the rules table based on the rank in the userData table.  '); </script> ";
        } else {
            echo __LINE__ . $this->isConnect->error;
            echo " <script> console.log('*ERROR: does not be able to select a row from the rules table based on the rank in the userData table.'); </script> ";
        }

        $userpoint = $fetchRowFromRules['Points']; // user earned points

        // insert the user earned point into the userData table.
        echo __LINE__;
        var_dump($email); echo "<br/>";
        $insertPoints = " UPDATE userData SET Points = $userpoint WHERE Email = '$email'";
        $insertPointsResult = $this->isConnect->query($insertPoints);
        echo __LINE__;
        var_dump($insertPointsResult); echo "<br/>";
        if ($insertPointsResult) {
            // $_SESSION['currentUserEmail'] = '';
            echo " <script> console.log('Point is inserted sucessfully into the userData table. '); </script> ";
        } else {
            $this->isConnect->error;
            // echo " <script> console.log('*ERROR: Point is not inserted into the userData table. '); </script> ";
        }
    }
}


$userModelObj = new userModel();
$userModelObj->InsertUserData();
