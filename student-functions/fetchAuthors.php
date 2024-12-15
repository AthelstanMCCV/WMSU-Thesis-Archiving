<?php
session_start();
require_once "../classes/thesis.class.php";
$thesisObj = new Thesis;


$authorData = $thesisObj->fetchAuthors($_SESSION['account']['ID']);

header('Content-Type: application/json');
echo json_encode($authorData);
?>