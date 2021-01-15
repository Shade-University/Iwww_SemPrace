<?php
require_once './classes/Helpers.php';
require_once './classes/dao/SubjectDaoImpl.php';

class SubjectsController
{
    protected $_subjectDao;

    public function __construct()
    {
        $this->_subjectDao = new SubjectDaoImpl();
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

        echo '</table';
    }

    public function createSubject($data)
    {
        $errorMsg = "";
        if ($this->validateSubject($data, $errorMsg)) {
            $this->_subjectDao->insertSubject($data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteSubject($subjectId)
    {
        $this->_subjectDao->deleteSubject($subjectId);
    }

    public function getSubject($subjectId)
    {
        return $this->_subjectDao->getSubjectById($subjectId);
    }

    public function updateSubject($data)
    {
        $errorMsg = "";
        if ($this->validateSubject($data, $errorMsg)) {
            $this->_subjectDao->updateSubject($data['id'], $data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    private function validateSubject($data, &$msg)
    {
        if (empty($data['name'])) {
            $msg = "Subject name cannot be empty";
            return false;
        } else if (strlen($data['name']) > 250
            || strlen($data['description']) > 500) {
            $msg = "Max size exceeded";
            return false;
        }

        if($this->_subjectDao->getSubjectByName($data['name']) != null) {
            $msg = "Subject with same name already exists";
            return false;
        }

        return true;
    }


}