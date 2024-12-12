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
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
        }
        .hero {
            position: relative;
            text-align: center;
            color: white;
            border-radius: 10px;
            overflow: hidden;
            padding: 0p;
        }
        .hero img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(107, 43, 30, 0.418);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .hero h1 {
            font-size: 36px;
            font-weight: 700;
        }
        .hero p {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
        }
        .search-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 700px;
        }
        .search-container input,
        .search-container select {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-container select {
            flex-basis: 5%;
        }
        .thesis-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            border: 1px rgba(0, 0, 0, 0.182) solid;
            padding: 20px;
            margin: 30px 20px;
        }
        .thesis-card h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .thesis-card p {
            margin: 0;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php require_once '../__includes/navbar.php'; ?>
    <!-- Hero Section -->
    <div class="container">
        <div class="hero">
            <img src="../imgs/building.png" alt="WMSU Building">
            <div class="overlay">
                <p>WESTERN MINDANAO STATE UNIVERSITY</p>
                <h1>THESIS ARCHIVES</h1>
                <div class="search-container">
                    <input type="text" class="form-control" placeholder="Search">
                    <select class="form-select">
                        <option value="">Course</option>
                    </select>
                </div>
            </div>
        </div>

        <form method="POST" action="">
        <!-- Search Term -->
        <label for="searchTerm">Search Term (Title/Advisor):</label>
        <input type="text" name="searchTerm" id="searchTerm" placeholder="Enter search term" value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>"><br><br>

        <!-- Submit Button with name="searchAndSort" -->
        <input type="submit" name="searchAndSort" value="Search & Sort"><br><br>
    </form>

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
