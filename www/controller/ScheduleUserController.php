<?php
require_once './classes/Helpers.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/dao/GradeDaoImpl.php';
require_once './classes/dao/ScheduleUserDaoImpl.php';

class ScheduleUserController
{
    protected $_scheduleDao;
    protected $_userDao;
    protected $_gradeDao;
    protected $_scheduleUserDao;

    public function __construct()
    {
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_userDao = new UserDaoImpl();
        $this->_gradeDao = new GradeDaoImpl();
        $this->_scheduleUserDao = new ScheduleUserDaoImpl();
    }

    public function createScheduleUserTable()
    {
        $headers = array('ID', 'Schedule id', 'User', 'Grade', 'Actions');
        $scheduleUsers = $this->_scheduleUserDao->getAllScheduleUsers();

        echo '<table id="scheduleUserTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($scheduleUsers as $schedule) {
            echo '<tr>';
            echo '<td>' . $schedule['id'] . '</td>';
            echo '<td>' . $schedule['id_schedule'] . '</td>';
            $user = $this->_userDao->geUserById($schedule['id_user']);
            echo '<td>' . $user['firstname'] . " " . $user['lastname'] . '</td>';
            echo '<td>' . $this->_gradeDao->getGradeById($schedule['id_grade'])['grade'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&crud=ScheduleUser&deleteScheduleUser=' . $schedule['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-schedule"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&crud=ScheduleUser&editScheduleUser=' . $schedule['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="schedule-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createScheduleUser($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_scheduleUserDao->insertScheduleUser($data['schedule'], $data['user'], $data['grade'] != "" ? $data['grade'] : null);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteScheduleUser($scheduleId)
    {
        $this->_scheduleUserDao->deleteScheduleUserById($scheduleId);
    }

    public function getScheduleUser($id)
    {
        return $this->_scheduleUserDao->getScheduleUserById($id);
    }

    public function updateScheduleUser($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_scheduleUserDao->updateScheduleUser($data['id'], $data['schedule'], $data['user'], $data['grade'] != "" ? $data['grade'] : null);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function getAllUsers()
    {
        return $this->_userDao->getAllUsers();
    }

    public function getAllSchedules()
    {
        return $this->_scheduleDao->getAllSchedules();
    }

    public function getAllGrades()
    {
        return $this->_gradeDao->getAllGrades();
    }

    private function validate($data, &$msg)
    {
        if (empty($data['schedule'])
            ||
            empty($data['user'])) {
            $msg = "Schedule and user must be filled in";
            return false;
        }

        if (!is_numeric($data['schedule']) || !is_numeric($data['user'])
            || (!empty($data['grade']) && !is_numeric($data['grade']))) {
            $msg = "Data not valid";
            return false;
        }

        if ($this->_scheduleDao->getScheduleById($data['schedule']) == null
        ||
        $this->_userDao->geUserById($data['user']) == null)
        {
            $msg = "Schedule or user do not exists";
            return false;
        }

        return true;
    }

}