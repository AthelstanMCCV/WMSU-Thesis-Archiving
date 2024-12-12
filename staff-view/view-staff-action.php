<?php
session_start();
require_once "../classes/thesis.class.php";
$thesisactionreqObj = new Thesis;
?>

<div id="pending-header">
    <img id="pending-title-logo" src="../imgs/pending-icon.png" alt="">
    <h4 id="pending-title">Thesis Action Requests</h4>
</div>

<form action="" id="pending-form">
    <div id="pending-search-bar">
        <input type="search" name="" id="staff-thesis-search" placeholder="Search">
        <img id="search-img" src="../imgs/search-icon.png" alt="">
    </div>
</form>

<div class="table table-responsive">
    <table id="staff-thesis-list" class="table table-hover align-middle">
        <thead>
            <tr>
                <th id="pending-headerRow"> Group Name </th>
                <th id="pending-headerRow"> Thesis ID </th>
                <th id="pending-headerRow"> Thesis Title </th>
                <th id="pending-headerRow"> Date Requested </th>
                <th id="pending-headerRow"> Action Request </th>
                <th id="pending-headerRow"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $thesisActionReqData = $thesisactionreqObj->fetchThesisEditReq(); 
                foreach($thesisActionReqData as $thesis){ 
            ?>
            <tr id="pending-data-row">
                <td><?php echo $thesis["username"]?></td>
                <td><?php echo $thesis["thesisID"]?></td>
                <td><?php echo $thesis["thesisTitle"]?></td>
                <td><?php echo $thesis["dateRequested"]?></td>
                <td><?php echo $thesis["action"]?></td>
                <td id="actions">
                    <a id="approveStyle" class="approveReq" data-id="<?php echo $thesis['thesisActionReqID']; ?>" type="button">Confirm</a>
                    <a id="rejectStyle" class="denyReq" data-id="<?php echo $thesis['thesisActionReqID']; ?>"type="button">Deny</a>
                </td>
            </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>
