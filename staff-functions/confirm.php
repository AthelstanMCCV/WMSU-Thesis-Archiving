<?php
session_start();
require_once "../classes/thesis.class.php";
$confirmObj = new Thesis;
$reqID = $_GET['id'];
$index = $_GET['index'];

$reqData = $confirmObj->fetchSpecificThesisActionReq($reqID);
$reqEditData = $confirmObj->fetchSpecificEditReq($reqData['thesisID']);

if ($reqData['action'] == "Delete"){
    $confirmObj->confirmDelete($reqData['thesisID'], $reqID);
    
}

if ($reqData['action'] == "Edit"){
    $confirmObj->confirmEdit($reqEditData['thesisID'], $reqEditData['thesisTitle'], $reqEditData['datePublished'], $reqID, $reqEditData['abstract']);
    $confirmObj->setApproveThesis($reqEditData['thesisID']);
}

unset($_SESSION['thesisData'][$index]);
?>