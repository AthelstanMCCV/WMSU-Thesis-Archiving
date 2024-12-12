<?php
session_start();
require_once "../classes/group.class.php";
$groupObj = new Group;
$studIDErr = $lastNameErr = $firsTNameErr = "";

    if(isset($_POST['addMember']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $groupObj->cleanMembers();

        $studentID = $groupObj->studentID; 
        $lastName = $groupObj->lastName;
        $firstName = $groupObj->firstName; 
        $middleName = $groupObj->middleName;

        $studIDErr = errNum(validateInput($studentID, "number"));
        $lastNameErr = errText(validateInput($lastName, "text"));
        $firsTNameErr = errText(validateInput($firstName, "text"));
        $middleNameErr = errText(validateInput($middleName, "text"));

        if (empty($studIDErr) && empty($lastNameErr) && empty($firstNameErr)){
            $groupID = $_SESSION['account']['ID'];
            $groupObj->addMembers($groupID);
            $_SESSION['form_success'] = true;
            echo '<script>window.location.href="memberList.php";</script>';
        
        }
    }

?>
      <?php 
        $memberReqData = $groupObj->fetchGroupMembers($_SESSION['account']['ID']);
    ?>
        <div id="pending-header">
            <img id="pending-title-logo" src="../imgs/student-icon.png" alt="">
            <h4 id="pending-title">Member List</h4>
            <div id="addContainer">
                <a id="addMemberBtn" href="../student-functions/addMember.php"">Add Member <span id="addIcon">+</span></a>
            </div>
        </div>
        <form action="" id="pending-form">
            <div id="pending-search-bar">
                <input type="search" name="" id="staff-thesis-search" placeholder="Search">
                <img id="search-img" src="../imgs/search-icon.png" alt="">
            </div>
        </form>

        
        <div class="table-responsive">
                <table id="staff-thesis-list" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th id="pending-headerRow"> Student ID </th>
                            <th id="pending-headerRow"> Group Name </th>
                            <th id="pending-headerRow"> Last Name </th>
                            <th id="pending-headerRow"> First Name </th>
                            <th id="pending-headerRow"> Middle Name </th>
                            <th id="pending-headerRow"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                <?php foreach($memberReqData as $data){ ?>
                    <tr id="pending-data-row">
                        <td><?php echo $data["studentID"] ?></td>
                        <td><?php echo $data["username"]?></td>
                        <td><?php echo $data["lastName"]?></td>
                        <td><?php echo $data["firstName"]?></td>
                        <td><?php if(!empty($data['middleName'])){echo $data["middleName"];}else{echo "N/A";}?></td>
                        <td><a data-id="<?php echo $data['studentID']?>">Edit</a>
                        <a href="../student-functions/deleteMember.php?id=<?php echo $data['studentID']?>">Delete</a></td>
                    </tr>
                <?php }; ?>
                    </tbody>
                </table>
            </div>