<?php
    session_start();
    require_once "../classes/account.class.php";
    $accountsObj = new Accounts;
?>

    <div id="pending-header">
        <img id="pending-title-logo" src="../imgs/pending-icon.png" alt="">
        <h4 id="pending-title">Pending Requests</h4>
    </div>
    <form action="" id="pending-form">
        <div id="pending-search-bar">
            <input type="search" name="" id="pending-search" placeholder="Search">
            <img id="search-img" src="../imgs/search-icon.png" alt="">
        </div>
    </form>

    <table id="pending-students-table" class="table table-hover align-middle">
        <thead>
            <tr>
                <th id="pending-headerRow">ID</th>
                <th id="pending-headerRow">Username</th>
                <th id="pending-headerRow"> Email Address </th>
                <th id="pending-headerRow"> Department </th>
                <th id="pending-headerRow"> Course </th>
                <th id="pending-headerRow">Date Created</th>
                <th id="pending-headerRow">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if (!isset($_POST['searchAndSort'])){
                    $accountData = $accountsObj->fetchData();
                    foreach($accountData as $data){ ?>
            <tr data-id="<?php echo $data['ID']; ?>" id="pending-data-row">
                <td><?php echo $data["ID"] ?></td>
                <td><?php echo $data["username"]?></td>
                <td><?php echo $data["email"]?></td>
                <td><?php echo $data["departmentName"]?></td>
                <td><?php echo $data["courseName"]?></td>
                <td><?php echo $data["date_created"]?></td>
                <td id="actions">
                    <a id="approveStyle" class="approve" data-id="<?php echo $data['ID']; ?>" type="button">Approve</a>
                    <a id="rejectStyle" class="reject" data-id="<?php echo $data['ID']; ?>" type="button">Reject</a>
                </td>
            </tr>
    <?php }}; ?>
        </tbody>
    </table>
    