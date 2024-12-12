<?php
session_start();
require_once "../classes/thesis.class.php";

$thesisObj = new Thesis;

// Check if the session variable exists
if (!isset($_SESSION['currThesis'])) {
    $_SESSION['currThesis'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $thesisID = $_GET['id'];

        // Check if the thesis ID is already in the session
        if ($_SESSION['currThesis']['ID'] != $thesisID) {
            unset($_SESSION['currThesis']); // Clear the session data
        }

        // Update the session data
        $_SESSION['currThesis']['ID'] = $thesisID;
        $staffID = $_SESSION['account']['ID'];
        $_SESSION['currThesis']['status'] = 2;
        $_SESSION['currThesis']['groupID'] = $thesisObj->fetchgroupID($thesisID);

        // Pass the data to the approval process
        $thesisObj->passtoApproval($staffID, $thesisID, $_SESSION['currThesis']['groupID'], $_SESSION['currThesis']['status']);

        // Return a success message
        echo json_encode(["status" => "success", "message" => "Thesis approved successfully."]);
    } else {
        // Handle missing ID
        echo json_encode(["status" => "error", "message" => "Thesis ID is required."]);
    }
} else {
    // Handle invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
