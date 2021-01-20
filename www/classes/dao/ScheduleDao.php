<?php


interface ScheduleDao
{
    public function getAllSchedules(): array;

    public function insertSchedule($day, $lesson_start, $lesson_end, $subjectId, $roomId);

    public function deleteScheduleById($scheduleId);

    public function getScheduleById($scheduleId);

    public function updateSchedule($id, $day, $lesson_start, $lesson_end, $subjectId, $roomId);

    public function getSchedulesBySubjectId($subjectId): array;
}