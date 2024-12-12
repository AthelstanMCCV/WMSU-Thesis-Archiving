<?php
session_start();
require_once "../classes/thesis.class.php";
$reqThesisObj = new Thesis;
?>
        <div id="pending-header">
            <img id="pending-title-logo" src="../imgs/person.svg" alt="">
            <h4 id="pending-title">Request Thesis</h4>
        </div>
        <form action="" id="pending-form">
            <div id="pending-search-bar">
                <input type="search" name="" id="staff-thesis-search" placeholder="Search">
                <img id="search-img" src="../imgs/search-icon.png" alt="">
            </div>
        </form>
   
                <table id="staff-thesis-list" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th id="pending-headerRow"> Date Added </th>
                            <th id="pending-headerRow"> Thesis ID </th>
                            <th id="pending-headerRow"> Thesis Title </th>
                            <th id="pending-headerRow"> Status </th>
                            <th id="pending-headerRow"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    $thesisData = $reqThesisObj->fetchApprovedThesis($_SESSION['account']['ID']);
                    foreach($thesisData as $thesis){ 
                ?>
                    <tr id="pending-data-row">
                        <td><?php echo $thesis["dateAdded"]?></td>
                        <td><?php echo $thesis["thesisID"]?></td>
                        <td><?php echo $thesis["thesisTitle"]?></td>
                        <td><?php echo $thesis["status"]?></td>
                        <td id="actions"> <a id="approveStyle" class="reqData" data-id="<?php echo $thesis['thesisID']; ?>" type="button">Request Data</a>
                    </tr>
                    
            <?php };
                ?>
                </tbody>
            </table>          
      