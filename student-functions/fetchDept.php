<?php 
session_start();
require_once "../classes/login.class.php";
$loginObj = new Login;

$deptData = $loginObj->getDept();

header('Content-Type: application/json');
echo json_encode(value: $deptData);
?>