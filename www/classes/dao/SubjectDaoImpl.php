<?php

require_once("./classes/dao/SubjectDao.php");
require_once("./classes/Connection.php");

class SubjectDaoImpl implements SubjectDao
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Connection::getPdoInstance();
    }

    public function getAllSubjects(): array
    {
        $stmt = $this->_db->prepare("SELECT * FROM Subject");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertSubject($name, $description)
    {
        $stmt = $this->_db->prepare("INSERT INTO Subject(name, description)
         VALUES(:name, :description)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->execute();
    }

    public function deleteSubjectById($subjectId)
    {
        $stmt = $this->_db->prepare("DELETE FROM Subject WHERE id = :id");
        $stmt->bindParam(":id", $subjectId);
        $stmt->execute();
    }

    public function getSubjectById($subjectId)
    {
        $stmt = $this->_db->prepare("SELECT * FROM Subject WHERE id = :id");
        $stmt->bindParam(":id", $subjectId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateSubject($id, $name, $description)
    {
        $stmt = $this->_db->prepare("UPDATE Subject SET
                name = :name,
                description = :description WHERE id = :id");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function getSubjectByName($name)
    {
        $stmt = $this->_db->prepare("SELECT * FROM Subject WHERE name = :name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch();
    }
}