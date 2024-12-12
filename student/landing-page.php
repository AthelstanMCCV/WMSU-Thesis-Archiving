<?php session_start();

require_once "../classes/thesis.class.php";
$landingPageObj = new Thesis;

if (isset($_POST['searchAndSort'])) {
    // Get the search term
    $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
    
    $thesisData = $landingPageObj->searchAndSortApprovedTheses($searchTerm);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Archives</title>
    <link rel="stylesheet" href="vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <style>
        <?php require_once '../vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css'; ?>
        <?php require_once '../css/style.css'; ?>
        <?php require_once '../css/landingPage.css'; ?>
    </style>
</head>
<?php require_once '../__includes/navbar.php'; ?>
<body>
    <!-- Hero Section -->
    <div class="container">
        <div class="hero">
            <img src="../imgs/building.png" alt="WMSU Building">
            <div class="overlay">
                <p>WESTERN MINDANAO STATE UNIVERSITY</p>
                <h1>THESIS ARCHIVES</h1>
                <div class="search-container">
                    <form id="searchForm" action="" method="POST">
                        <input type="text" class="form-control" name="searchTerm" id="searchTerm" placeholder="Enter search term" value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>">
                        <input type="submit" name="searchAndSort" value="Search & Sort">
                    </form>
                </div>
            </div>
        </div>

        <!-- Thesis Cards -->
        <?php 
    if(!isset($_POST['searchAndSort'])){
        $thesisData = $landingPageObj->fetchAllApprovedThesis();
        foreach ($thesisData as $thesis){?>
       
            <div class="thesis-card">
            <h2><?php echo $thesis['thesisTitle']; ?></h2>
            <p><strong>By <?php echo $thesis['username']; ?> - <?php echo $thesis['datePublished']; ?> - <?php echo $thesis['advisorName']; ?></strong></p>
            <p>. <?php echo $thesis['abstract']; ?> .</p>
            </div>
        <?php }}?>

        <?php 
    if(isset($_POST['searchAndSort'])){
        foreach ($thesisData as $thesis){?>
       
            <div class="thesis-card">
            <h2><?php echo $thesis['thesisTitle']; ?></h2>
            <p><strong>By <?php echo $thesis['username']; ?> - <?php echo $thesis['datePublished']; ?> - <?php echo $thesis['advisorName']; ?></strong></p>
            <p>. <?php echo $thesis['abstract']; ?> .</p>
            </div>
        <?php }}?>
    <div class="modal-container"></div>
    <script src="vendor/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <?php require_once '../__includes/footer.php'; ?>
</body>
</html>
