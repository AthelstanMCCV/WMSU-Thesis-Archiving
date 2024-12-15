<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";

$thesisObj = new Thesis;

if($_SESSION['account']['studentID']){
    $studentID = $_SESSION['account']['studentID'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $thesisObj->cleanThesis();

    $thesisTitle = $thesisObj->thesisTitle;
    $datePublished = $thesisObj->datePublished;
    $authorID = $thesisObj->authorID;
    $advisorName = $thesisObj->advisorName;
    $abstract = $thesisObj->shortDesc;
    
    $groupID = $_SESSION['account']['ID'];


    $titleErr = errText(validateInput($thesisTitle, "text"));
    $advisorNameErr = errText(validateInput($advisorName, "text"));
    $abstractErr = errText(validateInput($abstract, "text"));
    $datePublishedErr = '';

    if(empty($datePublished)){
        $datePublishedErr = 'Date Published is required.';
    }

    if(!empty($titleErr) || !empty($advisorNameErr) || !empty($abstractErr)){
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'titleErr' => $titleErr,
            'advisorNameErr' => $advisorNameErr,
            'abstractErr' => $abstractErr,
            'datePublishedErr' => $datePublishedErr,
        ]);
        exit;
    }

    if(empty($titleErr) && empty($advisorNameErr) && empty($abstractErr)){
        $thesisObj->addThesis($groupID, $studentID);
        $currThesis = $thesisObj->fetchThesisID($thesisTitle);
        $thesisObj->recordThesis(1, NULL, NULL, NULL, $_SESSION['account']['ID'], $currThesis);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
    }
}
?>
