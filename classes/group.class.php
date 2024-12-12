<?php 
require_once "../classes/db_connection.class.php";
require_once "../tools/functions.php";

Class Group{

    public $studentID;
    public $groupID;
    public $lastName;
    public $firstName;
    public $middleName;

    protected $db;

    function __construct(){
        $this->db = new Database;
    }

    function cleanMembers(){
        $this->studentID = cleanInput($_POST['studentID']);
        $this->lastName = cleanInput($_POST['lastName']);
        $this->firstName = cleanInput($_POST['firstName']);
        $this->middleName = cleanInput($_POST['middleName']);
    }

    function editCleanMembers(){
        $this->lastName = cleanInput($_POST['lastName']);
        $this->firstName = cleanInput($_POST['firstName']);
        $this->middleName = cleanInput($_POST['middleName']);
    }
    function addMembers($id){
        $sql = "INSERT INTO groupmembers (studentID, groupID, lastName, firstName, middleName)
                VALUES (:studentID, :groupID, :lastName, :firstName, :middleName)";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":studentID", $this->studentID);
        $qry->bindParam(":groupID", $id);
        $qry->bindParam(":lastName", $this->lastName);
        $qry->bindParam(":firstName", $this->firstName);
        $qry->bindParam(":middleName", $this->middleName);

        return $qry->execute();
    }

    function fetchMemberData($ID){
        $sql = "SELECT * from groupmembers WHERE studentID = :ID";
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
        $sql = "UPDATE groupmembers SET lastName = :lastName, firstName = :firstName, middleName = :middleName WHERE studentID = :ID";
        $qry = $this->db->connect()->prepare($sql);
        
        $qry->bindParam(":ID", $ID);
        $qry->bindParam(":lastName", $this->lastName);
        $qry->bindParam(":firstName", $this->firstName);
        $qry->bindParam(":middleName", $this->middleName);

        return $qry->execute();
    }

    function fetchGroupMembers($groupID){
        $sql = "SELECT studentID, accounts.username, lastName, firstName, middleName
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