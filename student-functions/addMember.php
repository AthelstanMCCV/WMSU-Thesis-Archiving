<?php
session_start();
require_once "../classes/group.class.php";
require_once "../classes/login.class.php";

$groupObj = new Group;
$loginObj = new Login;
$studIDErr = $lastNameErr = $firsTNameErr = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $groupObj->cleanMembers();

        $studentID = $groupObj->studentID; 
        $lastName = $groupObj->lastName;
        $firstName = $groupObj->firstName; 
        $middleName = $groupObj->middleName;

        $studIDErr = errNum(validateInput($studentID, "number"));
        $lastNameErr = errText(validateInput($lastName, "text"));
        $firstNameErr = errText(validateInput($firstName, "text"));
        $middleNameErr = errText(validateInput($middleName, "text"));

        if(!empty($studIDErr) || !empty($lastNameErr) || !empty($firstNameErr)){
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'studIDErr' => $studIDErr,
                'lastNameErr' => $lastNameErr,
                'firstNameErr' => $firstNameErr,
                'middleNameErr' => $middleNameErr,
            ]);
            exit;
        }

        if (empty($studIDErr) && empty($lastNameErr) && empty($firstNameErr)){
            $groupID = $_SESSION['account']['ID'];
            $groupObj->addMembers($groupID);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        
        }
    }
?>
