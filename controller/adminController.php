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

    public function delete()
    {
        $id = $_POST['Id'];
        // var_dump($id);
        return $this->userModelObject->deleteRules($id);
    }
    public function edit()
    {
        $id = $_POST['Id'];
        $data = $this->userModelObject->editRule($id);
        echo json_encode($data);
    }

    public function update()
    {
        $numberOfPlayers = $_POST['numberOfPlayers'];
        $points = $_POST['points'];
        $id = $_POST['id'];
        // echo json_encode('hiihii');
        return $this->userModelObject->updateRule($numberOfPlayers, $points, $id);
    }

    public function getLeaderbord()
    {
        $data = $this->userModelObject->userRankTable();
        echo json_encode($data);
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $adminControllerObj = new adminController();

    if (isset($_POST['logout_btn'])) {
        $_SESSION['isUserPresentAlready'] = false;
        $_SESSION['currentUserEmail'] = '';
        $_SESSION['isLogin'] = false;
    }

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'create':
                $adminControllerObj->addRules();
                break;
            case 'read':
                $adminControllerObj->getAllRule();
                break;
            case 'delete':
                $adminControllerObj->delete();
                break;
            case 'edit':
                $adminControllerObj->edit();
                break;
            case 'update':
                $adminControllerObj->update();
                break;
            case 'getLeaderBord':
                $adminControllerObj->getLeaderbord();
                break;
        }
    };
}


$adminControllerObj = new adminController();
// $adminControllerObj->getAllRule();