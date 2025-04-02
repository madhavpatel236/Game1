<?php
require('../constant.php');
include __APPPATH__ . '/model/userModel.php';
class adminController
{
    public $userModelObject;
    public $val1;
    public $allRulesList;

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
        $this->allRulesList = $this->userModelObject->getAllRules();
        // var_dump($this->allRulesList);
        echo json_encode($this->allRulesList);
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
// $adminControllerObj->getAllRule();