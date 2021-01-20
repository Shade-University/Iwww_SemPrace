<?php


interface GradeDao
{
    public function getAllGrades(): array;

    public function insertGrade($grade, $type);

    public function deleteGradeById($gradeId);

    public function getGradeById($gradeId);

    public function updateGrade($id, $grade, $type);
}