<?php
require_once './classes/validators/Validator.php';
require_once './classes/dao/UserDao.php';
require_once './classes/dao/ScheduleDao.php';
require_once './classes/dao/GradeDao.php';

class ScheduleUserValidator implements Validator
{

    protected $_userDao;
    protected $_scheduleDao;
    protected $_gradeDao;

    public function __construct(UserDao $userDao, ScheduleDao $scheduleDao, GradeDao $gradeDao)
    {
        $this->_userDao = $userDao;
        $this->_scheduleDao = $scheduleDao;
        $this->_gradeDao = $gradeDao;
    }

    public function validate($data, &$msg): bool
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
            $this->_userDao->getUserById($data['user']) == null
            ||
            (!empty($data['grade']) && $this->_gradeDao->getGradeById($data['grade']) == null)) {
            $msg = "Schedule, user or grade do not exists";
            return false;
        }

        return true;
    }
}