<nav>
    <section id="nav-container">
        <div id="nav-items">
            <img id="nav-logo" src="../imgs/WMSU_Logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
            <?php if ($_SESSION['account']['role'] == 3){ ?>
                <div id="nav-links">
                    <a href="../student/landing-page.php">Home</a>
                    <a href="../student/thesis-list">Dashboard</a>
                </div>
            <?php } ?>
            <div id="account-container">
                <span id="intro-text">Hello, <?php echo $_SESSION["account"]['username'] ?></span>
                <img id="intro-img" src="../imgs/profile-icon.png" alt="" type="button">
            </div>
        </div>
    </section>
</nav>