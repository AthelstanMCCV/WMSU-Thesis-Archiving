<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";

$thesisObj = new Thesis;
?>
<div id="pending-header">
    <img id="pending-title-logo" src="../imgs/thesis-icon.png" alt="">
    <h4 id="pending-title">Thesis List</h4>
    <div id="addContainer">
        <a id="addThesisBtn" type="button">Add Thesis <span id="addIcon">+</span></a>
    </div>
</div>
<form action="" id="pending-form">
    <div id="pending-search-bar">
        <input type="search" name="" id="staff-thesis-search" placeholder="Search">
        <img id="search-img" src="../imgs/search-icon.png" alt="">
    </div>
</form>
<div class="table table-responsive">
    <table id="staff-thesis-list" class="table table-hover align-middle">
        <thead>
            <tr>
                <th id="pending-headerRow"> Date Added </th>
                <th id="pending-headerRow"> Thesis ID </th>
                <th id="pending-headerRow"> Author/s </th>
                <th id="pending-headerRow"> Advisor Name</th>
                <th id="pending-headerRow"> Thesis Title </th>
                <th id="pending-headerRow"> Short Description </th>
                <th id="pending-headerRow"> Status </th>
                <th id="pending-headerRow"> Notes </th>
                <th id="pending-headerRow"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $_SESSION['thesisData'] = $thesisObj->fetchThesis($_SESSION['account']['ID']);
                $authors = $thesisObj->fetchAuthors($_SESSION['account']['ID']);
                foreach($_SESSION['thesisData'] as $index => $thesis){ 
            ?>
            <tr id="pending-data-row">
                    
                <td><?php echo $thesis["datePublished"]?></td>
                <td><?php echo $thesis["thesisID"]?></td>
                <td><?php foreach ($authors as $author){
                    echo $author['lastName'] . ' ' . $author['firstName'] . ' ' . $author['middleName'] . '<br> ' . ' ';
                    }?></td>
                <td><?php echo $thesis["advisorName"]?></td>
                <td><?php echo $thesis["thesisTitle"]?></td>
                <td><?php echo $thesis["abstract"]?></td>
                <td><?php echo $thesis["statusName"]?></td>
                <td><?php echo $thesis["notes"]?></td>
                <?php if ($thesis['status'] != 1 && $thesis['status'] != 4  && $thesis['status'] != 3 && $thesis['status'] != 5){?>
                    <td id="actions">
                        <a id="approveStyle" class="editThesis" data-id="<?php echo $thesis['thesisID'];?>" type="button">Edit</a> 
                        <a id="rejectStyle" href="../student-functions/deleteThesis.php?id=<?php echo $thesis['thesisID']; ?>&index=<?php echo $index;?>">Delete</a>
                    </td>
                <?php 
                    }else{
                        echo "<td> No actions available </td>";
                    } 
                ?>
            </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>
        