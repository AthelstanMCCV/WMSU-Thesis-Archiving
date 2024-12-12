<?php
session_start();
require_once "../classes/thesis.class.php";

$thesisObj = new Thesis;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Validate and sanitize thesis ID from the request
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $thesisID = $_GET['id'];
        $groupID = $_SESSION['account']['ID']; // Get group ID from the session
        $currThesisStatus = $thesisObj->fetchThesisStatus($thesisID); // Fetch the current thesis status

        // Check if the current status is not "Delete" or "Edit"
        if ($currThesisStatus != 5 && $currThesisStatus != 4) {
            $action = "Delete";
            $status = 5;

            // Process the delete action request
            try {
                $thesisObj->thesisActionReq($status,$action, $thesisID, $groupID);
                echo json_encode([
                    "status" => "success",
                    "message" => "Thesis marked for deletion successfully."
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "An error occurred while processing the request: " . $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid action. The thesis is already in 'Delete' or 'Edit' status."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid or missing thesis ID."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Only GET requests are allowed."
    ]);
}
?>
