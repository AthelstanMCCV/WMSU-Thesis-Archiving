<?php
session_start();

require_once "../classes/thesis.class.php";
$ediThesisObj = new Thesis;
$thesisID = $_GET['id'];
$action = "Edit";

$currThesisData = $ediThesisObj->fetchSpecificThesis($thesisID);

var_export($currThesisData);
if(($currThesisData['status'] != "Delete") && ($currThesisData['status'] != "Edit")){


    if($_SERVER['REQUEST_METHOD'] == "POST"){

            $ediThesisObj->thesisActionReq($action, $thesisID, $_SESSION['account']['ID']);

            $ediThesisObj->cleanThesis();

            $thesisTitle = $ediThesisObj->thesisTitle;
            $datePublished = $ediThesisObj->datePublished;
            
            $groupID = $_SESSION['account']['ID'];


            $titleErr = $datePublishedErr = '';

        if(empty($thesisTitle)){
            $titleErr = 'Thesis Title is required.';
        }

        if(empty($datePublished)){
            $datePublishedErr = 'Date Published is required.';
        }

        if(!empty($thesisTitle) || !empty($datePublished)){
            echo json_encode([
                'status' => 'error',
                'titleErr' => $titleErr,
                'datePublishedErr' => $datePublishedErr,
            ]);
            exit;
        }

            if(empty($titleErr) && empty($datePublishedErr)){
                if($ediThesisObj->reqeditThesis($thesisID, $groupID)){
                    echo json_encode(['status' => 'success']);
                }else {
                    echo json_encode(['status' => 'error', 'message' => 'Something went wrong when adding the new product.']);
                }
                exit;
            }
        }
    
}else{
    header("location: ./thesis-list");
    exit;
}
?>