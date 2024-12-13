<?php
session_start();
require_once "../classes/thesis.class.php";

$thesisObj = new Thesis;

// Ensure the session variable for the current thesis exists
if (!isset($_SESSION['currThesis'])) {
    $_SESSION['currThesis'] = [];
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) { // Validate the thesis ID
        $thesisID = $_GET['id'];

        // Check if the thesis ID in the session is different, and reset if necessary
        if (!isset($_SESSION['currThesis']['ID']) || $_SESSION['currThesis']['ID'] != $thesisID) {
            $_SESSION['currThesis'] = [];
        }

        // Update session variables for the current thesis
        $_SESSION['currThesis']['ID'] = $thesisID;
        $staffID = $_SESSION['account']['ID'];
        $_SESSION['currThesis']['status'] = 3;
        $_SESSION['currThesis']['groupID'] = $thesisObj->fetchgroupID($thesisID);

        // Process the rejection
        try {
            $thesisObj->passtoApproval($staffID, $thesisID, $_SESSION['currThesis']['groupID'], $_SESSION['currThesis']['status']);
            
            // Send a success response
            echo json_encode([
                "status" => "success",
                "message" => "Thesis successfully rejected.",
            ]);
        } catch (Exception $e) {
            // Handle exceptions and send an error response
            echo json_encode([
                "status" => "error",
                "message" => "An error occurred while rejecting the thesis: " . $e->getMessage(),
            ]);
        }
    } else {
        // Send an error response if ID is missing
        echo json_encode([
            "status" => "error",
            "message" => "Thesis ID is required.",
        ]);
    }
} else {
    // Handle invalid request method
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Only GET requests are allowed.",
    ]);
}
?>
