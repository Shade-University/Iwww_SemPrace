<?php


interface ScheduleUserDao
{
    function getAllScheduleUsers();
    public function insertScheduleUser($scheduleId, $userId, $gradeId);
    public function deleteScheduleUser($scheduleId);
    public function getScheduleUserByScheduleId($scheduleId);
    public function updateScheduleUser($id, $scheduleId, $userId, $gradeId);
}