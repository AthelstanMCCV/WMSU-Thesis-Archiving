<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";
$thesisObj = new Thesis;
?>

<?php

$currAccountID = $_SESSION['account']['ID'];

if (isset($_SESSION['currThesis']['ID'])){
    if($thesisObj->checkApproval($_SESSION['account']['ID'],$_SESSION['currThesis']['ID'])){ ?>
        
        <script>
$(document).ready(function () {
    $('td.action').each(function () {
        // Check if this `td` has the 'hide-actions' class
        if ($(this).hasClass('hide-actions')) {
            // Clear existing content of the `td`
            $(this).empty();

            // Create a <span> element with the message
            var message = $('<span>')
                .text('No actions available')
                .css({
                    'color': 'red',
                    'font-weight': 'bold',
                });

            // Append the message to the `td`
            $(this).append(message);

            // Ensure the `td` is visible
            $(this).css('display', 'table-cell'); // Ensure the display is correct
        }
    });
});


        </script>;
    <?php } 


    if(($thesisObj->validateApproval($_SESSION['currThesis']['ID']) && ($_SESSION['currThesis']['status'] == 2))){

        $thesisObj->approveThesis($_SESSION['account']['ID'], $_SESSION['currThesis']['groupID'],$_SESSION['currThesis']['ID'],$_SESSION['currThesis']['status']);
    }
    if(($thesisObj->validateRejection($_SESSION['currThesis']['ID']) && ($_SESSION['currThesis']['status'] == 3))){
        
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
                <th id="pending-headerRow"> Description</th>
                <th id="pending-headerRow"> Status </th>
                <th id="pending-headerRow"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $thesisData = $thesisObj->fetchAllPendingThesis();
                foreach($thesisData as $thesis){
                    $cookieName = "hideActions_" . $thesis['thesisID'] . $currAccountID;

                    // Determine hideActions value
                    $hideActions = '';
                    if (isset($_COOKIE[$cookieName])) {
                        $hideActions = $_COOKIE[$cookieName];
                    } else {
                        $hideActions = $thesisObj->checkApproval($_SESSION['account']['ID'], $thesis['thesisID']) ? 'hide-actions' : '';
                        setcookie($cookieName, $hideActions, time() + (86400 * 30), "/");
                    }
           ?>
            <tr id="pending-data-row">
                <td><?php echo $thesis["datePublished"]?></td>
                <td><?php echo $thesis["username"]?></td>
                <td><?php echo $thesis["advisorName"]?></td>
                <td><?php echo $thesis["thesisID"]?></td>
                <td><?php echo $thesis["thesisTitle"]?></td>
                <td><?php echo $thesis["abstract"]?></td>
                <td><?php echo $thesis["statusName"]?></td>
                <td id="actions" class="action <?php echo $hideActions; ?>">
                    <a id="approveStyle" class="staffApprove" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Approve</a>
                    <a id="rejectStyle" class="staffReject" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Reject</a>
                </td>
            </tr>
            <?php };?>
        </tbody>
        <script>
            
            $(document).ready(function(){

                const currentAccountId = '<?php echo $currAccountID; ?>';
            document.cookie.split(';').forEach(function (cookie) {
                const match = cookie.trim().match(/^hideActions_(\d+)_([0-9a-zA-Z]+)/); // Regex to match hideActions cookies
                if (match) {
                    const thesisId = match[1];
                    const accountId = match[2];
                    if (accountId !== currentAccountId) {
                        document.cookie = `hideActions_${thesisId}_${accountId}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
                    }
                }
            });
                $('.action.hide-actions').each(function () {
                $(this).find('a').remove(); // Remove any action buttons
                $(this).append('<span style="color: red; font-weight: bold;">No actions available</span>');
            });
        });
        </script>
    </table>
</div> 