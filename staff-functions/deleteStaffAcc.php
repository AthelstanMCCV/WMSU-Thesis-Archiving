<?php
session_start();
require_once "../classes/account.class.php";

$deleteStaffObj = new Accounts;
$staffID = $_GET['id'];

$deleteStaffObj->deleteStaffAcc($staffID);
?>