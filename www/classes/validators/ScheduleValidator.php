<?php
require_once './classes/dao/SubjectDao.php';
require_once './classes/dao/RoomDao.php';
require_once './classes/validators/Validator.php';

class ScheduleValidator implements Validator
{
    protected $_subjectDao;
    protected $_roomDao;

    public function __construct(SubjectDao $subjectDao, RoomDao $roomDao)
    {
        $this->_subjectDao = $subjectDao;
        $this->_roomDao = $roomDao;
    }

    public function validate($data, &$msg): bool
    {
        $validDays = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");

        if (empty($data['day'])
            || empty($data['lesson_start'])
            || empty($data['lesson_end'])
            || empty($data['subject'])
            || empty($data['room'])) {
            $msg = "Data cannot be empty";
            return false;
        }

        if (!in_array($data['day'], $validDays)) {
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
        $hourDiff = ($lessonEnd - $lessonStart) / (60 * 60);
        if ($hourDiff <= 0 || $hourDiff > 4) {
            $msg = "Schedule lesson should be last between 1-4 hours";
            return false;
        }

        return true;
    }

}