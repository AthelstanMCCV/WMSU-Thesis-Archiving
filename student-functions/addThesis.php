<?php
session_start();
require_once "../classes/thesis.class.php";
require_once "../tools/functions.php";

$thesisObj = new Thesis;

if (isset($_POST['addThesis']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $thesisObj->cleanThesis();

    $thesisTitle = $thesisObj->thesisTitle;
    $datePublished = $thesisObj->datePublished;
    $advisorName = $thesisObj->advisorName;
    $abstract = $thesisObj->shortDesc;
    
    $groupID = $_SESSION['account']['ID'];


    $titleErr = errText(validateInput($thesisTitle, "text"));
    $advisorNameErr = errText(validateInput($advisorName, "text"));
    $abstractErr = errText(validateInput($abstract, "text"));

    if(empty($titleErr) && empty($advisorNameErr) && empty($abstractErr)){
        $thesisObj->addThesis($groupID);
        $currThesis = $thesisObj->fetchThesisID($thesisTitle);
        $thesisObj->recordThesis(NULL, $_SESSION['account']['ID'], $currThesis);

        $_SESSION['form_success'] = true;

        echo '<script>window.location.href="../student/thesis-list";</script>';
    }
}

?>

<a href="../student/thesis-list">Back</a>
<form action="" method="POST">
                <input type="text" name="thesisTitle" id="thesisTitle" placeholder="Thesis Title">
                <input type="text" name="advisorName" id="advisorName" placeholder="Advisor Name">
                <input type="text" name="shortDesc" id="shortDesc" placeholder="Short Description">
                <input type="date" name="datePublished" id="datePublished">
                <input type="submit" name="addThesis" value="Add Thesis">
            </form>