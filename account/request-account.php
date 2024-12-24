<?php
require_once "../classes/account.class.php";
require_once "../classes/login.class.php";
$registerObj = new Accounts;
$loginObj = new Login;

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $registerObj->cleanCreation();

    $Username = $registerObj->username;
    $Password = $registerObj->password;
    $Dept = $registerObj->dept;
    $course = $registerObj->course;
    $email = $registerObj->email;

    $deptID = $loginObj->fetchDeptID($Dept);
    $courseID = $loginObj->getCourseID($course);
    

    $UsernameErr = errText(validateInput($Username, "text"));
    $PasswordErr = errText(validateInput($Password, "text"));
    $Errtxt = errText(validateInput($Password, "text"));

    $deptErr = errSelect(validateInput($Dept, "select"));
    $courseErr = errSelect(validateInput($course, "select"));
    $emailErr = errEmail(validateInput($email, "email"));

    if (empty($UsernameErr) && empty($PasswordErr) && empty($deptErr) && empty($courseErr) && empty($emailErr)){ 
        $registerObj->accountRequest($deptID,$courseID);
        header("location: login.php");
        exit;
    }
} 

if (isset($_POST['selectedValue']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $selectedDept = $_POST['selectedValue'];
    $selectedDeptID = $loginObj->findDeptID($selectedDept);
    $coursesData = $loginObj->getCourses($selectedDeptID);
    
    echo json_encode(["status" => "success", "data" => $coursesData]);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request An Account</title>
    <style>
        <?php require_once "../css/request-account.css"; ?>
    </style>
<script src="../vendor/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <script>
        var dept = document.querySelector("#Dept")
        $(function(){
            if(dept != ""){
                $('#Dept').on('change', function(e){
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'request-account.php',
                    data: {selectedValue: $(this).val()},
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            if (response.status === "success") {
                            $('#Course').empty();
                            $('#Course').append('<option value="" hidden>Select Course</option>');
                            $.each(response.data, function(index, course) {
                                $('#Course').append('<option value="' + course.courseName + '">' + course.courseName + '</option>');
                            });
                        }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred while processing your request.");
                    }
                });
            })
            }
        });
    </script>
</head>
<body>
    <section id="Background" class="bg-image">
        <div id="Request-Box">
            <div id="Request-Header">
                <img id="Logo" src="../imgs/WMSU_Logo.png" class="img-fluid" alt="">
                <h3 id="Title">Request An Account</h3>
            </div>

            <?php if(!empty($UsernameErr) || !empty($PasswordErr) || !empty($LoginErr) || !empty($deptErr) || !empty($courseErr) || !empty($emailErr)){?>
                <div id="errfields" class="alert alert-danger" role="alert">
                        <span id="err">
                            <?php if(!empty($UsernameErr) && !empty($PasswordErr)){
                                echo $Errtxt;
                            } ?>
                        </span> 

                        <span id="err">
                            <?php if(!empty($UsernameErr)){
                                echo $UsernameErr;
                            } ?>
                        </span> 

                        <span id="err">
                            <?php if(!empty($PasswordErr)){
                                echo $PasswordErr;
                            } ?>
                        </span> 
                        <span id="err">
                            <?php if(!empty($deptErr)){
                                echo $deptErr;
                            } ?>
                        </span> 
                        <span id="err">
                            <?php if(!empty($courseErr)){
                                echo $courseErr;
                            } ?>
                        </span> 
                        <span id="err">
                            <?php if(!empty($emailErr)){
                                echo $emailErr;
                            } ?>
                        </span> 

                </div>
            <?php } ?>
            <form id="Request-Form" action="" method="POST">
                <section id="FormFields">
                    <div id="Request-Form-Left">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="Input" placeholder="Username">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="Input" placeholder="Password">
                        <label for="Email">Email</label>
                        <input type="text" name="Email" id="Email" class="Input" placeholder="Email">
                    </div>
                    <div id="Request-Form-Right">
                        <label for="Dept">Department</label>
                        <select name="Dept" id="Dept" class="Input">
                        <option value="" hidden>Select Department</option>
                        <?php 
                        $deptData = $loginObj->getDept();
                        foreach ($deptData as $department) {
                            // Preserve the selected department on form reload
                            echo "<option value='{$department['departmentName']}'>{$department['departmentName']}</option>";
                        }
                        ?>
                    </select>
                    <label for="Course">Course</label>
                    <select name="Course" id="Course" class="Input">
                        <option value="">Select Course</option>
                        </select>
                    </div>
                </section>
                <div id="Buttons">
                    <input type="submit" value="Submit" name="submit">
                    <a href="./login.php" id="Cancel" class="btn">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>