<?php
require_once './classes/validators/Validator.php';

class GradeValidator implements Validator
{

    public function validate($data, &$msg): bool
    {
        $validGrades = array("A", "B", "C", "D", "E", "F");
        if (empty($data['grade']) ||
            empty($data['type'])) {
            $msg = "Grade or type cannot be empty";
            return false;
        }

        if (!in_array($data['grade'], $validGrades)) {
            $msg = "Grade can be only A/B/C/D/E/F";
            return false;
        }

        return true;
    }
}