<?php
session_start();
require_once "../classes/thesis.class.php";

$reqObj = new Thesis;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = $_GET['id'];
    $thesisData = $reqObj->fetchSpecificRequestThesis($id);

}

?>
    <h3>This is the Data for your Thesis:</h3>

    <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th id="pending-headerRow"> Date Published </th>
                            <th id="pending-headerRow"> Advisor </th>
                            <th id="pending-headerRow"> Thesis ID </th>
                            <th id="pending-headerRow"> Thesis Title </th>
                            <th id="pending-headerRow"> Status </th>
                            <th id="pending-headerRow"> Abstract </th>
                            <th id="pending-headerRow"> Date Published </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php

            foreach($thesisData as $thesis){ ?>
                    <tr>
                        <td><?php echo $thesis["dateAdded"]?></td>
                        <td><?php echo $thesis["advisorName"]?></td>
                        <td><?php echo $thesis["thesisID"]?></td>
                        <td><?php echo $thesis["thesisTitle"]?></td>
                        <td><?php echo $thesis["status"]?></td>
                        <td><?php echo $thesis["abstract"]?></td>
                        <td><?php echo $thesis["datePublished"]?></td>
                    </tr>
                    
            <?php };
                ?>
                </tbody>
            </table>    