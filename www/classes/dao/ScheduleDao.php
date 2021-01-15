<?php


interface ScheduleDao
{
    function getAllSchedules();
    public function insertSchedule($day, $lesson_start, $lesson_end, $subjectId, $roomId);
    public function deleteSchedule($scheduleId);
    public function getScheduleById($scheduleId);
    public function updateSchedule($id, $day, $lesson_start, $lesson_end, $subjectId, $roomId);
}