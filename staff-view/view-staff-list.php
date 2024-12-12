<?php
    session_start();
    require_once "../classes/account.class.php";
    require_once "../tools/functions.php";

    $staffObj = new Accounts;

    if(empty($_SESSION['account'])){
        header("location: ../account/login.php");
        exit;
    }
?>


<div id="pending-header">
    <img id="pending-title-logo" src="../imgs/student-icon.png" alt="">
    <h4 id="pending-title">Staff List</h4>
    <div id="addContainer">
        <a id="addStaff" type="button">Add Staff <span id="addIcon">+</span></a>
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
                <th id="pending-headerRow"> Username </th>
                <th id="pending-headerRow"> Email </th>
                <th id="pending-headerRow"> Associated Account </th>
                <th id="pending-headerRow"> Actions </th>
            </tr>
        </thead>
        <tbody>
<?php
    $staffData = $staffObj->fetchStaffData($_SESSION['account']['ID']);
    foreach($staffData as $staff){ 
?>
                <tr id="pending-data-row">
                    <td><?php echo $staff["username"]?></td>
                    <td><?php echo $staff["email"]?></td>
                    <td><?php echo $staff["assocAcc"]?></td>
                    <td id="actions">
                        <a id="approveStyle" class="editStaff" data-id="<?php echo $staff['staffAdminID']; ?>" type="button">Edit</a>
                        <a id="rejectStyle" class="deleteStaff" data-id="<?php echo $staff['staffAdminID']; ?>" type="button">Delete</a>
                    </td>
                </tr>
            <?php }; ?>
            </tbody>
    </table>
</div>    