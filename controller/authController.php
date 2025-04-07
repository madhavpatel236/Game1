<?php
include('../constant.php');
include __APPPATH__ . '/model/userModel.php';

class authController
{
    public $email;
    public $password;
    public $name;
    public $role;
    public $userModelObject;
    public $isValid = true;
    public $errors = ['name_error' => '', 'email_error' => '', 'password_error' => '', 'general_error' => ''];

    public function __construct()
    {
        $this->userModelObject = new userModel();
        $this->email = isset($_POST['email']) ? $_POST['email'] : "";
        $this->password = isset($_POST['password']) ? $_POST['password'] : "";
        $this->name =  isset($_POST['name']) ? $_POST['name'] : "";
        $this->role = isset($_POST['role']) ? $_POST['role'] : "";
        // var_dump($this->role); exit;


        // validation

        if (isset($_POST['submit_btn'])) {
            if ($this->name && empty($this->name)) {
                $this->errors['name_error'] = "name is reqired";
                $this->isValid = false;
            }
            if (empty($this->email)) {
                $this->errors['email_error'] = "email is reqired";
                $this->isValid = false;
            }
            if (empty($this->password)) {
                $this->errors['password_error'] = "password is reqired";
                $this->isValid = false;
            }
            if ($_SESSION['isUserPresentAlready'] == true) {
                $this->errors['general_error'] = "User already present, please use different email address.";
                $this->isValid = false;
            }
            if ($_SESSION['Credential_error']  = true) {
                $this->errors['general_error'] = " User was not found, please register your self first.";
            }
            if ($this->isValid != false) {
                return false;
            }
        }

        if( isset($_POST['register_btn'])){
            if ($this->name && empty($this->name)) {
                $this->errors['name_error'] = "name is reqired";
                $this->isValid = false;
            }
            if (empty($this->email)) {
                $this->errors['email_error'] = "email is reqired";
                $this->isValid = false;
            }
            if (empty($this->password)) {
                $this->errors['password_error'] = "password is reqired";
                $this->isValid = false;
            }
            if ($_SESSION['isUserPresentAlready'] == true) {
                $this->errors['general_error'] = "User already present, please use different email address.";
                $this->isValid = false;
            }
        }
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
