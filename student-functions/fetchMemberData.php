<?php 
session_start();
require_once "../classes/group.class.php";
$groupObj = new Group;
$studID = $_GET['id'];
$memberData = $groupObj->fetchMemberData($studID);
header('Content-Type: application/json');
echo json_encode($memberData);