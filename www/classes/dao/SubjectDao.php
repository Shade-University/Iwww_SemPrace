<?php


interface SubjectDao
{
    public function getAllSubjects(): array;

    public function insertSubject($name, $description);

    public function deleteSubjectById($subjectId);

    public function getSubjectById($subjectId);

    public function updateSubject($id, $name, $description);

    public function getSubjectByName($name);

}