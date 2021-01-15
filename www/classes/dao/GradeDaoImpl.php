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

    function getAllGrades()
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
        $stmt->bindParam(":type", $type);
        $stmt->execute();
    }

    public function deleteGrade($gradeId)
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