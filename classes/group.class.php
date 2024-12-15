<?php 
require_once "../classes/db_connection.class.php";
require_once "../tools/functions.php";

Class Group{

    public $studentID;
    public $groupID;

    public $username;
    
    public $password;

    public $lastName;
    public $firstName;
    public $middleName;

    public $courseID;
    public $deptID;
    protected $db;

    function __construct(){
        $this->db = new Database;
    }

    function cleanMembers(){
        $this->studentID = cleanInput($_POST['studentID']);         
        $this->username = cleanInput($_POST['username']);
        $this->password = cleanInput($_POST['password']);
        $this->lastName = cleanInput($_POST['lastName']);
        $this->firstName = cleanInput($_POST['firstName']);
        $this->middleName = cleanInput($_POST['middleName']);
    }

    function editCleanMembers(){
        $this->lastName = cleanInput($_POST['lastName']);
        $this->username = cleanInput($_POST['username']);
        $this->password = cleanInput($_POST['password']);
        $this->firstName = cleanInput($_POST['firstName']);
        $this->middleName = cleanInput($_POST['middleName']);
    }
    function addMembers($id, $courseID, $deptID){
        $sql = "INSERT INTO groupmembers (studentID, groupID, username, password, lastName, firstName, middleName)
                VALUES (:studentID, :groupID, :username, :password, :lastName, :firstName, :middleName)";
        $qry = $this->db->connect()->prepare($sql);

        $hashPass = password_hash($this->password, PASSWORD_DEFAULT);

        $qry->bindParam(":studentID", $this->studentID);
        $qry->bindParam(":groupID", $id);
        $qry->bindParam(":username", $this->username);
        $qry->bindParam(":password", $hashPass);
        $qry->bindParam(":lastName", $this->lastName);
        $qry->bindParam(":firstName", $this->firstName);
        $qry->bindParam(":middleName", $this->middleName);

            $qry->execute();

            $sql2 = "INSERT INTO author (groupID, studentID,  departmentID, coursesID)
                    VALUES (:groupID, :studentID, :departmentID, :courseID)";
            $qry2 = $this->db->connect()->prepare($sql2);

            $qry2->bindParam(":groupID", $id);
            $qry2->bindParam(":studentID", $this->studentID);
            $qry2->bindParam(":departmentID", $deptID);
            $qry2->bindParam(":courseID", $courseID);

            return $qry2->execute();
    }

    function fetchMemberData($ID){
        $sql = "SELECT *  from groupmembers WHERE studentID = :ID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":ID", $ID);

        $qry->execute();

        $data = $qry->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    function deleteMember($ID){
        $sql = "DELETE FROM groupmembers WHERE studentID = :ID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":ID", $ID);

        return $qry->execute();
    }

    function editMembers($ID){
        $sql = "UPDATE groupmembers SET username = :username, password = :password, lastName = :lastName, firstName = :firstName, middleName = :middleName WHERE studentID = :ID";
        $qry = $this->db->connect()->prepare($sql);
        
        $hashPass = password_hash($this->password, PASSWORD_DEFAULT);

        $qry->bindParam(":ID", $ID);
        $qry->bindParam(":username", $this->username);  
        $qry->bindParam(":password",$hashPass);
        $qry->bindParam(":lastName", $this->lastName);
        $qry->bindParam(":firstName", $this->firstName);
        $qry->bindParam(":middleName", $this->middleName);

        return $qry->execute();
    }

    function fetchGroupMembers($groupID){
        $sql = "SELECT studentID, accounts.username as accName, groupmembers.username, lastName, firstName, middleName
            from groupmembers LEFT JOIN accounts
            ON groupmembers.groupID = accounts.ID
            WHERE groupID = :groupID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();

        $data = $qry->fetchAll();

        return $data;

    }

    function fetchAllGroups(){
        $sql = "SELECT *, department.departmentName, courses.courseName FROM accounts LEFT JOIN department ON departmentID = accounts.department
        LEFT JOIN courses ON courseID = accounts.course WHERE role = 3";
        $qry = $this->db->connect()->prepare($sql);

        if($qry->execute()){
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

}



?>