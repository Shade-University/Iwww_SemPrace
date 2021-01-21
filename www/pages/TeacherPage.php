<?php
require_once './controller/TeacherPageController.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "teacher") {
    header("Location: ./index.php");
}

$controller = new TeacherPageController();

if (isset($_GET['deleteSubject'])) {
    $controller->deleteSubject($_GET['deleteSubject']);
    header("Location: index.php?page=TeacherPage"); //To remove get parameter
} elseif (isset($_GET['deleteSchedule'])) {
    $controller->deleteSchedule($_GET['deleteSchedule']);
    header("Location: index.php?page=TeacherPage&view=" . $_GET['view']);
} elseif (isset($_GET['removeGrade'])) {
    $controller->deleteGradeFromSchedule($_GET['removeGrade']);
    header("Location: index.php?page=TeacherPage&view=" . $_GET['view']
        . "&editSchedule=" . $_GET['editSchedule'] . "&student=" . $_GET['student']);
} elseif (isset($_GET['editSubject'])) {
    $editSubject = $controller->getSubject($_GET['editSubject']); //Parameter removed in javascript on modal close
} elseif (isset($_GET['editSchedule'])) {
    $editSchedule = $controller->getSchedule($_GET['editSchedule']);
}

if (isset($_GET['editSchedule']) && isset($_GET['expell'])) {
    $controller->expellStudent($_GET['editSchedule'], $_GET['expell']);
    header('Location: index.php?page=TeacherPage&view=' . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule']);
}

if ($_POST['action'] == "addSubject") {
    $controller->createSubject($_POST);
} elseif ($_POST['action'] == "editSubject") {
    $controller->updateSubject($_POST);
} elseif ($_POST['action'] == "addSchedule") {
    $controller->createSchedule($_POST);
} elseif ($_POST['action'] == "addGrade") {
    $controller->createGrade($_POST);
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
                </div> <!-- Empty divs for hamburger menu -->
            </div>
            <div class="card" data-page="subjects">
                <h2>My subjects</h2>
                <div class="control-row">
                    <div class="search-form-wrap">
                        <form class="search-form flex-box">
                            <div class="input-box">
                                <label>
                                    <input id="subjectSearchBar" type="search" placeholder="Search" name="Search"
                                           onkeyup="searchTable('subjectSearchBar', 'subjectsTable', 1)">
                                </label>
                            </div>
                            <div class="search-btn">
                                <button><img src="./img/search.svg" alt="Search icon"></button>
                            </div>
                        </form>
                    </div>
                    <button class="btn-add" data-modal-anchor="create-subject">
                        <span class="icon"></span>
                        <span>Create new subject</span>
                    </button>
                </div>
                <div class="table-wrap">
                    <?php $controller->createSubjectTable(); ?>
                </div>
                <div class="schedule">
                    <?php $controller->createScheduleTable($_GET['view']); ?>
                </div>
    </section>

    <div class="modal-window <?php if (isset($_GET['editSchedule']) && isset($_GET['view'])) echo 'show'; ?>"
         data-modal="view-students">
        <div class="layer-hide"></div>
        <div class="modal-box modal-students">
            <div class="inner-modal">
                <h3 class="ms-title">Student list</h3>
                <a href="?page=TeacherPage&view=<?php echo $_GET['view'] . '&deleteSchedule=' . $editSchedule['id'] ?>"
                   class="expell"
                   data-modal-anchor="remove-schedule">Remove schedule</a>

                <?php $controller->createStudentsListForSchedule($editSchedule['id']);
                if (isset($_GET['student'])) {
                    $controller->createStudentGrades($_GET['student'], $_GET['editSchedule']);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-window <? if (isset($_GET['editSubject'])) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit subject: <strong><? echo $editSubject['id'] ?></strong></p>
        <form id="editSubjectForm" class="edit-form flex-box" method="post" action="?page=TeacherPage">
            <input type="hidden" name="id" value="<? echo $editSubject['id'] ?>">
            <div class="input-box">
                <label for="name">name</label>
                <input type="text" name="name" placeholder="Name *" required
                       value="<? echo $editSubject['name'] ?>">
            </div>
            <div class="input-box">
                <label for="description">Description *</label>
                <input type="text" name="description" placeholder="Description *"
                       value="<? echo $editSubject['description'] ?>">
            </div>
            <input type="hidden" value="editSubject" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editSubjectForm">Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-subject">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create subject</p>
        <form id="createSubjectForm" class="edit-form flex-box" method="post">
            <div class="input-box">
                <label for="name">Name *</label>
                <input type="text" name="name" placeholder="Name *" required>
            </div>
            <div class="input-box">
                <label for="description">Description *</label>
                <input type="text" name="description" placeholder="Description *">
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addSubject">
            <div class="input-box">
                <button type="submit" form="createSubjectForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createUserForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window <? if (isset($_GET['addSchedule'])) echo 'show' ?> " data-modal="create-schedule">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create schedule</p>
        <form id="createScheduleForm" class="edit-form flex-box" method="post" action="?page=TeacherPage">
            <div class="input-box">
                <label for="day">Day</label>
                <select name="day">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            <div class="input-box">
                <label for="lesson_start">Lesson start *</label>
                <input type="text" name="lesson_start" placeholder="12:00 *" pattern="^[0-9]{2}:[0-9]{2}$" required>
            </div>
            <div class="input-box">
                <label for="lesson_end">Lesson end *</label>
                <input type="text" name="lesson_end" placeholder="14:00 *" pattern="^[0-9]{2}:[0-9]{2}$" required>
            </div>
            <div class="input-box">
                <label for="room">Room</label>
                <label>
                    <select name="room">
                        <? $controller->createRoomOptions(); ?>
                    </select>
                </label>
            </div>
            <div class="input-box ib-placeholder"></div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addSchedule">
            <input type="hidden" name="subject" value="<? echo $_GET['addSchedule'] ?>">
            <div class="input-box">
                <button type="submit" form="createScheduleForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createScheduleForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-grade">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create grade</p>
        <form id="createGradeForm" class="edit-form flex-box" method="post"
              action="?page=TeacherPage<?php echo '&view=' . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule'] . '&student=' . $_GET['student']
              //To build url with all get parameters which is needed to view ?>">
            <div class="input-box">
                <label for="grade">Grade</label>
                <input type="text" name="grade" id="grade" placeholder="A/B/C/D/E/F *" required pattern="[ABCDEF]">
            </div>
            <div class="input-box">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" placeholder="Type *" required>
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addGrade">
            <input type="hidden" name="student" value="<?php echo $_GET['student'] ?>">
            <input type="hidden" name="schedule" value="<?php echo $_GET['editSchedule'] ?>">
            <div class="input-box">
                <button type="submit" form="createGradeForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createGradeForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript" src="./js/TeacherPage.js"></script>
