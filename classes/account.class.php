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
        function accountRequest(){
            $sql = "INSERT INTO accounts (username, password, role, status, email, department, course) 
            VALUES (:username, :password, 3, 'Pending', :email, :dept, :course)";
            $qry = $this->db->connect()->prepare($sql);

            $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
            
            $qry->bindParam(":username", $this->username);
            $qry->bindParam(":password", $hashPass);
            $qry->bindParam(":email", $this->email);
            $qry->bindParam(":dept", $this->dept);
            $qry->bindParam(":course", $this->course);


            return $qry->execute();
}


// ACCOUNT REQUEST


// STUDENT ACCOUNT TABLE
        function fetchData(){
            $sql = "SELECT * from accounts WHERE role = 3 AND status='Pending'";
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

                $sql2 = "UPDATE accounts SET status = 'Approved' WHERE id = :id AND role = 3";
                $qry2 = $this->db->connect()->prepare($sql2);

                $qry2->bindParam(":id", $id);

                return $qry2->execute();
            
        }

        function rejectAccount($id){
            $sql = "UPDATE accounts SET status='Rejected' WHERE id = :id AND role = 3";
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

    function searchAndSortAccounts($searchTerm, $sortBy = 'date_created', $sortOrder = 'ASC', $filters = []) {
        // Base SQL query
        $sql = "SELECT *
                FROM accounts
                WHERE (username LIKE :searchTerm OR email LIKE :searchTerm OR department LIKE :searchTerm OR course LIKE :searchTerm)";
        
        // Add department filter if provided
        if (!empty($filters['department'])) {
            $sql .= " AND department = :department"; // 'department' corresponds to 'department'
        }
    
        // Add course filter if provided
        if (!empty($filters['course'])) {
            $sql .= " AND course = :course";
        }
    
        // Add sorting to the query
        $sql .= " ORDER BY " . $sortBy . " " . $sortOrder;
    
            // Get the database connection
            $qry = $this->db->connect()->prepare($sql);
    
            // Bind the search term to the query with wildcards for partial matching
            $searchTermWithWildcards = "%" . $searchTerm . "%";
            $qry->bindParam(":searchTerm", $searchTermWithWildcards);
    
            // Bind additional filters to the query
            if (!empty($filters['department'])) {
                $qry->bindParam(":department", $filters['department']);
            }
            if (!empty($filters['course'])) {
                $qry->bindParam(":course", $filters['course']);
            }
    
            // Execute the query
            $qry->execute();
    
            // Fetch the results as an associative array
            $results = $qry->fetchAll(PDO::FETCH_ASSOC);
    
            // Return the results, or an empty array if no matches
            return $results;
    

    }
    
    
    

}
    //
?>