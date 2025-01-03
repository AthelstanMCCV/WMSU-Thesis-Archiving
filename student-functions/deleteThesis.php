<?php
session_start();
require_once "../classes/thesis.class.php";

$thesisObj = new Thesis;
$thesisID= $_GET['id'];
$currThesisStatus = $thesisObj->fetchThesisStatus($thesisID);

if($_SESSION['account']['studentID']){
    $studentID = $_SESSION['account']['studentID'];
}

$thesisObj->clearNotes($thesisID);

if($currThesisStatus != 5 && $currThesisStatus != 4){

    if($_SERVER['REQUEST_METHOD'] == "GET"){
   
        $groupID = $_SESSION['account']['ID'];
        $action = "Delete";
        $status = 5;
        
        if($currThesisStatus == 5){
            header("location: ../student/thesis-list");
            exit;
        }
        $thesisObj->thesisActionReq($status, $action, $thesisID, $groupID, $studentID);
        $thesisObj->recordThesis(1, NULL, $action, $studentID, $groupID, $thesisID);
        header("location: ../student/thesis-list");
        exit;
    }

}else{
    header("location: ../student/thesis-list");
    exit;
}



?>