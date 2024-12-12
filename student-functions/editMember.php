<?php 
require_once "../classes/group.class.php";

$groupObj = new Group;
$studID = $_GET['id'];

$memberData = $groupObj->fetchMemberData($studID);

var_export($memberData);
if( $_SERVER['REQUEST_METHOD'] == "POST"){
    $groupObj->cleanMembers();

    $lastName = $groupObj->lastName;
    $firstName = $groupObj->firstName; 
    $middleName = $groupObj->middleName;

    $lastNameErr = errText(validateInput($lastName, "text"));
    $firsTNameErr = errText(validateInput($firstName, "text"));
    $middleNameErr = errText(validateInput($middleName, "text"));

    if (empty($lastNameErr) && empty($firstNameErr)){
        $groupObj->editMembers($studID);
        $_SESSION['form_success'] = true;
        echo '<script>window.location.href="../student/member-list";</script>';
    
    }
}

?>

<a href="../student/member-list">BACK</a>

<form action="" method="POST">
      
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName" value="<?php echo $memberData['lastName']?>">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName" value="<?php echo $memberData['firstName']?>">
            <label for="middleName">middle Name</label>
            <input type="text" name="middleName" id="middleName" value="<?php echo $memberData['middleName']?>">
            
            <input type="submit" name="addMember" value="Add Member">
        </form>


