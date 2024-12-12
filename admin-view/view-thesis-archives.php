<?php
session_start();
require_once "../classes/thesis.class.php";
$thesisObj = new Thesis;
?>
    <div id="pending-header">
        <img id="pending-title-logo" src="../imgs/thesis-icon.png" alt="">
        <h4 id="pending-title">Thesis Archives</h4>
    </div>
    <form action="" id="pending-form">
        <div id="pending-search-bar">
            <input type="search" name="" id="archive-search" placeholder="Search">
            <img id="search-img" src="../imgs/search-icon.png" alt="">
        </div>
    </form>

    <div class="table-responsive">
        <table id="archives-table" class="table table-hover align-middle">
            <thead>
            <tr>
                <th id="pending-headerRow"> Date Added </th>
                <th id="pending-headerRow"> Thesis ID </th>
                <th id="pending-headerRow"> Thesis Title </th>
                <th id="pending-headerRow"> Status </th>
            </tr>
            </thead>
            <tbody>
        <?php
            $thesisData = $thesisObj->fetchNotPendingThesis();
            foreach($thesisData as $thesis){ ?>
            <tr id="pending-data-row">
                <td><?php echo $thesis["dateAdded"]?></td>
                <td><?php echo $thesis["thesisID"]?></td>
                <td><?php echo $thesis["thesisTitle"]?></td>
                <td><?php echo $thesis["status"]?></td>
            </tr>
        <?php }; ?>
        </tbody>    
    </table> 
</div>
