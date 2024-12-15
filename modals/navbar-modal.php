<?php
    session_start();
    require_once "../classes/account.class.php";
    $accountObj = new Accounts;
    
    $accountData = $accountObj->fetchAccountData($_SESSION['account']['ID']);

?>

<!-- Modal -->
<div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-danger text-white">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">ACCOUNT DETAILS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="modal-body-content" class="modal-body">
            <img id="accountProfile" src="../imgs/circle-8117443_1280.webp" alt="">
            <div id="accountInfo">
                <p><strong>Username: </strong><?php echo $_SESSION['account']['username'] ?></p>
                <p>
                    <strong>Role: </strong>
                    <?php if($_SESSION['account']['role'] == 1){
                        echo "Admin";
                    } else if($_SESSION['account']['role'] == 2){
                        echo "Staff";
                    } else if($_SESSION['account']['role'] == 3){
                        echo "Student";
                    }?>
                </p>
                <?php if($_SESSION['account']['role'] == 3){ ?>
                    <p><strong>Email: </strong><?php echo $accountData['email'] ?></p>
                    <p id="deptcourse"><strong>Department: </strong><?php echo $accountData['departmentName'] ?></p>
                    <p id="deptcourse"><strong>Course: </strong><?php echo $accountData['courseName'] ?></p>
                <?php } ?>
                <p id="Accountstatus"><strong>Status: </strong><span id="AccountstatusText"><?php if($_SESSION['account']['status'] == 2){
                        echo "Active";
                    }?></span>
                </p>
            </div>
        </div>  
        <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" ><a id="modalButton" class="text-white" href="../account/logout.php">Logout</a></button>
        </div>
    </div>
    </div>
</div>