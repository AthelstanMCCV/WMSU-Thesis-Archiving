<?php
session_start();
require_once "../classes/login.class.php";

$loginObj = new Login;

if (isset($_POST['selectedValue']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $selectedDept = $_POST['selectedValue'];
    $selectedDeptID = $loginObj->findDeptID($selectedDept); // Adjust based on your database structure
    $coursesData = $loginObj->getCourses($selectedDeptID);

    $_SESSION['addmember']['dept'] = $selectedDeptID;
    header('Content-Type: application/json');
    echo json_encode(["status" => "success", "data" => $coursesData]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courses'])) {
        $courses = $_POST['courses']; // This is the array of selected courses
        
        $_SESSION['addmember']['course'] = $courses;    
}
}
?>
<div class="modal fade" id="addMemberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Member Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-add-modal">
                <div id="addMemberModal" class="modal-body">
                  <div class="modal-content1">
                    <div class="mb-2">
                          <label for="studentID" class="form-label">Student ID</label>
                          <input type="text" name="studentID" id="studentID" class="form-control" placeholder="Student ID">
                          <div class="invalid-feedback"></div>
                      </div>
                  
                      <div class="mb-2">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="mb-2">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                          <div class="invalid-feedback"></div>
                      </div>

                      <div class="mb-2">
                          <label for="lastName" class="form-label">Last Name</label>
                          <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name">
                          <div class="invalid-feedback"></div>
                      </div>
                  </div>
                  <div class="modal-content2">
                    <div class="mb-2">
                          <label for="firstName" class="form-label">First Name</label>
                          <input type="text" name="firstName" id="firstName" class="form-control" placeholder="First Name">
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="mb-2">
                          <label for="middleName" class="form-label">Middle Name</label>
                          <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name">
                          <div class="invalid-feedback"></div>
                      </div>    
                      <div id="dynamicFields">
    <div class="mb-2 dynamic-fields">
        <label for="Dept" class="form-label">Department</label>
        <select name="Dept[]" id="Dept" class="form-select">
            <option value="" hidden>Select Department</option>
            <!-- Dynamic Department options -->
        </select>
    </div>
    <div class="mb-2 dynamic-fields">
        <label for="Course" class="form-label">Course</label>
        <select name="Course[]" class="form-select">
            <option value="" hidden>Select Course</option>
            <!-- Dynamic Course options -->
        </select>
    </div>
</div>
                  </div>
                
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger brand-bg-color">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>