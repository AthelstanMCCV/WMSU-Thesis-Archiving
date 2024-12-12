<?php 
session_start();
require_once "../classes/group.class.php";
$groupObj = new Group;
$studID = $_GET['id'];

$groupObj->deleteMember($studID);
echo '<script>window.location.href="../student/member-list";</script>';
?>