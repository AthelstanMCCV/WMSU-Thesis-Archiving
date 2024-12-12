<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";
$thesisObj = new Thesis;
?>

<?php
if (isset($_SESSION['currThesis']['ID'])){
    if($thesisObj->checkApproval($_SESSION['account']['ID'],$_SESSION['currThesis']['ID'])){ ?>
        
        <script>
        $(document).ready(function(){
            $('td.action').each(function () {
                    // Hide actions in rows where approval exists
                    if ($(this).hasClass('hide-actions')) {
                        $(this).hide();
                        var message = $('<span>').text('No actions available').css({
                        'color': 'red', 
                        'font-weight': 'bold'
                    });
                    $(this).parent().find('td').last().after(message); // Adding the message after the last column
                }
                    
            });
        }); 
        </script>;
    <?php } 


    if(($thesisObj->validateApproval($_SESSION['currThesis']['ID']) && ($_SESSION['currThesis']['status'] == "Approved"))){

        $thesisObj->approveThesis($_SESSION['account']['ID'], $_SESSION['currThesis']['groupID'],$_SESSION['currThesis']['ID'],$_SESSION['currThesis']['status']);
    }
    if(($thesisObj->validateRejection($_SESSION['currThesis']['ID']) && ($_SESSION['currThesis']['status'] == "Rejected"))){
        
        $thesisObj->rejectThesis($_SESSION['account']['ID'], $_SESSION['currThesis']['groupID'],$_SESSION['currThesis']['ID'],$_SESSION['currThesis']['status']);
    }
    if ($thesisObj->hasConflict($_SESSION['currThesis']['ID'])) {
        $thesisObj->rejectThesis(
            $_SESSION['account']['ID'], 
            $_SESSION['currThesis']['groupID'], 
            $_SESSION['currThesis']['ID'], 
            "Rejected"
        );
    }
}
?>
<div id="pending-header">
    <img id="pending-title-logo" src="../imgs/thesis-icon.png" alt="">
    <h4 id="pending-title">Thesis List</h4>
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
                <th id="pending-headerRow"> Date Published </th>
                <th id="pending-headerRow"> Group Name </th>
                <th id="pending-headerRow"> Advisor Name </th>
                <th id="pending-headerRow"> Thesis ID </th>
                <th id="pending-headerRow"> Thesis Title </th>
                <th id="pending-headerRow"> Status </th>
                <th id="pending-headerRow"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $thesisData = $thesisObj->fetchAllPendingThesis();
                foreach($thesisData as $thesis){
                    $hideActions = $thesisObj->checkApproval($_SESSION['account']['ID'], $thesis['thesisID']) ? 'hide-actions' : '';
            ?>
            <tr id="pending-data-row">
                <td><?php echo $thesis["datePublished"]?></td>
                <td><?php echo $thesis["username"]?></td>
                <td><?php echo $thesis["advisorName"]?></td>
                <td><?php echo $thesis["thesisID"]?></td>
                <td><?php echo $thesis["thesisTitle"]?></td>
                <td><?php echo $thesis["status"]?></td>
                <td id="actions" class="action <?php echo $hideActions; ?>">
                    <a id="approveStyle" class="staffApprove" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Approve</a>
                    <a id="rejectStyle" class="staffReject" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Reject</a>
                </td>
            </tr>
            <?php };?>
        </tbody>
        <script>
            $(document).ready(function(){
                // Hide any elements with the 'hide-actions' class
                $('.hide-actions').hide();
            });
        </script>
    </table>
</div> 