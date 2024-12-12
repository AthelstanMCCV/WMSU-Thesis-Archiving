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
        $sql = "SELECT * FROM accounts WHERE role = 3";
        $qry = $this->db->connect()->prepare($sql);

        if($qry->execute()){
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

}



?>