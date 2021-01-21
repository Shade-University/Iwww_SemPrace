<?php
require_once './classes/dao/SubjectDao.php';
require_once './classes/validators/Validator.php';

class SubjectValidator implements Validator
{
    protected $_subjectDao;

    public function __construct(SubjectDao $subjectDao)
    {
        $this->_subjectDao = $subjectDao;
    }

    public function validate($data, &$msg): bool
    {
        if (empty($data['name'])) {
            $msg = "Subject name cannot be empty";
            return false;
        } else if (strlen($data['name']) > 250
            || strlen($data['description']) > 500) {
            $msg = "Max size exceeded";
            return false;
        }

        if ($data['action'] != "editSubject") {
            if ($this->_subjectDao->getSubjectByName($data['name']) != null) {
                $msg = "Subject with same name already exists";
                return false;
            }
        }

        return true;
    }

}