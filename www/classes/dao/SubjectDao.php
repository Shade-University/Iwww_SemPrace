<?php


interface SubjectDao
{
    function getAllSubjects();
    public function insertSubject($name, $description);
    public function deleteSubject($subjectId);
    public function getSubjectById($subjectId);
    public function updateSubject($id, $name, $description);
    public function getSubjectByName($name);

}