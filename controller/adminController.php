<?php
require('../constant.php');
include __APPPATH__ . '/model/userModel.php';
class adminController
{
    public $userModelObject;
    public $val1;

    public function __construct()
    {
        $this->userModelObject = $GLOBALS['userModelObj'];
        // echo __LINE__; var_dump($this->val1);
    }

    public function addRules()
    {
        // echo __LINE__; var_dump($_POST['UserNumber']);
        $userNumber = $_POST['UserNumber'];
        $points = $_POST['Points'];
        $this->userModelObject->insertRulesData($userNumber, $points);
    }

    public function getAllRule()
    {
        $data = $this->userModelObject->getAllRules();
        // var_dump($data);
        echo json_encode($data);
        // return $data;
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $adminControllerObj = new adminController();

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'create':
                $adminControllerObj->addRules();
                break;
            case 'read':
                $adminControllerObj->getAllRule();
                break;
                // case 'remove':
                //     $adminControllerObj->removeData();
        }
    };
}


$adminControllerObj = new adminController();
