<?php


interface ScheduleUserDao
{
    function getAllScheduleUsers();
    public function insertScheduleUser($scheduleId, $userId, $gradeId);
    public function deleteScheduleUser($id);
    public function getScheduleUserById($id);
    public function updateScheduleUser($id, $scheduleId, $userId, $gradeId);
    public function getUsersForSchedule($scheduleId);
    public function deleteByStudentAndSchedule($scheduleId, $studentId);
    public function getGradesForStudentAndSchedule($scheduleId, $studentId);

}