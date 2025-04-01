<?php
// dbConnection.php
class database
{
    public $host = 'localhost';
    public $username = "root";
    public $password = 'Madhav@123';
    public $dbname = "Game1";
    public $isConnect;

    public function __construct()
    {
        $connection = new mysqli($this->host, $this->username, $this->password);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $query = "CREATE DATABASE IF NOT EXISTS $this->dbname";
        if ($connection->query($query)) {
            // echo "<script> console.log('db created sucessfully!!')</script>";
        } else {
            // echo "<script> console.log('*ERROR: db was not created.')</script>";
        }
        $connection->close();
    }

    public function dbConnection()
    {
        $connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        return $connection;
    }
}

$dbConnectionObj = new database();
