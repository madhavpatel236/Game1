<?php
include('../constant.php');
// include '../model/userModel.php';
include __APPPATH__ . '/model/userModel.php';
// var_dump($GLOBALS);

class authController
{
    public $email;
    public $password;
    public $name;
    public $role;
    public $userModelObject;

    public function __construct()
    {
        $this->userModelObject = new userModel();
        $this->email = isset($_POST['email']) ? $_POST['email'] : "";
        $this->password = isset($_POST['password']) ? $_POST['password'] : "";
        $this->name =  isset($_POST['name']) ? $_POST['name'] : "";
        $this->role = isset($_POST['role']) ? $_POST['role'] : "";
        // var_dump($this->role); exit;
    }

    public function auth()
    {
        $this->userModelObject->authentication($this->email, $this->password);
    }

    public function createUser()
    {
        $this->userModelObject->createUser($this->name, $this->email, $this->password, $this->role);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authControllerObj = new authController();
    if (isset($_POST['submit_btn'])) {
        $authControllerObj->auth();
    }

    if (isset($_POST['register_btn'])) {
        $authControllerObj->createUser();
    }
}
$authControllerObj = new authController();
