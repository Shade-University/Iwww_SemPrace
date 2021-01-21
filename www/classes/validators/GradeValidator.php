<?php
require_once './classes/validators/Validator.php';

class GradeValidator implements Validator
{

    public function validate($data, &$msg): bool
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