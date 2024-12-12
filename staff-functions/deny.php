<?php
session_start();
require_once "../classes/thesis.class.php";
$denyObj = new Thesis;
$reqID = $_GET['id'];

$denyThesisData = $denyObj->fetchSpecificThesisActionReq($reqID);
$denyObj->denyReq($reqID, $denyThesisData['action'], $denyThesisData['thesisID']);
$denyObj->denyThesis($denyThesisData['thesisID']);
?>