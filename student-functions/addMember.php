<?php
session_start();
require_once "../classes/group.class.php";
require_once "../classes/login.class.php";

$groupObj = new Group;
$loginObj = new Login;
$studIDErr = $lastNameErr = $firsTNameErr = $courseErr = "";

    if(isset($_POST['addMember']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $groupObj->cleanMembers();

        $studentID = $groupObj->studentID; 
        $lastName = $groupObj->lastName;
        $firstName = $groupObj->firstName; 
        $middleName = $groupObj->middleName;
        $course = $groupObj->course;

        $studIDErr = errNum(validateInput($studentID, "number"));
        $lastNameErr = errText(validateInput($lastName, "text"));
        $firsTNameErr = errText(validateInput($firstName, "text"));
        $middleNameErr = errText(validateInput($middleName, "text"));

        if (empty($studIDErr) && empty($lastNameErr) && empty($firstNameErr)){
            $groupID = $_SESSION['account']['ID'];
            $groupObj->addMembers($groupID);
            $_SESSION['form_success'] = true;
            echo '<script>window.location.href="../student/member-list.php";</script>';
        
        }
    }

    ?>



<a href="../student/member-list">back</a>

<form action="" method="POST">
            <label for="studentID">Student ID</label>
            <input type="text" name="studentID" id="studentID">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName">
            <label for="middleName">middle Name</label>
            <input type="text" name="middleName" id="middleName">
            
            <input type="submit" name="addMember" value="Add Member">
        </form>