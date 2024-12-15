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
        $username = $groupObj->username; 
        $password = $groupObj->password; 
        $lastName = $groupObj->lastName;
        $firstName = $groupObj->firstName; 
        $middleName = $groupObj->middleName;


        $_SESSION['addmember']['course'] = $loginObj->getCourseID($_POST['Course'][0]);

        $studIDErr = errNum(validateInput($studentID, "number"));
        $lastNameErr = errText(validateInput($lastName, "text"));
        $usernameErr = errText(validateInput($username, "text"));
        $passwordErr = errText(validateInput($password, "text"));
        $firstNameErr = errText(validateInput($firstName, "text"));
        $middleNameErr = errText(validateInput($middleName, "text"));

        if(!empty($studIDErr) || !empty($lastNameErr) || !empty($firstNameErr) || !empty($usernameErr)|| !empty($passwordErr) || !empty($courseIDErr) || !empty($deptIDErr)){
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'studIDErr' => $studIDErr,
                'usernameErr' => $usernameErr,
                'passwordErr' => $passwordErr,
                'lastNameErr' => $lastNameErr,
                'firstNameErr' => $firstNameErr,
                'middleNameErr' => $middleNameErr,
            ]);
            exit;
        }

        if (empty($studIDErr) && empty($lastNameErr) && empty($firstNameErr) && empty($usernameErr) && empty($passwordErr)){
            $groupID = $_SESSION['account']['ID'];
            $groupObj->addMembers($groupID, $_SESSION['addmember']['course'], $_SESSION['addmember']['dept']);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        
        }
    }
?>
