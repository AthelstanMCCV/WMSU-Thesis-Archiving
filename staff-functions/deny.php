<?php
session_start();
require_once "../classes/thesis.class.php";
$denyObj = new Thesis;
$reqID = $_GET['id'];

if($_SESSION['account']['studentID']){
    $studentID = $_SESSION['account']['studentID'];
}

$denyThesisData = $denyObj->fetchSpecificThesisActionReq($reqID);
$action = $denyThesisData['action'];
$denyObj->denyReq($reqID, $denyThesisData['action'], $denyThesisData['thesisID']);
$denyObj->denyThesis($denyThesisData['thesisID'], $action);
$denyObj->recordThesis(3, $_SESSION['account']['ID'], $action ,$studentID,$denyThesisData['groupID'], $denyThesisData['thesisID']);  

?>