<?php
require_once("./classes/dao/ScheduleDao.php");
require_once("./classes/Connection.php");

class ScheduleDaoImpl implements ScheduleDao
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Connection::getPdoInstance();
    }

    function getAllSchedules()
    {
        $stmt = $this->_db->prepare("SELECT * FROM Schedule");
        $stmt->execute();
        return $stmt->fetchAll();    }

    public function insertSchedule($day, $lesson_start, $lesson_end, $subjectId, $roomId)
    {
        $stmt = $this->_db->prepare("INSERT INTO Schedule(day, lesson_start, lesson_end, id_subject, id_room)
         VALUES(:day, :lesson_start, :lesson_end, :id_subject, :id_room)");
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":lesson_start", $lesson_start);
        $stmt->bindParam(":lesson_end", $lesson_end);
        $stmt->bindParam(":id_subject", $subjectId);
        $stmt->bindParam(":id_room", $roomId);
        $stmt->execute();
    }

    public function deleteSchedule($scheduleId)
    {
        $stmt = $this->_db->prepare("DELETE FROM Schedule WHERE id = :id");
        $stmt->bindParam(":id", $scheduleId);
        $stmt->execute();
    }

    public function getScheduleById($scheduleId)
    {
        $stmt = $this->_db->prepare("SELECT * FROM Schedule WHERE id = :id");
        $stmt->bindParam(":id", $scheduleId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateSchedule($id, $day, $lesson_start, $lesson_end, $subjectId, $roomId)
    {
        $stmt = $this->_db->prepare("UPDATE Schedule SET
                day = :day,
                lesson_start = :lesson_start,
                lesson_end = :lesson_end,
                id_subject = :id_subject,
                id_room = :id_room  WHERE id = :id");

        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":lesson_start", $lesson_start);
        $stmt->bindParam(":lesson_end", $lesson_end);
        $stmt->bindParam(":id_subject", $subjectId);
        $stmt->bindParam(":id_room", $roomId);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}