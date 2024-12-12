<?php
session_start();
require_once "../classes/thesis.class.php";

$thesisObj = new Thesis;

$currThesisStatus = $thesisObj->fetchThesisStatus($thesisID);

if($currThesisStatus != "Delete" && $currThesisStatus != "Edit"){

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $thesisID= $_GET['id'];
        $groupID = $_SESSION['account']['ID'];
        $action = "Delete";
        
        if($currThesisStatus == 'Delete Request'){
            header("location: ../student/thesis-list.php");
            exit;
        }
        $thesisObj->thesisActionReq($action, $thesisID, $groupID);
        header("location: ../student/thesis-list.php");
        exit;
    }

}else{
    header("location: ./student/thesis-list");
    exit;
}



?>