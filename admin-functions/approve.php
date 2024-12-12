<?php
session_start();
require_once "../classes/account.class.php";

$approveObj = new Accounts;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $accountDetails = $approveObj->fetchDetails($id);
        $approveObj->cleanRequest($accountDetails['username'], $accountDetails['password']);
        $approveObj->approveAccount($id);

        // Return a success message
        echo json_encode(["status" => "success", "message" => "Account approved successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "ID parameter missing."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
