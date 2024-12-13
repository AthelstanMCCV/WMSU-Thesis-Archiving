<?php
require_once "../tools/functions.php";
require_once __DIR__ . "/db_connection.class.php";

    Class Accounts{

        public $id;       
        public $groupName;
        public $username;
        public $password;
        public $dept;
        public $course;
        public $email;

        protected $db;
    

        function __construct(){
            $this->db = new Database;
        }

        // FOR PASSING FROM accountRequest table to main groups table
        function cleanRequest($username, $password){
            $this->username = cleanInput($username);
            $this->password = cleanInput($password);
        }
        
        // FOR THE CREATION OF ACCOUNTS
        function cleanCreation(){
            // $this->groupName = cleanInput($_POST['groupName']);
            $this->username = cleanInput($_POST['username']);
            $this->password = cleanInput($_POST['password']);
            $this->dept = cleanInput($_POST['Dept']);
            $this->course = cleanInput($_POST['Course']);
            $this->email = cleanInput($_POST['Email']);

            // $this->studentID = cleanInput($_POST['studentID']);
            // $this->lastName = cleanInput($_POST['lastName']);
            // $this->firstName = cleanInput($_POST['firstName']);
            // $this->middleName = cleanInput($_POST['middleName']);
        }

        function cleanStaffAdd(){
            $this->username = cleanInput($_POST['username']);
            $this->password = cleanInput($_POST['password']);
            $this->email = cleanInput($_POST['Email']);
        }




// ACCOUNT REQUEST
        function accountRequest($deptID, $courseID){
            $sql = "INSERT INTO accounts (username, password, role, status, email, department, course) 
            VALUES (:username, :password, 3, 1, :email, :deptID, :courseID)";
            $qry = $this->db->connect()->prepare($sql);

            $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
            
            $qry->bindParam(":username", $this->username);
            $qry->bindParam(":password", $hashPass);
            $qry->bindParam(":email", $this->email);
            $qry->bindParam(":deptID", $deptID);
            $qry->bindParam(":courseID", $courseID);


            return $qry->execute();
}


// ACCOUNT REQUEST


// STUDENT ACCOUNT TABLE
        function fetchData(){
            $sql = "SELECT *,departmentName, courseName from accounts LEFT JOIN department on departmentID = accounts.department
            LEFT JOIN courses on courseID = accounts.course WHERE role = 3 AND status=1";
            $qry = $this->db->connect()->prepare($sql);

            $qry->execute();
            $data = $qry->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }

        function fetchSpecificStaffData($ID){
            $sql = "SELECT * from staffaccounts WHERE staffAdminID = :staffAdminID";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":staffAdminID", $ID);

            $qry->execute();
            $data = $qry->fetch(PDO::FETCH_ASSOC);

            return $data;
        }

        function fetchStaffData($ID){
            $sql = "SELECT staffaccounts.*, accounts.username as assocAcc from staffaccounts
                    LEFT JOIN accounts ON accounts.ID = staffaccounts.ID WHERE staffaccounts.ID = :ID";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":ID", $ID);

            $qry->execute();
            $data = $qry->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }


        function fetchDetails($id){
                $sql = "SELECT * from accounts WHERE id =:id AND role = 3";
                $qry = $this->db->connect()->prepare($sql);

                $qry->bindParam(":id", $id);
    
                $qry->execute();
                $data = $qry->fetch(PDO::FETCH_ASSOC);
    
                return $data;

        }

        // Push approved Accounts into accounts table;
        function approveAccount($id){

                $sql2 = "UPDATE accounts SET STATUS = 2 WHERE id = :id AND role = 3";
                $qry2 = $this->db->connect()->prepare($sql2);

                $qry2->bindParam(":id", $id);

                return $qry2->execute();
            
        }

        function rejectAccount($id){
            $sql = "UPDATE accounts SET status= 3 WHERE id = :id AND role = 3";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":id", $id);

            return $qry->execute();

        }
// STUDENT ACCOUNT TABLE
    


    //STAFF ADDING

    function addStaffAdmin($ID){

        $sql = "INSERT INTO staffaccounts (ID, username, password, email) 
        VALUES (:ID, :username, :password, :email)";
        $qry = $this->db->connect()->prepare($sql);

        $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
        
        $qry->bindParam(":ID", $ID);
        $qry->bindParam(":username", $this->username);
        $qry->bindParam(":password", $hashPass);
        $qry->bindParam(":email", $this->email);

        return $qry->execute();

    }

    function editStaffAcc($accountID){

        if(!empty($this->password)){
            $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "UPDATE staffaccounts SET username = :username, password = :password, email = :email WHERE staffAdminID = :accountID";
            $qry = $this->db->connect()->prepare($sql);

            
            $qry->bindParam(":password", $hashPass);
        } else{
            $sql = "UPDATE staffaccounts SET username = :username, email = :email WHERE staffAdminID = :accountID";
            $qry = $this->db->connect()->prepare($sql);

        }
        
        $qry->bindParam(":accountID", $accountID);
        $qry->bindParam(":username", $this->username);
        $qry->bindParam(":email", $this->email);

        return $qry->execute();
    }

    function deleteStaffAcc($ID){
        $sql = "DELETE FROM staffaccounts WHERE staffAdminID = :staffAdminID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":staffAdminID", $ID);
        return $qry->execute();
    }

    function fetchAccountData($ID){
        $sql = "SELECT *, departmentName, courseName from accounts LEFT JOIN courses ON accounts.course = courses.courseID
        LEFT JOIN department ON accounts.department = department.departmentID WHERE accounts.ID = :ID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":ID", $ID);
        
        $qry->execute();
        $data = $qry->fetch(PDO::FETCH_ASSOC);

        return $data;
    }



    

// function addAccount($deptID = NULL, $courseID = NULL){
//     $sql = "INSERT INTO accounts (username, password, role, status, email, department, course) 
//     VALUES (:username, :password, 2, 2, :email, :deptID, :courseID)";
//     $qry = $this->db->connect()->prepare($sql);

//     $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
    
//     $qry->bindParam(":username", $this->username);
//     $qry->bindParam(":password", $hashPass);
//     $qry->bindParam(":email", $this->email);
//     $qry->bindParam(":deptID", $deptID);
//     $qry->bindParam(":courseID", $courseID);


//     return $qry->execute();
// }

}
    // $testObj = new Accounts;
    // $testObj->addAccount();
?>