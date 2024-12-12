<?php
session_start();
require_once "../classes/account.class.php";
$accountsObj = new Accounts;
$page_title = "Dashboard";

if(empty($_SESSION['account'])){
    header("location: ../account/login.php");
}

require_once '../__includes/head.php';
?>

<body>
    <?php require_once '../__includes/navbar.php'; ?>
    <div id="dashboard-body">
        <div id="sidebar">
            <?php require_once '../__includes/sidebar.php'; ?>
        </div>
        <div class="modal-container"></div>
        <div id="dashboard-main-display">
            
        </div>
    </div>
    <?php require_once '../__includes/footer.php'; ?>
</body>