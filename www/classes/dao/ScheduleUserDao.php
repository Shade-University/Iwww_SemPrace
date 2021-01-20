<?php


interface ScheduleUserDao
{
    public function getAllScheduleUsers(): array;

    public function insertScheduleUser($scheduleId, $userId, $gradeId);

    public function deleteScheduleUserById($id);

    public function getScheduleUserById($id);

    public function updateScheduleUser($id, $scheduleId, $userId, $gradeId);

    public function getScheduleUserByScheduleId($scheduleId): array;

    public function deleteScheduleUserByScheduleIdAndUserId($scheduleId, $userId);

    public function getScheduleUserByScheduleIdAndUserId($scheduleId, $userId): array;

    public function getScheduleUserByUserId($userId): array;


}