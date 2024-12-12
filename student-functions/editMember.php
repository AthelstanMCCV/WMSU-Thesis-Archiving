<?php 
session_start();
require_once "../classes/group.class.php";

$groupObj = new Group;
$studID = $_GET['id'];

$memberData = $groupObj->fetchMemberData($studID);

if( $_SERVER['REQUEST_METHOD'] == "POST"){
    $groupObj->cleanMembers();

    $lastName = $groupObj->lastName;
    $firstName = $groupObj->firstName; 
    $middleName = $groupObj->middleName;

    $studIDErr = errNum(validateInput($studID, "number"));
    $lastNameErr = errText(validateInput($lastName, "text"));
    $firstNameErr = errText(validateInput($firstName, "text"));
    $middleNameErr = errText(validateInput($middleName, "text"));

    if(!empty($lastNameErr) || !empty($firstNameErr) || !empty($middleNameErr)){
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'lastNameErr' => $lastNameErr,
            'firstNameErr' => $firstNameErr,
            'middleNameErr' => $middleNameErr,
        ]);
        exit;
    }

    if (empty($lastNameErr) && empty($firstNameErr) && empty($middleNameErr)){
        $groupObj->editMembers($studID);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
    }
}
?>


