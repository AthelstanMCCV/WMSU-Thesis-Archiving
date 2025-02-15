<?php 
session_start();

require_once "../classes/thesis.class.php";
$thesisApproveObj = new Thesis;

        $thesisTrack = $thesisApproveObj->fetchThesisLogs($_SESSION['account']['ID']);
    ?>
        <div id="pending-header">
            <img id="pending-title-logo" src="../imgs/pending-icon.png" alt="">
            <h4 id="pending-title">Track Thesis</h4>
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
                        <th id="pending-headerRow"> ID </th>
                        <th id="pending-headerRow"> Staff </th>
                        <th id="pending-headerRow"> Thesis Name </th>
                        <th id="pending-headerRow"> Status </th>
                        <th id="pending-headerRow"> Action </th>
                        <th id="pending-headerRow"> Action Date </th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach($thesisTrack as $data){ ?>
            <tr id="pending-data-row">
                <td><?php echo $data["approvalID"] ?></td>
                <td><?php echo $data["username"]?></td>
                <td><?php echo $data["thesisTitle"]?></td>
                <td><?php echo $data["statusName"]?></td>
                <td><?php echo $data["action"]?></td>
                <td><?php echo $data["actionDate"]?></td>
            </tr>
    <?php }; ?>
            </tbody>
        </table>
    </div>