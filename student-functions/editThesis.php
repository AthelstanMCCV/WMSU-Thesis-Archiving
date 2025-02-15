<?php
session_start();

require_once "../classes/thesis.class.php";
$ediThesisObj = new Thesis;
$thesisID = $_GET['id'];
$action = 'Edit';
$status = 4;
if($_SESSION['account']['studentID']){
    $studentID = $_SESSION['account']['studentID'];
}

$ediThesisObj->clearNotes($thesisID);
// Fetch the thesis data
$currThesisData = $ediThesisObj->fetchSpecificThesis($thesisID);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Perform actions
        $ediThesisObj->thesisActionReq($status,$action, $thesisID, $_SESSION['account']['ID'], $studentID);
        $ediThesisObj->recordThesis(1, NULL,$action,$studentID,$_SESSION['account']['ID'],$thesisID);
        $ediThesisObj->cleanThesis();

        // Retrieve form data
        $thesisTitle = $ediThesisObj->thesisTitle;
        $datePublished = $ediThesisObj->datePublished;
        $advisorName = $ediThesisObj->advisorName;
        $shortDesc = $ediThesisObj->shortDesc;
        $groupID = $_SESSION['account']['ID'];

        // Initialize error messages
        $titleErr = $datePublishedErr = '';

        // Validate Thesis Title
        if (empty($thesisTitle)) {
            $titleErr = 'Thesis Title is required.';
        }

        // Validate Date Published
        if (empty($datePublished)) {
            $datePublishedErr = 'Date Published is required.';
        }
        if (empty($advisorName)) {
            $advisorNameErr = 'Advisor Name is required.';
        }
        if (empty($shortDesc)) {
            $abstractErr = 'Abstract is required.';
        }

        // Check if there are validation errors
        if (!empty($titleErr) || !empty($datePublishedErr) || !empty($advisorNameErr)) {
            // Return error response if validation fails
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'titleErr' => $titleErr,
                'datePublishedErr' => $datePublishedErr,
                'advisorNameErr' => $advisorNameErr,
                'abstractErr' => $abstractErr,
            ]);
            exit;
        }
        if (empty($titleErr) && empty($datePublishedErr)) {
            $ediThesisObj->reqeditThesis($thesisID, $groupID, $studentID);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
                exit;
        }
    }
?>
