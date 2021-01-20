<?php
require_once './controller/StudentPageController.php';

if (!$_SESSION['email']) {
    header("Location: ./index.php");
}
$controller = new StudentPageController();

if ($_GET['registerSchedule']) {
    $controller->registerUserToSchedule($_GET['registerSchedule']);
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
            <h3 class="line-overflow"
                title="<?php echo $_SESSION['fullname'] ?>"><?php echo $_SESSION['fullname'] ?></h3>
        </div>

        <ul class="nav-menu">
            <li><a href="#" class="nav-item active"><span>My Subjects</span></a></li>
        </ul>
    </div>
    <div class="col content-col">
        <div class="nav-icon-wrap">
            <div class="nav-icon"><div></div><div></div></div>
        </div>
        <div class="card" data-page="users">
            <?php $controller->createScheduleTable(); ?>
            </div>

            <div class="other-subjects">
                <?php $controller->createSubjectTable(); ?>
            </div>
        </div>
    </div>
</section>


<div class="modal-window <?php if($_GET['editSchedule']) echo 'show' ; ?>" data-modal="my-grades">
    <div class="layer-hide"></div>
    <div class="modal-box modal-students">
        <div class="inner-modal">
          <?php $controller->createStudentGradesList($_GET['editSchedule']); ?>
        </div>
    </div>
</div>
</div>
