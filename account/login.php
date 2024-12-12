<?php
session_start();
require_once __DIR__ . "/../classes/login.class.php";
$loginObject = new Login;

$UsernameErr = $PasswordErr = $LoginErr = $Errtxt = '';



if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $loginObject->clean();

    $Username = $loginObject->username;
    $Password = $loginObject->password;

    $UsernameErr = errText(validateInput($Username, "text"));
    $PasswordErr = errText(validateInput($Password, "text"));
    $Errtxt = errText(validateInput($Password, "text"));

    // errText function validates the input with the validateInput Function, if it passes the validateInput function it returns true
    // and the errText value is empty, otherwise false with a predefined errorTexts.
    // refer to /__includes/functions.php
    
    if (empty($UsernameErr) && empty($PasswordErr)) {
        if($loginObject->auth())
        {
            $_SESSION["account"] = $loginObject->fetchDetails();
            if ($_SESSION['account']['role'] == 1) {
                header('location: ../admin/pending-students');
            } else if ($_SESSION['account']['role'] == 3){
                header('location: ../student/landing-page');
            } else if ($_SESSION['account']['role'] == 2){
                header('location: ../staff/staff-thesis-list');
            }
            exit;
        }else{
            $LoginErr = "Invalid Username or Password";
        }
    }
}
?>

<!-- DEFAULT ADMIN CREDENTIALS:
username: hans123
password: admin 

Documentation:
    - all infos on the account stored in session, role handling is handled in session.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMSU Thesis Center</title>
    <style>
        <?php require_once "../css/login.css"; ?>
        <?php require_once "../vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css"; ?>
    </style>
</head>
<body>
    <section id="LogBG" class="bg-image">
        <div id="LoginBox">
            <div id="LoginHeader">
                <img id="Logo" src="../imgs/WMSU_Logo.png" class="img-fluid" alt="">
                <h4 id="Title" class=".inter-ProjectFont"> WMSU THESIS CENTER</h4>
            </div>
            <!-- ERROR MESSAGE -->
            <?php if(!empty($UsernameErr) || !empty($PasswordErr) || !empty($LoginErr)){?>
                <div id="errfields" class="alert alert-danger" role="alert">
                        <span id="err">
                            <?php if(!empty($UsernameErr) && !empty($PasswordErr)){
                                echo $Errtxt;
                            } ?>
                        </span> 

                        <span id="err">
                            <?php if(!empty($UsernameErr) && empty($PasswordErr)){
                                echo $UsernameErr;
                            } ?>
                        </span> 

                        <span id="err">
                            <?php if(!empty($PasswordErr) && empty($UsernameErr)){
                                echo $PasswordErr;
                            } ?>
                        </span> 

                        <span id="err">
                            <?php if(!empty($LoginErr)){
                                echo $LoginErr;
                            } ?>
                        </span> 
                </div>
            <?php } ?>
            <!-- ERROR MESSAGE -->
            <div id="FormFields">
                <form id="LoginForm" action="" method="POST">
                    <div>
                        <label for="Username">Username</label><span id="Required"> *</span>
                        <br>
                        <input type="text" name="username" id="username" placeholder="Username">
                    </div>
                    <div>
                        <label for="Password">Password</label><span id="Required"> *</span>
                        <br>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <a id="FG" href="">Forgot Password?</a>
                    <input type="submit" value="Login" name="submit">
                </form>
                <a href="./request-account.php" id="SignUp" class="btn">Request An Account</a>
            </div>
        </div>
    </section>
</body>
    <script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</html>