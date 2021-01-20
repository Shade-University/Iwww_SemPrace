<?php
require_once './classes/Helpers.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/RoomDaoImpl.php';
require_once './classes/dao/SubjectDaoImpl.php';

class SchedulesController
{
    protected $_scheduleDao;
    protected $_roomDao;
    protected $_subjectDao;

    public function __construct()
    {
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_roomDao = new RoomDaoImpl();
        $this->_subjectDao = new SubjectDaoImpl();
    }

    public function createScheduleTable()
    {
        $headers = array('ID', 'Day', 'Lesson start', 'Lesson end', "Subject", "Room", 'Actions');
        $schedules = $this->_scheduleDao->getAllSchedules();

        echo '<table id="schedulesTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($schedules as $schedule) {
            echo '<tr>';
            echo '<td>' . $schedule['id'] . '</td>';
            echo '<td>' . $schedule['day'] . '</td>';
            echo '<td>' . $schedule['lesson_start'] . '</td>';
            echo '<td>' . $schedule['lesson_end'] . '</td>';
            echo '<td>' . $this->_subjectDao->getSubjectById($schedule['id_subject'])['name'] . '</td>';
            echo '<td>' . $this->_roomDao->getRoomById($schedule['id_room'])['name'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&crud=Schedules&deleteSchedule=' . $schedule['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-schedule"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&crud=Schedules&editSchedule=' . $schedule['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="schedule-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createSchedule($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_scheduleDao->insertSchedule($data['day'], $data['lesson_start'], $data['lesson_end'], $data['subject'], $data['room']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteSchedule($scheduleId)
    {
        $this->_scheduleDao->deleteScheduleById($scheduleId);
    }

    public function getSchedule($scheduleId)
    {
        return $this->_scheduleDao->getScheduleById($scheduleId);
    }

    public function updateSchedule($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_scheduleDao->updateSchedule($data['id'], $data['day'], $data['lesson_start'], $data['lesson_end'], $data['subject'], $data['room']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function getAllSubjects()
    {
        return $this->_subjectDao->getAllSubjects();
    }

    public function getAllRooms()
    {
        return $this->_roomDao->getAllRooms();
    }

    private function validate($data, &$msg)
    {
        if (empty($data['day'])
            || empty($data['lesson_start'])
            || empty($data['lesson_end'])
            || empty($data['subject'])
            || empty($data['room'])) {
            $msg = "Data cannot be empty";
            return false;
        }

        if ($data['day'] != "Monday"
            && $data['day'] != "Tuesday"
            && $data['day'] != "Wednesday"
            && $data['day'] != "Thursday"
            && $data['day'] != "Friday") {
            $msg = "Invalid day";
            return false;
        }

        if ($this->_subjectDao->getSubjectById($data['subject']) == null
            || $this->_roomDao->getRoomById($data['room']) == null) {
            $msg = "Invalid data";
            return false;
        }

        if (!preg_match("/^[0-9]{2}:[0-9]{2}$/", $data['lesson_start'])
            || !preg_match("/^[0-9]{2}:[0-9]{2}$/", $data['lesson_end'])) {
            $msg = "Dates are not in correct format";
            return false;
        }

        $lessonStart = strtotime($data['lesson_start']);
        $lessonEnd = strtotime($data['lesson_end']);
        $hourDiff = ($lessonEnd - $lessonStart) / (60*60);
        if($hourDiff <= 0 || $hourDiff > 4) {
            $msg = "Schedule lesson should be last between 1-4 hours";
            return false;
        }

        return true;
    }

}

;