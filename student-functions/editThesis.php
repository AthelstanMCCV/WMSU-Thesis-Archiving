<?php
session_start();

require_once "../classes/thesis.class.php";
$ediThesisObj = new Thesis;
$thesisID = $_GET['id'];
$action = "Edit";

// Fetch the thesis data
$currThesisData = $ediThesisObj->fetchSpecificThesis($thesisID);

if (($currThesisData['status'] != "Delete") && ($currThesisData['status'] != "Edit")) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Perform actions
        $ediThesisObj->thesisActionReq($action, $thesisID, $_SESSION['account']['ID']);
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

        // Check if there are validation errors
        if (!empty($titleErr) || !empty($datePublishedErr) || !empty($advisorNameErr)) {
            // Return error response if validation fails
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'titleErr' => $titleErr,
                'datePublishedErr' => $datePublishedErr,
            ]);
            exit;
        }
        if (empty($titleErr) && empty($datePublishedErr)) {
            $ediThesisObj->reqeditThesis($thesisID, $groupID);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
                exit;
        }
    }
}
?>
