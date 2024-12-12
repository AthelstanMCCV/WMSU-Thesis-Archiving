<?php
session_start();
require_once "../classes/thesis.class.php";
$ediThesisObj = new Thesis;
$thesisID = $_GET['id'];
$currThesisData = $ediThesisObj->fetchSpecificThesis($thesisID);
header('Content-Type: application/json');
echo json_encode($currThesisData);