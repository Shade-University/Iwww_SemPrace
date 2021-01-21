<?php
require_once './classes/Helpers.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/RoomDaoImpl.php';
require_once './classes/dao/SubjectDaoImpl.php';

require_once './classes/validators/ScheduleValidator.php';

class SchedulesController
{
    protected $_scheduleDao;
    protected $_roomDao;
    protected $_subjectDao;
    protected $_scheduleValidator;

    public function __construct()
    {
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_roomDao = new RoomDaoImpl();
        $this->_subjectDao = new SubjectDaoImpl();
        $this->_scheduleValidator = new ScheduleValidator($this->_subjectDao, $this->_roomDao);
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

        echo '</table>';
    }

    public function createSchedule($data)
    {
        $errorMsg = "";
        if ($this->_scheduleValidator->validate($data, $errorMsg)) {
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
        if ($this->_scheduleValidator->validate($data, $errorMsg)) {
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
}
