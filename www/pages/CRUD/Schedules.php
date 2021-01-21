<?php
require_once './controller/SchedulesController.php';
require_once './classes/Helpers.php';

$controller = new SchedulesController();

if (isset($_GET['deleteSchedule'])) {
    $controller->deleteSchedule($_GET['deleteSchedule']);
    header("Location: index.php?page=AdministrationPage&crud=Schedules"); //To remove get parameter
} elseif (isset($_GET['editSchedule'])) {
    $editSchedule = $controller->getSchedule($_GET['editSchedule']); //Parameter removed in javascript on modal close
}

if($_POST['action'] == "addSchedule") {
    $controller->createSchedule($_POST);
} elseif($_POST['action'] == "editSchedule") {
    $controller->updateSchedule($_POST);
}

?>

<div class="card" data-page="schedules">
    <h2>Schedules</h2>
    <div class="control-row">
        <div class="search-form-wrap">
            <form class="search-form flex-box">
                <div class="input-box">
                    <label>
                        <input id="schedulesSearchBar" type="search" placeholder="Search" name="Search"
                               onkeyup="searchTable('schedulesSearchBar', 'schedulesTable', 4)">
                    </label>
                </div>
                <div class="search-btn">
                    <button><img src="./img/search.svg" alt="Search icon"></button>
                </div>
            </form>
        </div>
        <button class="btn-add" data-modal-anchor="create-schedule">
            <span class="icon"></span>
            <span>Create new schedule</span>
        </button>
    </div>
    <div class="table-wrap">
        <? $controller->createScheduleTable(); ?>
    </div>
</div>

<div class="modal-window <? if (isset($_GET['editSchedule'])) echo 'show'; ?>">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Edit schedule: <strong><? echo $editSchedule['id'] ?></strong></p>
        <form id="editScheduleForm" class="edit-form flex-box" method="post"
              action="?page=AdministrationPage&crud=Schedules">
            <input type="hidden" name="id" value="<? echo $editSchedule['id'] ?>">
            <div class="input-box">
                <label for="day">Day</label>
                <select name="day" id="day">
                    <option value="Monday" <? if ($editSchedule['day'] == "Monday") echo 'selected'; ?>>Monday</option>
                    <option value="Tuesday" <? if ($editSchedule['day'] == "Tuesday") echo 'selected'; ?>>Tuesday
                    </option>
                    <option value="Wednesday" <? if ($editSchedule['day'] == "Wednesday") echo 'selected'; ?>>
                        Wednesday
                    </option>
                    <option value="Thursday" <? if ($editSchedule['day'] == "Thursday") echo 'selected'; ?>>Thursday
                    </option>
                    <option value="Friday" <? if ($editSchedule['day'] == "Friday") echo 'selected'; ?>>Friday</option>
                </select>
            </div>
            <div class="input-box">
                <label for="lesson_start">Lesson start *</label>
                <input type="text" name="lesson_start" id="lesson_start" placeholder="12:00 *"
                       pattern="^[0-9]{2}:[0-9]{2}$" required
                       value="<? echo Helpers::convertDbTime($editSchedule['lesson_start']); ?>">
            </div>
            <div class="input-box">
                <label for="lesson_end">Lesson end *</label>
                <input type="text" name="lesson_end" id="lesson_end" placeholder="14:00 *" pattern="^[0-9]{2}:[0-9]{2}$"
                       required
                       value="<? echo Helpers::convertDbTime($editSchedule['lesson_end']); ?>">
            </div>
            <div class="input-box">
                <label for="subject">Subject</label>
                <select name="subject" id="subject">
                    <?
                    foreach ($controller->getAllSubjects() as $subject) {
                        echo "<option value=\"" . $subject['id'] . "\"";
                        if ($editSchedule['id_subject'] == $subject['id']) echo 'selected';
                        echo ">" . $subject['name'] . "</option>";
                    }
                    //editSchedule and this output should be probably handled in controller (this is on every page used editVariable)
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="room">Room</label>
                <select name="room" id="room">
                    <?
                    foreach ($controller->getAllRooms() as $room) {
                        echo "<option value=\"" . $room['id'] . "\"";
                        if ($editSchedule['id_room'] == $room['id']) echo 'selected';
                        echo ">" . $room['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" value="editSchedule" name="action">
            <div class="input-box ib-placeholder"></div>
            <div class="input-box">
                <button type="submit" form="editScheduleForm" >Save</button>
            </div>
            <div class="input-box">
                <button type="reset" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-window" data-modal="create-schedule">
    <div class="layer-hide"></div>
    <div class="modal-box edit-add">
        <p>Create schedule</p>
        <form id="createScheduleForm" class="edit-form flex-box" method="post" action="?page=AdministrationPage&crud=Schedules">
            <div class="input-box">
                <label for="day">Day</label>
                <select name="day" id="day">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            <div class="input-box">
                <label for="lesson_start">Lesson start *</label>
                <input type="text" id="lesson_start" name="lesson_start" placeholder="12:00 *" pattern="^[0-9]{2}:[0-9]{2}$" required>
            </div>
            <div class="input-box">
                <label for="lesson_end">Lesson end *</label>
                <input type="text" id="lesson_end" name="lesson_end" placeholder="14:00 *" pattern="^[0-9]{2}:[0-9]{2}$" required>
            </div>
            <div class="input-box">
                <label for="subject">Subject</label>
                <select name="subject" id="subject">
                    <?
                    foreach ($controller->getAllSubjects() as $subject) {
                        echo "<option value=\"" . $subject['id'] . "\"";
                        echo ">" . $subject['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="room">Room</label>
                <select name="room" id="room">
                    <?
                    foreach ($controller->getAllRooms() as $room) {
                        echo "<option value=\"" . $room['id'] . "\"";
                        echo ">" . $room['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box ib-placeholder"></div>
            <input type="hidden" name="action" value="addSchedule">
            <div class="input-box">
                <button type="submit" form="createScheduleForm">Create</button>
            </div>
            <div class="input-box">
                <button type="reset" form="createScheduleForm" class="hide-modal">Storno</button>
            </div>
        </form>
    </div>
</div>