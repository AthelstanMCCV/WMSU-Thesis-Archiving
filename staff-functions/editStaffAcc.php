<?php
    session_start();
    require_once "../classes/account.class.php";
    require_once "../tools/functions.php";

    $editStaffObj = new Accounts;
    $staffID = $_GET['id'];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $editStaffObj->cleanStaffAdd();
        
        $username = $editStaffObj->username;
        $password = $editStaffObj->password;
        $email = $editStaffObj->email;
        $accountID = $staffID;
        $usernameErr = $passwordErr = $emailErr = '';

        if(empty($username)){
            $usernameErr = 'Name is required.';
        }

        if(empty($password)){
            $passwordErr = 'Password is required.';
        }

        if(empty($email)){
            $emailErr = 'Email is required.';
        }

        if(!empty($usernameErr) || !empty($passwordErr) || !empty($emailErr)){
            echo json_encode([
                'status' => 'error',
                'usernameErr' => $usernameErr,
                'passwordErr' => $passwordErr,
                'emailErr' => $emailErr,
            ]);
            exit;
        }

        if (empty($usernameErr) && empty($passwordErr) && empty($emailErr)){ 
            if($editStaffObj->editStaffAcc($accountID)){
                echo json_encode(['status' => 'success']);
            }else {
                echo json_encode(['status' => 'error', 'message' => 'Something went wrong when adding the new product.']);
            }
            exit;
        }
    }
?>