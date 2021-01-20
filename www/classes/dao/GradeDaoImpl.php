<?php
require_once("./classes/dao/GradeDao.php");
require_once("./classes/Connection.php");

class GradeDaoImpl implements GradeDao
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Connection::getPdoInstance();
    }

    public function getAllGrades(): array
    {
        $stmt = $this->_db->prepare("SELECT * FROM Grade");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertGrade($grade, $type)
    {
        $now = date_create()->format('Y-m-d');
        $stmt = $this->_db->prepare("INSERT INTO Grade(grade, date_created, type)
         VALUES(:grade, :date, :type)");
        $stmt->bindParam(":grade", $grade);
        $stmt->bindParam(":date", $now);
        $stmt->bindParam(":type", $type); //Type is task name/grade description.
        $stmt->execute();
        return $this->_db->lastInsertId(); //When teacher is creating grade, he also assign that grade to student, so we need last inserted grade
    }

    public function deleteGradeById($gradeId)
    {
        $stmt = $this->_db->prepare("DELETE FROM Grade WHERE id = :id");
        $stmt->bindParam(":id", $gradeId);
        $stmt->execute();
    }

    public function getGradeById($gradeId)
    {
        $stmt = $this->_db->prepare("SELECT * FROM Grade WHERE id = :id");
        $stmt->bindParam(":id", $gradeId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateGrade($id, $grade, $type)
    {
        $stmt = $this->_db->prepare("UPDATE Grade SET
                grade = :grade,
                type = :type WHERE id = :id");

        $stmt->bindParam(":grade", $grade);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}