<?php
require_once './controller/ScheduleUserController.php';

$controller = new ScheduleUserController();

if (isset($_GET['deleteScheduleUser'])) {
    $controller->deleteScheduleUser($_GET['deleteScheduleUser']);
    header("Location: index.php?page=AdministrationPage&crud=ScheduleUser"); //To remove get parameter
} elseif (isset($_GET['editScheduleUser'])) {
    $editScheduleUser = $controller->getScheduleUser($_GET['editScheduleUser']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addScheduleUser") {
    $controller->createScheduleUser($_POST);
} elseif($_POST['action'] == "editScheduleUser") {
    $controller->updateScheduleUser($_POST);
}

?>

<div class="card" data-page="scheduleuser">
    <h2>Schedules-Users</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <label>
                        <input id="scheduleUserSearchBar" type="search" placeholder="Search" name="Search"
                               onkeyup="searchTable('scheduleUserSearchBar', 'scheduleUserTable', 1)">
                    </label>
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-scheduleUser">
            <span class="icon"></span>
            <span>Create new schedule-user</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createScheduleUserTable(); ?>
    </div>
</div>

<div class="modal-window <? if (isset($_GET['editScheduleUser'])) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit schedule-user: <strong><? echo $editScheduleUser['id'] ?></strong></p>
        <form id="editScheduleUserForm" class="edit-form flex-box" method="post"
              action="?page=AdministrationPage&crud=ScheduleUser">
            <input type="hidden" name="id" value="<? echo $editScheduleUser['id'] ?>">
            <div class="input-box">
                <label for="schedule">Schedule</label>
                <select name="schedule" id="schedule">
                    <?
                    foreach ($controller->getAllSchedules() as $schedule) {
                        echo "<option value=\"" . $schedule['id'] . "\"";
                        if ($editScheduleUser['id_schedule'] == $schedule['id']) echo 'selected';
                        echo ">" . $schedule['day'] . ' ' .
                            Helpers::convertDbTime($schedule['lesson_start']) . ' - ' . Helpers::convertDbTime($schedule['lesson_end'])
                            . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="user">User</label>
                <select name="user" id="user">
                    <?
                    foreach ($controller->getAllUsers() as $user) {
                        echo "<option value=\"" . $user['id'] . "\"";
                        if ($editScheduleUser['id_user'] == $user['id']) echo 'selected';
                        echo ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="grade">Grade</label>
                <select name="grade" id="grade">
                    <?
                    foreach ($controller->getAllGrades() as $grade) {
                        echo "<option value=\"" . $grade['id'] . "\"";
                        if ($editScheduleUser['id_grade'] == $grade['id']) echo 'selected';
                        echo ">" . $grade['grade'] . "</option>";
                    }
                    ?>
                    <option value="">None</option>
                </select>
            </div>
            <input type="hidden" value="editScheduleUser" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editScheduleUserForm" >Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-scheduleUser">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create schedule-user</p>
        <form id="createScheduleUserForm" class="edit-form flex-box" method="post"
              action="?page=AdministrationPage&crud=ScheduleUser">
            <div class="input-box">
                <label for="schedule">Schedule</label>
                <select name="schedule" id="schedule">
                    <?
                    foreach ($controller->getAllSchedules() as $schedule) {
                        echo "<option value=\"" . $schedule['id'] . "\"";
                        echo ">" . $schedule['id'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="user">User</label>
                <select name="user" id="user">
                    <?
                    foreach ($controller->getAllUsers() as $user) {
                        echo "<option value=\"" . $user['id'] . "\"";
                        echo ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="grade">Grade</label>
                <select name="grade" id="grade">
                    <?
                    foreach ($controller->getAllGrades() as $grade) {
                        echo "<option value=\"" . $grade['id'] . "\"";
                        echo ">" . $grade['grade'] . "</option>";
                    }
                    ?>
                    <option value="">None</option>
                </select>
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addScheduleUser">
            <div class="input-box">
                <button type="submit" form="createScheduleUserForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createScheduleUserForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>