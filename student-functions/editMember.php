<?php 
session_start();
require_once "../classes/group.class.php";

$groupObj = new Group;
$studID = $_GET['id'];

$memberData = $groupObj->fetchMemberData($studID);
if( $_SERVER['REQUEST_METHOD'] == "POST"){
    $groupObj->editCleanMembers();

    $username = $groupObj->username;
    $password = $groupObj->password;
    $lastName = $groupObj->lastName;
    $firstName = $groupObj->firstName; 
    $middleName = $groupObj->middleName;

    $studIDErr = errNum(validateInput($studID, "number"));
    $usernameErr = errText(validateInput($username, "text"));
    $passwordErr = errText(validateInput($password, "text"));
    $lastNameErr = errText(validateInput($lastName, "text"));
    $firstNameErr = errText(validateInput($firstName, "text"));

    if(!empty($lastNameErr) || !empty($firstNameErr) || !empty($usernameErr)|| !empty($passwordErr)){
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'usernameErr' => $usernameErr,
            'passwordErr' => $passwordErr,
            'lastNameErr' => $lastNameErr,
            'firstNameErr' => $firstNameErr,
        ]);
        exit;
    }

    if (empty($lastNameErr) && empty($firstNameErr) && empty($usernameErr) && empty($passwordErr)){
        $groupObj->editMembers($studID);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
    }
}
?>


