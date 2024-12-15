<?php
require_once "../tools/functions.php";
require_once __DIR__ . "/db_connection.class.php";
    Class Login{

        public $id;
        public $username = "library";
        public $password = "admin";
        public $role;
        protected $db;

        function __construct(){
            $this->db = new Database;

        }

        function clean(){
            $this->username = cleanInput($_POST['username']);
            $this->password = cleanInput($_POST['password']);
        }

        function auth(){
            $sql = "SELECT username, password, role, status from accounts WHERE username = :username";
            $qry = $this->db->connect()->prepare($sql);
            
            $qry->bindParam(":username", $this->username);
            $qry->execute();

            if($data = $qry->fetch()){

                if ($data['role'] == 1 || $data['role'] == 2 && password_verify($this->password, $data['password'])){
                    return $data;
                }

                if ($data['role'] == 3 && $data['status'] == 2 && password_verify($this->password, $data['password'])){
                    return $data;
                }
            }
            if (!$data){

                $sqlstaff = "SELECT staffaccounts.ID, staffaccounts.username, staffaccounts.password, accounts.role, accounts.status FROM staffaccounts
                             LEFT JOIN accounts ON staffaccounts.ID = accounts.ID
                             WHERE staffaccounts.username = :username ";
                $qrystaff = $this->db->connect()->prepare($sqlstaff);
                
                $qrystaff->bindParam(":username", $this->username);
                $qrystaff->execute();

                $datastaff = $qrystaff->fetch();

                if ($datastaff && password_verify($this->password, $datastaff['password'])){
                    return $datastaff;
                }

                if (!$datastaff){
                    $sqlstudent = "SELECT groupmembers.studentID, groupmembers.username, groupmembers.password, lastName, firstName, middleName FROM groupmembers
                             LEFT JOIN accounts ON groupmembers.groupID = accounts.ID
                             WHERE groupmembers.username = :username ";
                $qrystudent = $this->db->connect()->prepare($sqlstudent);
                
                $qrystudent->bindParam(":username", $this->username);
                $qrystudent->execute();

                $datastudent = $qrystudent->fetch();

                if ($datastudent && password_verify($this->password, $datastudent['password'])){
                    return $datastudent;
                }
                }

            }
        

            return null;
        }   

        function fetchDetails(){
            $sql = "SELECT * FROM accounts WHERE username = :username";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":username", $this->username);

            $qry->execute();

            if($data = $qry->fetch(PDO::FETCH_ASSOC)){
                return $data;
            }

                $sqlstaff = "SELECT * FROM staffaccounts WHERE username = :username";
                $qrystaff = $this->db->connect()->prepare($sqlstaff);
                
                $qrystaff->bindParam(":username", $this->username);
                $qrystaff->execute();

                if ($datastaff = $qrystaff->fetch(PDO::FETCH_ASSOC)){
                    return $datastaff;
                }

                $sqlstudent = "SELECT studentID, groupID as ID,status, role, username, password, lastName, firstName, middleName FROM groupmembers WHERE username = :username";
                $qrystudent = $this->db->connect()->prepare($sqlstudent);
                
                $qrystudent->bindParam(":username", $this->username);
                $qrystudent->execute();

                if ($datastudent = $qrystudent->fetch(PDO::FETCH_ASSOC)){
                    return $datastudent;
                }



            return null;

        }


        function getDept() {

            $sql = "SELECT departmentName FROM department";
            $qry = $this->db->connect()->prepare($sql);
            $qry->execute();
            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
        
            return $data;
        }

        function findDeptID($deptName){
            $sql = "SELECT departmentID from department WHERE departmentName = :deptName";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":deptName", $deptName);
            $qry->execute();

            $data = $qry->fetchColumn();

            return $data;
        }

        function fetchDeptID($deptName){
            $sql = "SELECT departmentID from department WHERE departmentName = :deptName";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":deptName", $deptName);
            $qry->execute();

            $data = $qry->fetchColumn();

            return $data;
        }
        
        function getCourses($deptID){
        $sql2 = "SELECT courseName FROM courses WHERE departmentID = :deptID";
        $qry2 = $this->db->connect()->prepare($sql2);
        $qry2->bindParam(":deptID", $deptID);
        $qry2->execute();
        $data = $qry2->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

        function getCourseID($courseName){
        $sql2 = "SELECT courseID FROM courses WHERE courseName = :courseName";
        $qry2 = $this->db->connect()->prepare($sql2);
        $qry2->bindParam(":courseName",$courseName);
        $qry2->execute();
        $data = $qry2->fetchColumn();

        return $data;
        }
    }

?>