<?php
session_start();
require_once "../classes/account.class.php";
$accountsObj = new Accounts;

if(empty($_SESSION['account'])){
    header("location: login.php");
}

if (isset($_SESSION['form_success']) && $_SESSION['form_success'] === true) {
    unset($_SESSION['form_success']); // Clear the flag
    echo '<script>console.log("Form successfully submitted.");</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        <?php require_once '../vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css'; ?>
        <?php require_once '../css/style.css'; ?>
    </style>
</head>
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
</html>