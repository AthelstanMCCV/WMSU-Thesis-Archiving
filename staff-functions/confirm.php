<?php
session_start();
require_once "../classes/thesis.class.php";
$confirmObj = new Thesis;
$reqID = $_GET['id'];
$index = $_GET['index'];

if($_SESSION['account']['studentID']){
    $studentID = $_SESSION['account']['studentID'];
}

$reqData = $confirmObj->fetchSpecificThesisActionReq($reqID);
$reqEditData = $confirmObj->fetchSpecificEditReq($reqData['thesisID']);

if ($reqData['action'] == "Delete"){
    $confirmObj->recordThesis(2, $_SESSION['account']['ID'], "Delete",$studentID,$reqData['groupID'],$reqData['thesisID']);  
    $confirmObj->confirmDelete($reqData['thesisID'], $reqID);
      
}

if ($reqData['action'] == "Edit"){
    $confirmObj->confirmEdit($reqEditData['thesisID'], $reqEditData['thesisTitle'], $reqEditData['datePublished'], $reqID, $reqEditData['abstract']);
    $confirmObj->setApproveThesis($reqEditData['thesisID']);
    $confirmObj->recordThesis(2, $_SESSION['account']['ID'], "Edit",$studentID,$reqData['groupID'],$reqData['thesisID']);
}

unset($_SESSION['thesisData'][$index]);
?>