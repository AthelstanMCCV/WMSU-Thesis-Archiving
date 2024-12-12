
<div id="sidebar-content">
    <h2 id="sidebar-title">Dashboard</h2>
    <div id="sidebar-line"></div>
    <div id="sidebar-navlink-container">

        <!-- ADMIN -->

        <?php if ($_SESSION['account']['role'] == 1){?>
        <a href="pending-students" class="sidebar-navlink" id="pending-request-admin">
            <img src="../imgs/pending-icon.png" alt="">
            <h6>Pending Requests</h6>
        </a>
        
        <a href="groupList" class="sidebar-navlink" id="group-list-admin">
            <img src="../imgs/student-icon.png" alt="">
            <h6>Group List</h6>
        </a>
        <a href="thesis-archives" class="sidebar-navlink" id="thesis-archives-admin">
            <img src="../imgs/thesis-icon.png" alt="">
            <h6>Thesis Archives</h6>
        </a>

        <?php }; ?>

        <!-- ADMIN -->

        <!-- STUDENT -->
        <?php if ($_SESSION['account']['role'] == 3) { ?>
        <a href="thesis-list" class="sidebar-navlink" id="thesis-list-student">
            <img src="../imgs/thesis-icon.png" alt="">
            <h6>Thesis List</h6>
        </a>
        <a href="member-list" class="sidebar-navlink" id="member-list-student">
            <img src="../imgs/student-icon.png" alt="">
            <h6>Member List</h6>
        </a>
        <a href="track-thesis" class="sidebar-navlink" id="track-thesis-student">
            <img src="../imgs/pending-icon.png" alt="">
            <h6>Track Thesis</h6>
        </a>
        <a href="request-thesis" class="sidebar-navlink" id="request-thesis-student">
            <img src="../imgs/person.svg" alt="">
            <h6>Request Thesis</h6>
        </a>
        <?php }; ?>

        <!-- STUDENT -->

        <!-- STAFF -->
        <?php if ($_SESSION['account']['role'] == 2) { ?>
        <a href="staff-thesis-list" class="sidebar-navlink" id="thesis-list-staff">
            <img src="../imgs/thesis-icon.png" alt="">
            <h6>Thesis List</h6>
        </a>
        <a href="staff-thesis-logs" class="sidebar-navlink" id="thesis-logs-staff">
            <img src="../imgs/search.png" alt="">
            <h6>Thesis Logs</h6>
        </a>
        <a href="staff-list" class="sidebar-navlink" id="staff-list">
            <img src="../imgs/student-icon.png" alt="">
            <h6>Staff List</h6>
        </a>
        <a href="staff-action-req" class="sidebar-navlink" id="staff-action">
            <img src="../imgs/pending-icon.png" alt="">
            <h6>Thesis Action Requests</h6>
        </a>
        <?php }; ?>

        <!-- STAFF -->

    </div>
</div>