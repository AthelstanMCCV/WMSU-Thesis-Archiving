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

    $studIDErr = errNum(validateInput($studentID, "number"));
    $lastNameErr = errText(validateInput($lastName, "text"));
    $firsTNameErr = errText(validateInput($firstName, "text"));
    $middleNameErr = errText(validateInput($middleName, "text"));

    if(!empty($studIDErr) || !empty($lastNameErr) || !empty($firstNameErr) || !empty($middleNameErr)){
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

    if (empty($lastNameErr) && empty($firstNameErr)){
        $groupObj->editMembers($studID);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
        
    
    }
}
?>


