<?php
require_once './classes/Helpers.php';
require_once './classes/dao/GradeDaoImpl.php';

class GradesController
{
    protected $_gradeDao;

    public function __construct()
    {
        $this->_gradeDao = new GradeDaoImpl();
    }

    public function createGradeTable()
    {
        $headers = array('ID', 'Grade', 'Date created', 'Type', 'Actions');
        $grades = $this->_gradeDao->getAllGrades();

        echo '<table id="gradesTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($grades as $grade) {
            echo '<tr>';
            echo '<td>' . $grade['id'] . '</td>';
            echo '<td>' . $grade['grade'] . '</td>';
            echo '<td>' . $grade['date_created'] . '</td>';
            echo '<td>' . $grade['type'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&crud=Grades&deleteGrade=' . $grade['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-grade"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&crud=Grades&editGrade=' . $grade['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="grade-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createGrade($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_gradeDao->insertGrade($data['grade'], $data['type']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteGrade($gradeId)
    {
        $this->_gradeDao->deleteGradeById($gradeId);
    }

    public function getGrade($gradeId)
    {
        return $this->_gradeDao->getGradeById($gradeId);
    }

    public function updateGrade($data)
    {
        $errorMsg = "";
        if ($this->validate($data, $errorMsg)) {
            $this->_gradeDao->updateGrade($data['id'], $data['grade'], $data['type']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    private function validate($data, &$msg)
    {
        if (empty($data['grade']) ||
            empty($data['type'])) {
            $msg = "Grade or type cannot be empty";
            return false;
        }

        if ($data['grade'] != "A"
            && $data['grade'] != "B"
            && $data['grade'] != "C"
            && $data['grade'] != "D"
            && $data['grade'] != "E"
            && $data['grade'] != "F") {
            $msg = "Grade can be only A/B/C/D/E/F";
            return false;
        }

        return true;
    }


}