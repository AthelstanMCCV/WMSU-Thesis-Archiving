<?php
session_start();
require_once "../classes/thesis.class.php";

$reqObj = new Thesis;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $thesisData = $reqObj->fetchSpecificRequestThesis($id); // Fetch thesis data for the provided ID
}

?>

<div class="modal fade" id="reqDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Thesis Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php foreach($thesisData as $thesis){ ?>
                <p><strong>Thesis Title: </strong><?php echo $thesis["thesisTitle"]?></p>
                <p><strong>Thesis ID: </strong><?php echo $thesis["thesisID"]?></p>
                <p><strong>Advisor: </strong><?php echo $thesis["advisorName"]?></p>
                <p><strong>Short Description: </strong><?php echo $thesis["abstract"]?></p>
                <p><strong>Date Published: </strong><?php echo $thesis["datePublished"]?></p>
                <p><strong>Status: </strong><?php echo $thesis["status"]?></p>
            <?php }; ?>
        
        <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

    