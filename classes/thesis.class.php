<?php
require_once __DIR__ . "/db_connection.class.php";
require_once "../tools/functions.php";
Class Thesis{

    public $thesisID;
    public $thesisTitle;
    public $datePublished;
    public $advisorName;
    public $shortDesc;

    protected $db;
    function __construct(){
        $this->db = new Database;
    }

    function cleanThesis(){
        $this->thesisTitle = cleanInput($_POST['thesisTitle']);
        $this->datePublished = cleanInput($_POST['datePublished']);
        $this->advisorName = cleanInput($_POST['advisorName']);
        $this->shortDesc = cleanInput($_POST['shortDesc']);
    }

    function addThesis($groupID){
        $sql = "INSERT INTO thesis (thesisTitle, datePublished, advisorName, abstract, groupID)
                VALUES (:thesisTitle, :datePublished, :advisorName, :shortDesc, :groupID)";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisTitle", $this->thesisTitle);
        $qry->bindParam(":datePublished", $this->datePublished);
        $qry->bindParam(":advisorName", $this->advisorName);
        $qry->bindParam(":shortDesc", $this->shortDesc);
        $qry->bindParam(":groupID", $groupID);

        return $qry->execute();
    }
    
    function fetchThesis($groupID){
        $sql = "SELECT *, statusName from thesis LEFT JOIN status ON thesis.status = status.statusID WHERE groupID = :groupID" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchgroupID($thesisID){
        $sql = "SELECT groupID from thesis WHERE thesisID = :thesisID" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetchColumn();

        return $data;

    }

    function fetchThesisID($thesisTitle){
        $sql = "SELECT thesisID from thesis WHERE thesisTitle = :thesisTitle" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisTitle", $thesisTitle);

        $qry->execute();
        $data = $qry->fetchColumn();

        return $data;

    }

    function fetchAllGroupThesis(){
        $sql = "SELECT dateAdded, username, thesisID, thesisTitle, statusName from thesis 
                LEFT JOIN accounts ON groupID = accounts.ID
                LEFT JOIN status ON thesis.status = status.statusID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
        
    }
    function fetchAllPendingThesis(){
        $sql = "SELECT datePublished, advisorName, dateAdded, username, thesisID, thesisTitle, abstract, statusName from thesis 
                LEFT JOIN accounts ON groupID = accounts.ID
                LEFT JOIN status ON thesis.status = status.statusID WHERE thesis.status = 1";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
        
    }

    function setApproveThesis($thesisID){
        $sql = "UPDATE thesis SET status=2, notes='' WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        return $qry->execute(); 
    }

    function fetchNotPendingThesis(){
        $sql = "SELECT * from thesis WHERE status != 1";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchApprovedThesis($groupID){
        $sql = "SELECT *,statusName from thesis LEFT JOIN status ON thesis.status = status.statusID WHERE STATUS = 2 AND groupID = :groupID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;

    }
    function fetchAllApprovedThesis(){
        $sql = "SELECT * from thesis 
        LEFT JOIN accounts ON thesis.groupID = accounts.ID
        WHERE thesis.STATUS = 2";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchSpecificThesis($thesisID){

        $sql = "SELECT *,statusName FROM thesis LEFT JOIN status ON thesis.status = status.statusID WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);
        
        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
    function fetchSpecificRequestThesis($thesisID){

        $sql = "SELECT *, statusName FROM thesis LEFT JOIN status ON thesis.status = status.statusID WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);
        
        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    function fetchThesisStatus($thesisID){
        $sql = "SELECT status FROM thesis WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);
        
        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetchColumn();

        return $data;
    }

    function passtoApproval($staffID, $thesisID, $groupID, $status){
        $sql2 = "INSERT INTO thesis_approval (staffID, groupID, thesisID, status)
        VALUES (:staffID, :groupID, :thesisID, :status)";

        $qry2 = $this->db->connect()->prepare($sql2);

        $qry2->bindParam(":staffID", $staffID);
        $qry2->bindParam(":groupID", $groupID);
        $qry2->bindParam(":thesisID", $thesisID);
        $qry2->bindParam(":status", $status);

        return $qry2->execute();
    }

    function validateApproval($thesisID){
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND STATUS =2" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetchColumn();

        if ($data == 2){
            return true;
        }
        return false;
    }

    function checkApproval($staffID, $thesisID){
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND staffID = :staffID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":staffID", $staffID);

        $qry->execute();
        $data = $qry->fetchColumn();

        return $data > 0;
    }

    function hasConflict($thesisID) {
        $sql = "
            SELECT 
                COUNT(DISTINCT CASE WHEN STATUS = 2 THEN staffID END) AS approvals,
                COUNT(DISTINCT CASE WHEN STATUS = 3 THEN staffID END) AS rejections
            FROM thesis_approval
            WHERE thesisID = :thesisID";
    
        $qry = $this->db->connect()->prepare($sql);
        $qry->bindParam(":thesisID", $thesisID);
        $qry->execute();
        $result = $qry->fetch(PDO::FETCH_ASSOC);
    
        return $result['approvals'] > 0 && $result['rejections'] > 0; // Returns true if conflict exists
    }
    
    function approveThesis($staffID, $groupID, $thesisID, $status){

        $sql = "UPDATE thesis SET STATUS = 2 WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();

        $sql2 = "INSERT INTO thesislogs (staffID, groupID, thesisID, status)
                VALUES (:staffID, :groupID, :thesisID, :status)";

        $qry2 = $this->db->connect()->prepare($sql2);

        $qry2->bindParam(":staffID", $staffID);
        $qry2->bindParam(":groupID", $groupID);
        $qry2->bindParam(":thesisID", $thesisID);
        $qry2->bindParam(":status", $status);

        return $qry2->execute();
    
}

    function recordThesis($staffID = NULL, $groupID, $thesisID){
        $sql2 = "INSERT INTO thesislogs (staffID, groupID, thesisID)
                VALUES (:staffID, :groupID, :thesisID)";

        $qry2 = $this->db->connect()->prepare($sql2);

        $qry2->bindParam(":staffID", $staffID);
        $qry2->bindParam(":groupID", $groupID);
        $qry2->bindParam(":thesisID", $thesisID);
        return $qry2->execute();
    }

    function rejectThesis($staffID, $groupID, $thesisID, $status){
        $sql = "UPDATE thesis SET status=3 WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();

            $sql2 = "INSERT INTO thesislogs (staffID, groupID, thesisID, status)
            VALUES (:staffID, :groupID, :thesisID, :status)";

            $qry2 = $this->db->connect()->prepare($sql2);

            $qry2->bindParam(":staffID", $staffID);
            $qry2->bindParam(":groupID", $groupID);
            $qry2->bindParam(":thesisID", $thesisID);
            $qry2->bindParam(":status", $status);

            return $qry2->execute();

    }

    function fetchThesisLogs($groupID){
        $sql = "SELECT approvalID, accounts.username, thesisTitle, status.statusName, actionDate  from thesislogs LEFT JOIN thesis
                ON thesislogs.thesisID = thesis.thesisID
                LEFT JOIN accounts ON thesislogs.staffID = accounts.ID
                LEFT JOIN staffaccounts ON thesislogs.staffID = staffaccounts.ID
                LEFT JOIN status ON thesislogs.status = status.statusID WHERE thesislogs.groupID = :groupID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchThesisEditReq(){
        $sql = "SELECT thesisActionReqID, username, thesiseditreq.advisorName, thesis.thesisID, thesiseditreq.thesisTitle, thesiseditreq.abstract, dateRequested, action FROM thesiseditreq 
                LEFT JOIN accounts ON groupID = accounts.ID
                LEFT JOIN thesisactionreq ON thesiseditreq.thesisID = thesisactionreq.thesisID
                LEFT JOIN thesis ON thesis.thesisID = thesiseditreq.thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchSpecificEditReq($thesisID){
        $sql = "SELECT *, statusName FROM thesiseditreq LEFT JOIN status ON thesiseditreq.status = status.statusID WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->execute();

        $data = $qry->fetch(PDO::FETCH_ASSOC);

        return $data;

    }

    function fetchSpecificThesisActionReq($reqID){
        $sql = "SELECT * from thesisactionreq WHERE thesisActionReqID = :reqID" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":reqID", $reqID);

        $qry->execute();
        $data = $qry->fetch(PDO::FETCH_ASSOC);

    return $data;
    }

    function confirmEdit($thesisID, $thesisTitle, $datePublished, $reqID, $shortDesc){
        $sql2 = "DELETE FROM thesisactionreq WHERE thesisActionReqID = :reqID";
        $qry2 = $this->db->connect()->prepare($sql2);

        $qry2->bindParam(":reqID", $reqID);

        $qry2->execute();

        $sql3 = "DELETE FROM thesiseditreq WHERE thesisID = :thesisID";
        $qry3 = $this->db->connect()->prepare($sql3);

        $qry3->bindParam(":thesisID", $thesisID);

        $qry3->execute();

            $sql = "UPDATE thesis SET thesisTitle = :thesisTitle, datePublished = :datePublished, abstract = :shortDesc WHERE thesisID = :thesisID";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":thesisID", $thesisID);
            $qry->bindParam(":thesisTitle", $thesisTitle);
            $qry->bindParam(":datePublished", $datePublished);
            $qry->bindParam(":shortDesc", $shortDesc);

            return $qry->execute();
    }

    function thesisActionReq($status, $action, $thesisID, $groupID){

        $sql = "UPDATE thesis SET status = :status WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":status", $status);

        $qry->execute();

            $sql2 = "INSERT INTO thesisactionreq (groupID, thesisID, action)
            VALUES (:groupID, :thesisID, :action)";

            $qry2 = $this->db->connect()->prepare($sql2);

            $qry2->bindParam(":groupID", $groupID);
            $qry2->bindParam(":thesisID", $thesisID);
            $qry2->bindParam(":action", $action);

            return $qry2->execute();
    }

    function reqeditThesis($thesisID, $groupID){
        $sql = "INSERT INTO thesiseditreq (thesisID, thesisTitle, advisorName, abstract, datePublished, groupID)
                VALUES (:thesisID, :thesisTitle,:advisorName, :shortDesc, :datePublished, :groupID)";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":thesisTitle", $this->thesisTitle);
        $qry->bindParam(":datePublished", $this->datePublished);
        $qry->bindParam(":advisorName", $this->advisorName);
        $qry->bindParam(":shortDesc", $this->shortDesc);
        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
    }

    function confirmDelete($thesisID, $reqID){
            $sql2 = "DELETE FROM thesisactionreq WHERE thesisActionReqID = :reqID";
            $qry2 = $this->db->connect()->prepare($sql2);

            $qry2->bindParam(":reqID", $reqID);

            $qry2->execute();

                $sql3 = "DELETE FROM thesis_approval WHERE thesisID = :thesisID";
                $qry3 = $this->db->connect()->prepare($sql3);

                $qry3->bindParam(":reqID", $reqID);

                $qry3->execute();

                    $sql = "DELETE FROM thesis WHERE thesisID = :thesisID";
                    $qry = $this->db->connect()->prepare($sql);

                    $qry->bindParam(":thesisID", $thesisID);

                    return $qry->execute();

    }

    function denyReq($reqID, $action = NULL, $thesisID = NULL){
        $sql2 = "DELETE FROM thesisactionreq WHERE thesisActionReqID = :reqID";
            $qry2 = $this->db->connect()->prepare($sql2);

            $qry2->bindParam(":reqID", $reqID);

                if ($action == "Edit"){
                    $sql = "DELETE FROM thesiseditreq WHERE thesisID = :thesisID";
                    $qry = $this->db->connect()->prepare($sql);

                    $qry->bindParam(":thesisID",$thesisID);

                    $qry->execute();
                }
                
            return $qry2->execute();
    }

    function denyThesis($thesisID, $action){

        if($action == 'Edit'){
        $sql = "UPDATE thesis SET status=2, notes ='Edit Request Denied'  WHERE thesisID = :thesisID";
        }

        if($action == 'Delete'){
        $sql = "UPDATE thesis SET status=2, notes ='Delete Request Denied'  WHERE thesisID = :thesisID";
        }
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        return $qry->execute(); 
    }

    function searchAndSortApprovedTheses($searchTerm) {
        $sql = "SELECT thesis.datePublished, accounts.username, thesis.advisorName, thesis.thesisTitle, thesis.abstract
                FROM thesis
                LEFT JOIN accounts ON thesis.groupID = accounts.ID WHERE (thesisTitle LIKE :searchTerm OR advisorName LIKE :searchTerm) AND thesis.STATUS = 2";
            
            $qry = $this->db->connect()->prepare($sql);
    
            $searchTermWithWildcards = "%" . $searchTerm . "%";
            $qry->bindParam(":searchTerm", $searchTermWithWildcards, PDO::PARAM_STR);
    
            $qry->execute();
    
            $results = $qry->fetchAll(PDO::FETCH_ASSOC);
    
            return $results;
        }

    function clearNotes($thesisID){
        $sql = "UPDATE thesis SET notes='' WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        return $qry->execute();
        
    }

    function validateRejection($thesisID){
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND STATUS = 3" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetchColumn();

        if ($data == 2){
            return true;
        }
        return false;
    }
    
}

?>