<?php session_start();
require_once "../classes/group.class.php";
$groupObj = new Group;
?>
<body>
    <div id="pending-header">
        <img id="pending-title-logo" src="../imgs/student-icon.png" alt="">
        <h4 id="pending-title">Group List</h4>
    </div>
    <form action="" id="pending-form">
        <div id="pending-search-bar">
            <input type="search" name="" id="group-search" placeholder="Search">
            <img id="search-img" src="../imgs/search-icon.png" alt="">
        </div>
    </form>

        <?php 
        if ($_SESSION['account']['role'] == 1){  
        $accountReqData = $groupObj->fetchAllGroups();
    ?>
        <div>
            <table id="group-list" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th id="pending-headerRow">ID</th>
                        <th id="pending-headerRow">Username</th>
                        <th id="pending-headerRow"> Email Address </th>
                        <th id="pending-headerRow"> Department </th>
                        <th id="pending-headerRow"> Course </th>
                        <th id="pending-headerRow">Date Created</th>
                    </tr>
                </thead>
                <tbody>
        <?php foreach($accountReqData as $data){ ?>
                    <tr id="pending-data-row">
                        <td><?php echo $data["ID"] ?></td>
                        <td><?php echo $data["username"]?></td>
                        <td><?php echo $data["email"]?></td>
                        <td><?php echo $data["departmentName"]?></td>
                        <td><?php echo $data["courseName"]?></td>
                        <td><?php echo $data["date_created"]?></td>
                    </tr>
        <?php }; ?>
                </tbody>
            </table>
    </div>
        <?php }; ?>
</body>