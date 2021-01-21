<?php
require_once './controller/StudentPageController.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "student") {
    header("Location: ./index.php");
}
$controller = new StudentPageController();

if (isset($_GET['registerSchedule'])) {
    $controller->registerUserToSchedule($_GET['registerSchedule']);
    header("Location: ./index.php?page=StudentPage"); //To remove get parameter
}
?>

<div class="overview-page admin-page">
    <section class="op-body flex-box">
        <div class="col nav-col">
            <a class="logout-user" href="?action=logout">
                <img src="./img/logout.svg" alt="Log out">
                <span>Log Out</span>
            </a>
            <div class="logged-user">
                <p>User:</p>
                <h3 class="line-overflow"><?php echo $_SESSION['fullname'] ?></h3>
            </div>

            <ul class="nav-menu">
                <li><a href="#" class="nav-item active"><span>My Subjects</span></a></li>
            </ul>
        </div>
        <div class="col content-col">
            <div class="nav-icon-wrap">
                <div class="nav-icon">
                    <div></div>
                    <div></div>
                </div> <!-- Empty divs are used as hamburger menu -->
            </div>
            <div class="card" data-page="users">
                <?php $controller->createScheduleTable(); ?>
            </div>

            <div class="other-subjects">
                <?php $controller->createUnassignedSubjectsTable(); ?>
            </div>
        </div>
    </section>


    <div class="modal-window <?php if (isset($_GET['editSchedule'])) echo 'show'; ?>" data-modal="my-grades">
        <div class="layer-hide"></div>
        <div class="modal-box modal-students">
            <div class="inner-modal">
                <?php $controller->createStudentGradesList($_GET['editSchedule']); ?>
                <!-- Variable must be starting with edit keyword, because of bad algorithm in modal close -->
            </div>
        </div>
    </div>