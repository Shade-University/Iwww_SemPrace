<?php
require_once './classes/Helpers.php';
require_once './classes/dao/SubjectDaoImpl.php';
require_once  './classes/validators/SubjectValidator.php';

class SubjectsController
{
    protected $_subjectDao;
    protected $_subjectValidator;

    public function __construct()
    {
        $this->_subjectDao = new SubjectDaoImpl();
        $this->_subjectValidator = new SubjectValidator($this->_subjectDao);
    }

    public function createSubjectTable()
    {
        $headers = array('ID', 'Name', 'Description', 'Actions');
        $subjects = $this->_subjectDao->getAllSubjects();

        echo '<table id="subjectsTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($subjects as $subject) {
            echo '<tr>';
            echo '<td>' . $subject['id'] . '</td>';
            echo '<td>' . $subject['name'] . '</td>';
            echo '<td>' . $subject['description'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&crud=Subjects&deleteSubject=' . $subject['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-subject"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&crud=Subjects&editSubject=' . $subject['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="subject-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';
            echo '</tr>';
        }

        echo '</table>';
    }

    public function createSubject($data)
    {
        $errorMsg = "";
        if ($this->_subjectValidator->validate($data, $errorMsg)) {
            $this->_subjectDao->insertSubject($data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteSubject($subjectId)
    {
        $this->_subjectDao->deleteSubjectById($subjectId);
    }

    public function getSubject($subjectId)
    {
        return $this->_subjectDao->getSubjectById($subjectId);
    }

    public function updateSubject($data)
    {
        $errorMsg = "";
        if ($this->_subjectValidator->validate($data, $errorMsg)) {
            $this->_subjectDao->updateSubject($data['id'], $data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }
}