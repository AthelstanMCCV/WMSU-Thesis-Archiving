<?php
require_once __DIR__ . "/db_connection.class.php";
require_once "../tools/functions.php";
Class Thesis{

    public $thesisID;
    public $thesisTitle;
    public $datePublished;

    protected $db;
    function __construct(){
        $this->db = new Database;
    }

    function cleanThesis(){
        $this->thesisTitle = cleanInput($_POST['thesisTitle']);
        $this->datePublished = cleanInput($_POST['datePublished']);
    }

    function addThesis($groupID){
        $sql = "INSERT INTO thesis (thesisTitle, datePublished, groupID)
                VALUES (:thesisTitle, :datePublished, :groupID)";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisTitle", $this->thesisTitle);
        $qry->bindParam(":datePublished", $this->datePublished);
        $qry->bindParam(":groupID", $groupID);

        return $qry->execute();
    }
    
    function fetchThesis($groupID){
        $sql = "SELECT * from thesis WHERE groupID = :groupID" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchAllThesis(){
        $sql = "SELECT thesis.*, accounts.username FROM thesis
                LEFT JOIN accounts ON thesis.groupID = accounts.ID" ;
        $qry = $this->db->connect()->prepare($sql);

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
        $sql = "SELECT dateAdded, username, thesisID, thesisTitle, thesis.status from thesis 
                LEFT JOIN accounts ON groupID = accounts.ID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
        
    }
    function fetchAllPendingThesis(){
        $sql = "SELECT datePublished, advisorName, dateAdded, username, thesisID, thesisTitle, thesis.status from thesis 
                LEFT JOIN accounts ON groupID = accounts.ID WHERE thesis.status = 'Pending'";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
        
    }

    function setApproveThesis($thesisID){
        $sql = "UPDATE thesis SET status='Approved', notes='Edit Request Apporoved' WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        return $qry->execute(); 
    }

    function fetchNotPendingThesis(){
        $sql = "SELECT * from thesis WHERE status != 'Pending'";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchApprovedThesis($groupID){
        $sql = "SELECT * from thesis WHERE status = 'Approved' AND groupID = :groupID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;

    }
    function fetchAllApprovedThesis(){
        $sql = "SELECT * from thesis 
        LEFT JOIN accounts ON thesis.groupID = accounts.ID
        WHERE thesis.status = 'Approved'";
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchSpecificThesis($thesisID){

        $sql = "SELECT * FROM thesis WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);
        
        $qry->bindParam(":thesisID", $thesisID);

        $qry->execute();
        $data = $qry->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
    function fetchSpecificRequestThesis($thesisID){

        $sql = "SELECT * FROM thesis WHERE thesisID = :thesisID";
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

    function fetchThesisApproval($thesisID, $staffID){
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND staffID = :staffID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":staffID", $staffID);

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
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND status = 'Approved'" ;
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
                COUNT(DISTINCT CASE WHEN status = 'Approved' THEN staffID END) AS approvals,
                COUNT(DISTINCT CASE WHEN status = 'Rejected' THEN staffID END) AS rejections
            FROM thesis_approval
            WHERE thesisID = :thesisID";
    
        $qry = $this->db->connect()->prepare($sql);
        $qry->bindParam(":thesisID", $thesisID);
        $qry->execute();
        $result = $qry->fetch(PDO::FETCH_ASSOC);
    
        return $result['approvals'] > 0 && $result['rejections'] > 0; // Returns true if conflict exists
    }
    
    function approveThesis($staffID, $groupID, $thesisID, $status){

        $sql = "UPDATE thesis SET status = 'Approved' WHERE thesisID = :thesisID";
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
        $sql = "UPDATE thesis SET status='Rejected' WHERE thesisID = :thesisID";
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
        $sql = "SELECT approvalID, staffID, thesisTitle, thesislogs.status, actionDate  from thesislogs LEFT JOIN thesis
                ON thesislogs.thesisID = thesis.thesisID WHERE thesislogs.groupID = :groupID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":groupID", $groupID);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchThesisEditReq(){
        $sql = "SELECT thesisActionReqID, username, thesiseditreq.thesisID, thesisTitle, dateRequested, action FROM thesisactionreq 
                LEFT JOIN accounts ON groupID = accounts.ID
                LEFT JOIN thesiseditreq ON thesiseditreq.thesisID = thesisactionreq.thesisID" ;
        $qry = $this->db->connect()->prepare($sql);

        $qry->execute();
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    function fetchSpecificEditReq($thesisID){
        $sql = "SELECT * FROM thesiseditreq WHERE thesisID = :thesisID";
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

    function confirmEdit($thesisID, $thesisTitle, $datePublished, $reqID){
        $sql2 = "DELETE FROM thesisactionreq WHERE thesisActionReqID = :reqID";
        $qry2 = $this->db->connect()->prepare($sql2);

        $qry2->bindParam(":reqID", $reqID);

        $qry2->execute();

        $sql3 = "DELETE FROM thesiseditreq WHERE thesisID = :thesisID";
        $qry3 = $this->db->connect()->prepare($sql3);

        $qry3->bindParam(":thesisID", $thesisID);

        $qry3->execute();

        

            $sql = "UPDATE thesis SET thesisTitle = :thesisTitle, datePublished = :datePublished WHERE thesisID = :thesisID";
            $qry = $this->db->connect()->prepare($sql);

            $qry->bindParam(":thesisID", $thesisID);
            $qry->bindParam(":thesisTitle", $thesisTitle);
            $qry->bindParam(":datePublished", $datePublished);

            return $qry->execute();
    }

    function thesisActionReq($action, $thesisID, $groupID){

        $sql = "UPDATE thesis SET status = :action WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":action", $action);

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
        $sql = "INSERT INTO thesiseditreq (thesisID, thesisTitle, datePublished, groupID)
                VALUES (:thesisID, :thesisTitle, :datePublished, :groupID)";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);
        $qry->bindParam(":thesisTitle", $this->thesisTitle);
        $qry->bindParam(":datePublished", $this->datePublished);
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

    function denyThesis($thesisID){
        $sql = "UPDATE thesis SET status='Approved', notes ='Edit Request Denied'  WHERE thesisID = :thesisID";
        $qry = $this->db->connect()->prepare($sql);

        $qry->bindParam(":thesisID", $thesisID);

        return $qry->execute(); 
    }

    function searchAndSortTheses($searchTerm, $sortBy = 'datePublished', $sortOrder = 'ASC', $filters = []) {
        $sql = "SELECT thesis.datePublished, accounts.username, thesis.advisorName, thesis.thesisID, thesis.thesisTitle, thesis.status 
                FROM thesis
                LEFT JOIN accounts ON thesis.groupID = accounts.ID WHERE (thesisTitle LIKE :searchTerm OR advisorName LIKE :searchTerm)";
    
        // Add additional filters to the WHERE clause
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
        }
        
        // Add sorting to the query
        $sql .= " ORDER BY " . $sortBy . " " . $sortOrder;
    
            // Get the database connection
            $connection = $this->db->connect();
    
            // Prepare the SQL query
            $qry = $connection->prepare($sql);
    
            // Bind the search term to the query with wildcards for partial matching
            $searchTermWithWildcards = "%" . $searchTerm . "%";
            $qry->bindParam(":searchTerm", $searchTermWithWildcards, PDO::PARAM_STR);
    
            // Bind additional filters to the query
            if (!empty($filters['status'])) {
                $qry->bindParam(":status", $filters['status'], PDO::PARAM_STR);
            }
    
            // Execute the query
            $qry->execute();
    
            // Fetch the results as an associative array
            $results = $qry->fetchAll(PDO::FETCH_ASSOC);
    
            // Return the results, or an empty array if no matches
            return $results;

    }
    function searchAndSortApprovedTheses($searchTerm) {
        $sql = "SELECT thesis.datePublished, accounts.username, thesis.advisorName, thesis.thesisTitle, thesis.abstract
                FROM thesis
                LEFT JOIN accounts ON thesis.groupID = accounts.ID WHERE (thesisTitle LIKE :searchTerm OR advisorName LIKE :searchTerm) AND thesis.status = 'Approved'";
    
            // Get the database connection
            $connection = $this->db->connect();
    
            // Prepare the SQL query
            $qry = $connection->prepare($sql);
    
            // Bind the search term to the query with wildcards for partial matching
            $searchTermWithWildcards = "%" . $searchTerm . "%";
            $qry->bindParam(":searchTerm", $searchTermWithWildcards, PDO::PARAM_STR);
    
            // Execute the query
            $qry->execute();
    
            // Fetch the results as an associative array
            $results = $qry->fetchAll(PDO::FETCH_ASSOC);
    
            // Return the results, or an empty array if no matches
            return $results;
        }

    function searchAndSortPendingTheses($searchTerm, $sortBy = 'datePublished', $sortOrder = 'ASC', $filters = []) {
        // Modify the SQL query to only consider status = 'Pending'
        $sql = "SELECT thesis.datePublished, accounts.username, thesis.advisorName, thesis.thesisID, thesis.thesisTitle, thesis.status
                FROM thesis
                LEFT JOIN accounts ON thesis.groupID = accounts.ID
                WHERE (thesis.thesisTitle LIKE :searchTerm OR thesis.advisorName LIKE :searchTerm)
                AND thesis.status = 'Pending'";  // Status is always 'Pending'
    
        // Add sorting to the query
        $sql .= " ORDER BY " . $sortBy . " " . $sortOrder;
    
            // Get the database connection
            $connection = $this->db->connect();
    
            // Prepare the SQL query
            $qry = $connection->prepare($sql);
    
            // Bind the search term to the query with wildcards for partial matching
            $searchTermWithWildcards = "%" . $searchTerm . "%";
            $qry->bindParam(":searchTerm", $searchTermWithWildcards, PDO::PARAM_STR);
    
            // Execute the query
            $qry->execute();
    
            // Fetch the results as an associative array
            $results = $qry->fetchAll(PDO::FETCH_ASSOC);
    
            // Return the results, or an empty array if no matches
            return $results;

    }
    

    function validateRejection($thesisID){
        $sql = "SELECT COUNT(*) from thesis_approval WHERE thesisID = :thesisID AND status = 'Rejected'" ;
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