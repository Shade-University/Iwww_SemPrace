<?php
require_once './classes/validators/Validator.php';

class RoomValidator implements Validator
{
    public function validate($data, &$msg): bool
    {
        if(empty($data['name']) ||
            empty($data['capacity'])) {
            $msg = "Cannot be empty";
            return false;
        }
        if(!is_numeric($data['capacity'])) {
            $msg = "Capacity must be number";
            return false;
        }

        return true;
    }
}