<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";

$thesisObj = new Thesis;
$currAccountID = $_SESSION['account']['ID'];

if (isset($_SESSION['currThesis']['ID'])) {
    $currThesisID = $_SESSION['currThesis']['ID'];
    $currThesisStatus = $_SESSION['currThesis']['status'];
    $currThesisGroupID = $_SESSION['currThesis']['groupID'];

    if ($thesisObj->checkApproval($currAccountID, $currThesisID)) {
        echo "<script>
            $(document).ready(function () {
                $('td.action').each(function () {
                    if ($(this).hasClass('hide-actions')) {
                        $(this).empty().append('<span style=\"color: red; font-weight: bold;\">No actions available</span>').css('display', 'table-cell');
                    }
                });
            });
        </script>";
    }

    if ($thesisObj->validateApproval($currThesisID) && $currThesisStatus == 2) {
        $thesisObj->approveThesis($currAccountID, $currThesisGroupID, $currThesisID, $currThesisStatus);
    }

    if ($thesisObj->validateRejection($currThesisID) && $currThesisStatus == 3) {
        $thesisObj->rejectThesis($currAccountID, $currThesisGroupID, $currThesisID, $currThesisStatus);
    }

    if ($thesisObj->hasConflict($currThesisID)) {
        $thesisObj->rejectThesis($currAccountID, $currThesisGroupID, $currThesisID, "Rejected");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis List</title>
    <style>
        <?php require_once "../css/request-account.css"; ?>
    </style>
    <script src="../vendor/jquery-3.7.1/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id="pending-header">
        <img id="pending-title-logo" src="../imgs/thesis-icon.png" alt="">
        <h4 id="pending-title">Thesis List</h4>
    </div>

    <form action="" id="pending-form">
        <div id="pending-search-bar">
            <input type="search" id="staff-thesis-search" placeholder="Search">
            <img id="search-img" src="../imgs/search-icon.png" alt="">
        </div>
    </form>

    <div class="table table-responsive">
        <table id="staff-thesis-list" class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Date Published</th>
                    <th>Group Name</th>
                    <th>Advisor Name</th>
                    <th>Thesis ID</th>
                    <th>Thesis Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $thesisData = $thesisObj->fetchAllPendingThesis();
                foreach ($thesisData as $thesis) {
                    $cookieName = "hideActions_" . $thesis['thesisID'] . $currAccountID;
                    $hideActions = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : ($thesisObj->checkApproval($currAccountID, $thesis['thesisID']) ? 'hide-actions' : '');
                    setcookie($cookieName, $hideActions, time() + (86400 * 30), "/");
                ?>
                <tr>
                    <td><?php echo $thesis["datePublished"]; ?></td>
                    <td><?php echo $thesis["username"]; ?></td>
                    <td><?php echo $thesis["advisorName"]; ?></td>
                    <td><?php echo $thesis["thesisID"]; ?></td>
                    <td><?php echo $thesis["thesisTitle"]; ?></td>
                    <td><?php echo $thesis["abstract"]; ?></td>
                    <td><?php echo $thesis["statusName"]; ?></td>
                    <td class="action <?php echo $hideActions; ?>">
                        <?php if ($hideActions !== 'hide-actions') { ?>
                            <a id="approveStyle" class="staffApprove" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Approve</a>
                            <a id="rejectStyle" class="staffReject" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Reject</a>
                        <?php } else { ?>
                            <span style="color: red; font-weight: bold;">No actions available</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            const currentAccountId = '<?php echo $currAccountID; ?>';
            document.cookie.split(';').forEach(function(cookie) {
                const match = cookie.trim().match(/^hideActions_(\d+)_([0-9a-zA-Z]+)/);
                if (match) {
                    const thesisId = match[1];
                    const accountId = match[2];
                    if (accountId !== currentAccountId) {
                        document.cookie = hideActions_${thesisId}_${accountId}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;;
                    }
                }
            });
        });
    </script>
</body>
</html>