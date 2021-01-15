<?php


interface GradeDao
{
    function getAllGrades();
    public function insertGrade($grade, $type);
    public function deleteGrade($gradeId);
    public function getGradeById($gradeId);
    public function updateGrade($id, $grade, $type);
}