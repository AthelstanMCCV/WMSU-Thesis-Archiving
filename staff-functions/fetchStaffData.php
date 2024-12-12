<?php
session_start();
require_once "../classes/account.class.php";

$editStaffObj = new Accounts;
$staffID = $_GET['id'];

$record = $editStaffObj->fetchSpecificStaffData($staffID);
header('Content-Type: application/json');
echo json_encode($record);
?>